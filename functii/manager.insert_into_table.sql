CREATE OR REPLACE PACKAGE manager AS
  TYPE v_array IS TABLE OF VARCHAR(10) INDEX BY BINARY_INTEGER;
  PROCEDURE insert_into_table(table_name in VARCHAR2, id_name in VARCHAR2, type_column in v_array, data in v_array, result out VARCHAR2);
END manager;
/

CREATE OR REPLACE PACKAGE BODY manager AS
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
END manager;
