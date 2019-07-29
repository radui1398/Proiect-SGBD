CREATE OR REPLACE PACKAGE manager AS
    TYPE v_array IS TABLE OF VARCHAR(10000) INDEX BY BINARY_INTEGER;
    PROCEDURE insert_into_table(table_name in VARCHAR2, id_name in VARCHAR2, type_column in v_array, data in v_array,
                                result out VARCHAR2);
    PROCEDURE update_entry_table(table_name in VARCHAR2, id_name in VARCHAR2, type_column in v_array, data in v_array,
                                result out VARCHAR2);
    PROCEDURE show_last_transactions(p_arr out v_array);
    PROCEDURE show_due_date(p_arr OUT v_array);
    PROCEDURE bank_cnp(cnp IN VARCHAR2, result OUT VARCHAR2);
    PROCEDURE top_used_atm(p_arr OUT v_array);
    PROCEDURE top_bank(p_arr OUT v_array);
    PROCEDURE delete_low_bank;
    PROCEDURE delete_old_transactions(number_months IN NUMBER);
    PROCEDURE delete_from_table(table_name in VARCHAR2, id_name in VARCHAR2);
    PROCEDURE select_data(table_name in VARCHAR2, v_start in NUMBER, v_end in NUMBER, result out v_array);
    FUNCTION atm_last_transaction(no_atm NUMBER) RETURN VARCHAR2;
    FUNCTION responsible_manager RETURN VARCHAR2;
    FUNCTION get_no_transactions(v_CNP VARCHAR2) RETURN NUMBER;
    FUNCTION get_rejected_transactions RETURN v_array;
    FUNCTION no_of_lines(table_name IN VARCHAR2) RETURN NUMBER;
    PROCEDURE sql_injection(id in VARCHAR2, result out VARCHAR2);
    PROCEDURE sql_not_injection(id in VARCHAR2, result out VARCHAR2);
    PROCEDURE INSERT_LONG_LAT_INTO_ATM(lat IN DOUBLE PRECISION ,  long IN DOUBLE PRECISION, id in NUMBER);
    FUNCTION compute_distance (lat1 IN NUMBER,long1 IN NUMBER, lat2 IN NUMBER, long2 IN NUMBER,radius IN NUMBER DEFAULT 3963)
    RETURN NUMBER;
    PROCEDURE find_min_distance(lat1 IN NUMBER,long1 IN NUMBER,lat2 OUT NUMBER,long2 OUT NUMBER);
END manager;
/

CREATE OR REPLACE PACKAGE BODY manager IS
    PROCEDURE insert_into_table(table_name in VARCHAR2, id_name in VARCHAR2, type_column in v_array, data in v_array,
                                result out VARCHAR2) IS
        insert_clause  VARCHAR2(10000);
        v_var          VARCHAR2(5000);
        v_count        NUMBER(38);
        l_single_quote CHAR(1) := '''';
        v_i            NUMBER(38);
    BEGIN
        v_count := 0;
        insert_clause := 'INSERT INTO ';
        insert_clause := insert_clause || table_name;
        insert_clause := insert_clause || '(' || id_name || ',';

        v_count := type_column.COUNT;
        v_i := 1;
        LOOP
            insert_clause := insert_clause || type_column(v_i);
            EXIT WHEN v_i = v_count;
            v_i := v_i + 1;
            insert_clause := insert_clause || ',';
        END LOOP;
        insert_clause := INSERT_CLAUSE || ') values ((SELECT max(' || id_name || ')+1 FROM ' || table_name || '),';

        v_i := 1;
        LOOP
            IF data(v_i) = 'sysdate' THEN
                insert_clause := insert_clause || 'sysdate';
            ELSE
                insert_clause := insert_clause || l_single_quote || data(v_i) || l_single_quote;
            END IF;
            EXIT WHEN v_i = v_count;
            v_i := v_i + 1;
            insert_clause := insert_clause || ',';
        END LOOP;
        insert_clause := INSERT_CLAUSE || ')';
        EXECUTE IMMEDIATE insert_clause;
        result := 'Inserarea a reusit!';
    EXCEPTION
        WHEN DUP_VAL_ON_INDEX THEN
            result := 'Datele introduse nu corespund cu baza de date.';
    END insert_into_table;

    PROCEDURE show_last_transactions(p_arr out v_array) IS
    BEGIN
        SELECT CARD_ID || '%' || ATM_ID || '%' || TRANSACTION_DATE || '%' || SUM || ' Lei' bulk COLLECT into p_arr
        from (select * FROM TRANSACTION ORDER BY TRANSACTION_DATE DESC)
        WHERE ROWNUM < 11;
    END show_last_transactions;

    PROCEDURE show_due_date(p_arr OUT v_array) IS
    BEGIN
        SELECT fname || ' ' || lname || '%' || CARD_NUMBER || '%' || EXP BULK COLLECT INTO p_arr
        FROM (SELECT c.card_number, c.exp, c1.fname, c1.lname
              FROM card c
                       JOIN has h ON c.fk_id = h.account_id
                       JOIN clients c1 ON c1.id = h.CLIENT_ID
              WHERE c.exp < SYSDATE);
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            p_arr(1) := 'Nu am gasit nici un card.';
    END show_due_date;

    PROCEDURE bank_cnp(cnp IN VARCHAR2, result OUT VARCHAR2) IS
        v_id_client NUMBER(10);
        sql_stmt    VARCHAR2(500);
    BEGIN
        sql_stmt := 'SELECT ID FROM clients WHERE clients.CNP=:1';
        EXECUTE IMMEDIATE sql_stmt INTO v_id_client USING cnp;
        sql_stmt := 'SELECT ba.name FROM bank ba join branch br on ba.id=br.bank_id join managers ma on ma.fk_id=br.subsidiary_id
   join handles ha on ha.manager_id=ma.id where ha.client_id=:1';
        EXECUTE IMMEDIATE sql_stmt INTO result USING V_ID_CLIENT;
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            result := 'Acest client nu exista.';
    END bank_cnp;

    PROCEDURE top_used_atm(p_arr out v_array) IS
        sql_stmt VARCHAR2(500);
    BEGIN
        SELECT ATM_ID || '%' || PLACE || '%' || "COUNTED" BULK COLLECT INTO p_arr
        from (SELECT ATM_ID, PLACE, "COUNTED"
              FROM (select T.ATM_ID, A.PLACE, COUNT(*) as "COUNTED"
                    FROM TRANSACTION T
                             JOIN ATM A ON A.ATM_NO = T.ATM_ID
                    GROUP BY ATM_ID, A.PLACE)
              ORDER BY COUNTED desc)
        WHERE ROWNUM < 6;
    END top_used_atm;

    PROCEDURE top_bank(p_arr out v_array) IS
        sql_stmt VARCHAR2(5000);
    BEGIN
        SELECT NAME || '%' || ADDRESS || '%' || "COUNTED" BULK COLLECT INTO p_arr
        FROM (SELECT *
              FROM (SELECT name, address, SUM("COUNTED") AS "COUNTED"
                    FROM (SELECT ba.name, ba.address, COUNT(*) AS "COUNTED"
                          FROM bank ba
                                   join branch br on ba.id = br.bank_id
                                   join managers ma on ma.fk_id = br.subsidiary_id
                                   join handles ha on ha.manager_id = ma.id
                          GROUP BY ha.manager_id, ba.name, ba.address)
                    GROUP BY NAME, ADDRESS)
              ORDER BY "COUNTED" DESC)
        WHERE ROWNUM < 6;
    END top_bank;

    PROCEDURE delete_low_bank IS
        sql_stmt VARCHAR2(500);
        bank_id  NUMBER(10);
    BEGIN
        sql_stmt := 'SELECT IDBANK FROM (SELECT * FROM (SELECT IDBANK,SUM("COUNTED") AS "COUNTED" FROM (SELECT ba.id as "IDBANK",COUNT(*) AS "COUNTED" FROM
    bank ba join branch br on ba.id=br.bank_id join managers ma on ma.fk_id=br.subsidiary_id
    join handles ha on ha.manager_id=ma.id GROUP BY ha.manager_id,ba.id) GROUP BY IDBANK) ORDER BY "COUNTED" ASC) WHERE ROWNUM<2';
        EXECUTE IMMEDIATE sql_stmt INTO BANK_ID;
        sql_stmt := 'DELETE FROM BANK WHERE ID=:1';
        EXECUTE IMMEDIATE sql_stmt USING BANK_ID;
    END delete_low_bank;

    PROCEDURE delete_old_transactions(number_months in NUMBER) IS
        sql_stmt VARCHAR2(500);
    BEGIN
        sql_stmt := 'DELETE FROM TRANSACTION WHERE MONTHS_BETWEEN(SYSDATE,TRANSACTION_DATE)>=:1';
        EXECUTE IMMEDIATE sql_stmt USING number_months;
    END DELETE_OLD_TRANSACTIONS;

    FUNCTION atm_last_transaction(no_atm NUMBER) RETURN VARCHAR2 AS
        date_last_transaction VARCHAR2(20) := 'NO TRANSACTION';
        format_date           VARCHAR2(10) := 'DD-MM-YYYY';
        sql_stmt              VARCHAR2(500);
    BEGIN
        sql_stmt := 'SELECT TO_CHAR(TRANSACTION_DATE,:1)
    FROM (SELECT TRANSACTION_DATE FROM TRANSACTION WHERE ATM_ID=:2
    ORDER BY TRANSACTION_DATE) WHERE ROWNUM<2';
        EXECUTE IMMEDIATE sql_stmt INTO date_last_transaction USING FORMAT_DATE, NO_ATM;
        return date_last_transaction;
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            return 'ID-ul ATM-ului este invalid sau nu au fost realizate tranzactii.';
    END atm_last_transaction;


    FUNCTION responsible_manager RETURN VARCHAR2 AS
        manager_name VARCHAR2(200);
        sql_stmt     VARCHAR2(500);
        SPACE        VARCHAR2(2) := ' ';
    BEGIN
        sql_stmt := 'SELECT FNAME||:1||LNAME FROM (SELECT * FROM (SELECT M.FNAME,
   M.LNAME,M.ID,COUNT(M.ID) AS "COUNTABLE"
   FROM MANAGERS M JOIN EMPLOYER E ON M.ID=E.MANAGER_ID
   JOIN EMPLOYEES EM ON EM.ID=E.EMPLOYEE_ID GROUP BY M.ID,M.FNAME,
   M.LNAME) ORDER BY "COUNTABLE" DESC)
   WHERE ROWNUM<2';
        EXECUTE IMMEDIATE sql_stmt INTO manager_name USING SPACE;
        RETURN manager_name;
    END responsible_manager;

    FUNCTION get_no_transactions(v_CNP VARCHAR2) RETURN NUMBER AS
        v_transactions NUMBER(10);
        sql_stmt       VARCHAR2(500);
    BEGIN
        sql_stmt := 'SELECT count(c.id) FROM clients c
    join has h on c.ID=h.client_id
    join accounts a on a.id=h.account_id
    join card c1 on c1.fk_id=h.account_id
    join transaction t on t.card_id=c1.id where c.CNP=:cnp group by c.id';
        EXECUTE IMMEDIATE sql_stmt INTO v_transactions USING v_CNP;
        RETURN v_transactions;
    EXCEPTION
        WHEN NO_DATA_FOUND THEN return 0; ---'Tranzactiile clientului cu CNP-ul specificat nu are tranzactii.'
    END get_no_transactions;

    FUNCTION get_rejected_transactions RETURN v_array AS
        v_transactions NUMBER(10);
        p_arr          v_array;
    BEGIN
        SELECT t.id || '%' || c1.exp || '%' || t.TRANSACTION_DATE BULK COLLECT INTO p_arr
        FROM card c1
                 join transaction t on t.card_id = c1.id
        where c1.exp < t.TRANSACTION_DATE
          AND t.TRANSACTION_DATE < sysdate;
        RETURN p_arr;
    END get_rejected_transactions;

    FUNCTION no_of_lines(table_name IN VARCHAR2) RETURN NUMBER AS
        no_entries NUMBER(10);
        sql_stmt   VARCHAR2(500);
    BEGIN
        sql_stmt := 'SELECT count(*) FROM ' || table_name;
        EXECUTE IMMEDIATE sql_stmt INTO no_entries;
        RETURN no_entries;
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            RETURN -1; --- 'Tabeleul nu este populat'
    END no_of_lines;

    PROCEDURE select_data(table_name in VARCHAR2, v_start in NUMBER, v_end in NUMBER, result out v_array) IS
        sql_stmt        VARCHAR2(5000);
        sql_string      varchar2(5000);
        v_cursor        integer;
        l_column        varchar2(4000);
        l_status        integer;
        l_describeTable dbms_sql.desc_tab;
        l_count         NUMBER;
        v_count_lines   NUMBER := 1;
    BEGIN
        v_cursor := dbms_sql.open_cursor;
        SQL_STMT:='SELECT * FROM (SELECT m.* ,ROWNUM r FROM '|| table_name|| ' m) WHERE r>'||(v_start-1)||' AND r<'||(v_end+1) ;
        dbms_sql.parse(v_cursor, SQL_STMT, dbms_sql.native);

        dbms_sql.describe_columns(v_cursor, l_count, l_describeTable);

        for i in 1 .. l_count
            loop
                dbms_sql.define_column(v_cursor, i, l_column, 4000);
            end loop;

        sql_string:=l_describeTable(1).col_name;
        FOR i IN 2 .. l_count-1 LOOP
             sql_string := sql_string || '%' || l_describeTable(i).col_name;
        END LOOP;
        result(1) := sql_string;

        l_status := dbms_sql.execute(v_cursor);
        while (dbms_sql.fetch_rows(v_cursor) > 0)
            LOOP
                v_count_lines := v_count_lines + 1;
                dbms_sql.column_value(v_cursor, 1, l_column);
                sql_string := l_column;
                for i in 2 .. l_count-1
                    loop
                        dbms_sql.column_value(v_cursor, i, l_column);
                        sql_string := sql_string || '%' || l_column;
                    end loop;
                result(v_count_lines) := sql_string;
            end loop;
    exception
        when others then dbms_sql.close_cursor(v_cursor); RAISE;
    END select_data;

    PROCEDURE delete_from_table(table_name in VARCHAR2, id_name in VARCHAR2) IS
    sql_stmt  VARCHAR2(500);
    BEGIN
        sql_stmt := 'DELETE FROM :1 WHERE ID=:2';
        EXECUTE IMMEDIATE sql_stmt USING table_name,id_name;
    END delete_from_table;

    PROCEDURE update_entry_table(table_name in VARCHAR2, id_name in VARCHAR2, type_column in v_array, data in v_array,
                                result out VARCHAR2) IS
        update_clause  VARCHAR2(10000);
        v_var          VARCHAR2(5000);
        v_count        NUMBER(38);
        l_single_quote CHAR(1) := '''';
        v_i            NUMBER(38);
    BEGIN
        v_count := 0;
        update_clause := 'UPDATE ';
        update_clause := update_clause || table_name;
        update_clause := update_clause || ' SET ';
        v_count := type_column.COUNT;

        update_clause := update_clause || type_column(2)||' = '|| l_single_quote || data(2) || l_single_quote;
        v_i := 3;

        LOOP
            EXIT WHEN v_i = v_count+1;
             IF (data(v_i) != 'sysdate')
             THEN
              update_clause := update_clause ||' , '|| type_column(v_i)||' = '|| l_single_quote || data(v_i) || l_single_quote;
             END IF;
             v_i := v_i + 1;
        END LOOP;
        update_clause := update_clause||' WHERE '||type_column(1)||' = :1';
       EXECUTE IMMEDIATE update_clause USING data(1);
        result := 'Update-ul a fost realizat cu succes';
    END update_entry_table;

    PROCEDURE sql_injection(id in VARCHAR2, result out VARCHAR2) IS
       sqlstm varchar2(1000);
    BEGIN
        sqlstm := 'SELECT name FROM BANK WHERE id=''' || id || '''';
        EXECUTE IMMEDIATE sqlstm into result;
    END sql_injection;

    PROCEDURE sql_not_injection(id in VARCHAR2, result out VARCHAR2) IS
       sqlstm varchar2(1000);
    BEGIN
        sqlstm := 'SELECT name FROM BANK WHERE id=:1';
        EXECUTE IMMEDIATE sqlstm into result using id;
        EXCEPTION
        WHEN INVALID_NUMBER THEN
            result := 'Nu este permisa injectarea.';
    END sql_not_injection;

    PROCEDURE INSERT_LONG_LAT_INTO_ATM(lat IN DOUBLE PRECISION ,  long IN DOUBLE PRECISION, id in NUMBER) IS
    v_count NUMBER;
    sql_stmt VARCHAR2(5000);
    BEGIN
        sql_stmt:='UPDATE ATM SET latitudine='|| lat ||', longitudine=' || long || ' WHERE ATM_NO=' || id;
        EXECUTE IMMEDIATE SQL_STMT;
    END;

    FUNCTION compute_distance (lat1 IN NUMBER,long1 IN NUMBER, lat2 IN NUMBER, long2 IN NUMBER,radius IN NUMBER DEFAULT 3963)
    RETURN NUMBER IS
    degreesToRadius NUMBER := 57.29577951;
    BEGIN
    RETURN(NVL(radius,0) * ACOS((SIN(NVL(lat1,0) / degreesToRadius) * SIN(NVL(lat2,0) / degreesToRadius)) +
            (COS(NVL(lat1,0) / degreesToRadius) * COS(NVL(lat2,0) / degreesToRadius) *
             COS(NVL(long2,0) / degreesToRadius - NVL(long1,0)/ degreesToRadius))));
    END compute_distance;

    PROCEDURE find_min_distance(lat1 IN NUMBER,long1 IN NUMBER,lat2 OUT NUMBER,long2 OUT NUMBER) AS
    sql_stmt VARCHAR2(1000);
    BEGIN
          sql_stmt:='SELECT latitudine,longitudine
         FROM (SELECT latitudine,longitudine,manager.compute_distance(latitudine,longitudine,lat1,long1) as "distance"
         from ATM ORDER BY "distance" desc) where rownum<2';
          EXECUTE IMMEDIATE sql_stmt INTO lat2,long2;
    END find_min_distance;
END manager;
