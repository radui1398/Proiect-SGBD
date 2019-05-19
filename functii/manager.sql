CREATE OR REPLACE PACKAGE manager AS
  TYPE v_array IS TABLE OF VARCHAR(100) INDEX BY BINARY_INTEGER;
  PROCEDURE insert_into_table(table_name in VARCHAR2, id_name in VARCHAR2, type_column in v_array, data in v_array, result out VARCHAR2);
  PROCEDURE show_last_transactions(p_arr out v_array);
  PROCEDURE show_due_date(p_arr OUT v_array);
  PROCEDURE bank_cnp(cnp IN VARCHAR2, result OUT VARCHAR2);
  PROCEDURE top_bank(result OUT VARCHAR2);
  PROCEDURE delete_low_bank;
  PROCEDURE delete_old_transactions(number_months IN NUMBER);
  FUNCTION atm_last_transaction(no_atm NUMBER) RETURN VARCHAR2;
END manager;
/

CREATE OR REPLACE PACKAGE BODY manager IS
PROCEDURE insert_into_table(table_name in VARCHAR2, id_name in VARCHAR2, type_column in v_array, data in v_array, result out VARCHAR2) IS
insert_clause VARCHAR2(10000);
v_var VARCHAR2(500);
v_count NUMBER(10);
l_single_quote CHAR(1) := '''';
v_i NUMBER(10);
BEGIN
    v_count:=0;
    insert_clause:='INSERT INTO ';
    insert_clause:=insert_clause||table_name;
    insert_clause:=insert_clause||'(' || id_name || ',';

    v_count:=type_column.COUNT;
    v_i:=1;
    LOOP
        insert_clause:=insert_clause||type_column(v_i);
        EXIT WHEN v_i=v_count;
        v_i:=v_i+1;
        insert_clause:=insert_clause||',';
    END LOOP;
    insert_clause:=INSERT_CLAUSE||') values ((SELECT max(' || id_name || ')+1 FROM ' || table_name ||'),';

    v_i:=1;
    LOOP
        insert_clause:=insert_clause||l_single_quote||data(v_i)||l_single_quote;
        EXIT WHEN v_i=v_count;
        v_i:=v_i+1;
        insert_clause:=insert_clause||',';
    END LOOP;
    insert_clause:=INSERT_CLAUSE||')';
    EXECUTE IMMEDIATE insert_clause;
    result := insert_clause;
END insert_into_table;

PROCEDURE show_last_transactions(p_arr out v_array) IS
BEGIN
     SELECT CARD_ID || '%' || ATM_ID || '%' || TRANSACTION_DATE || '%' || SUM || ' Lei' bulk COLLECT into p_arr from (select * FROM TRANSACTION ORDER BY TRANSACTION_DATE DESC) WHERE ROWNUM<11;
END show_last_transactions;

PROCEDURE show_due_date(p_arr OUT v_array) IS 
BEGIN 
     SELECT fname || ' ' || lname || '%' || CARD_NUMBER || '%' || EXP
     BULK COLLECT INTO p_arr FROM (SELECT c.card_number,c.exp,c1.fname,c1.lname FROM card c
     JOIN has h ON c.fk_id=h.account_id 
     JOIN clients c1 ON c1.id=h.CLIENT_ID WHERE c.exp<SYSDATE);
     EXCEPTION
     WHEN NO_DATA_FOUND THEN
     p_arr(1) := 'Nu am gasit nici un card.';
END show_due_date;

PROCEDURE bank_cnp(cnp IN VARCHAR2, result OUT VARCHAR2) IS 
v_id_client NUMBER(10);
sql_stmt VARCHAR2(500);
BEGIN
   sql_stmt := 'SELECT ID FROM clients WHERE clients.CNP=:1';
   EXECUTE IMMEDIATE sql_stmt INTO v_id_client USING cnp;
   sql_stmt:='SELECT ba.name FROM bank ba join branch br on ba.id=br.bank_id join managers ma on ma.fk_id=br.subsidiary_id 
   join handles ha on ha.manager_id=ma.id where ha.client_id=:1';
   EXECUTE IMMEDIATE sql_stmt INTO result USING V_ID_CLIENT;
END bank_cnp;

PROCEDURE top_used_atm(p_arr out v_array) IS
sql_stmt VARCHAR2(500);
BEGIN
    SELECT ATM_ID BULK COLLECT INTO p_arr from (SELECT ATM_ID FROM (select ATM_ID,COUNT(*) FROM TRANSACTION GROUP BY ATM_ID) ORDER BY COUNT(*)) WHERE ROWNUM<6;
END TOP_USED_ATM;

PROCEDURE top_bank(result OUT VARCHAR2) IS 
sql_stmt VARCHAR2(500);
BEGIN
sql_stmt:='SELECT NAME FROM (SELECT * FROM (SELECT name,SUM("COUNTED") AS "COUNTED" FROM (SELECT ba.name,COUNT(*) AS "COUNTED" FROM
 bank ba join branch br on ba.id=br.bank_id join managers ma on ma.fk_id=br.subsidiary_id 
 join handles ha on ha.manager_id=ma.id GROUP BY ha.manager_id,ba.name) GROUP BY NAME) ORDER BY "COUNTED" DESC) WHERE ROWNUM<2';
   EXECUTE IMMEDIATE sql_stmt INTO result;
END top_bank;

PROCEDURE delete_low_bank IS
sql_stmt VARCHAR2(500);
bank_id NUMBER(10);
BEGIN
sql_stmt:='SELECT IDBANK FROM (SELECT * FROM (SELECT IDBANK,SUM("COUNTED") AS "COUNTED" FROM (SELECT ba.id as "IDBANK",COUNT(*) AS "COUNTED" FROM
    bank ba join branch br on ba.id=br.bank_id join managers ma on ma.fk_id=br.subsidiary_id 
    join handles ha on ha.manager_id=ma.id GROUP BY ha.manager_id,ba.id) GROUP BY IDBANK) ORDER BY "COUNTED" ASC) WHERE ROWNUM<2';
   EXECUTE IMMEDIATE sql_stmt INTO BANK_ID;
   sql_stmt:='DELETE FROM BANK WHERE ID=:1';
   EXECUTE IMMEDIATE sql_stmt USING BANK_ID;
END delete_low_bank;

PROCEDURE delete_old_transactions(number_months in NUMBER) IS 
sql_stmt VARCHAR2(500);
BEGIN
    sql_stmt:='DELETE FROM TRANSACTION WHERE MONTHS_BETWEEN(SYSDATE,TRANSACTION_DATE)>=:1'; 
    EXECUTE IMMEDIATE sql_stmt USING number_months;
END DELETE_OLD_TRANSACTIONS;

FUNCTION atm_last_transaction(no_atm NUMBER) RETURN VARCHAR2 AS
date_last_transaction VARCHAR2(20) := 'NO TRANSACTION';
format_date VARCHAR2(10):='DD-MM-YYYY';
sql_stmt VARCHAR2(500);
BEGIN
    sql_stmt:='SELECT TO_CHAR(TRANSACTION_DATE,:1) 
    FROM (SELECT TRANSACTION_DATE FROM TRANSACTION WHERE ATM_ID=:2 
    ORDER BY TRANSACTION_DATE) WHERE ROWNUM<2';
    EXECUTE IMMEDIATE sql_stmt INTO date_last_transaction USING FORMAT_DATE, NO_ATM;
    return date_last_transaction;
END atm_last_transaction;
END manager;
