﻿SET SERVEROUTPUT ON;
BEGIN
DBMS_OUTPUT.PUT_LINE(manager.ATM_LAST_TRANSACTION(2));
END;

SELECT NAME FROM (SELECT * FROM (SELECT name,SUM("COUNTED") AS "COUNTED" FROM (SELECT ba.name,COUNT(*) AS "COUNTED" FROM
 bank ba join branch br on ba.id=br.bank_id join managers ma on ma.fk_id=br.subsidiary_id 
 join handles ha on ha.manager_id=ma.id GROUP BY ha.manager_id,ba.name) GROUP BY NAME) ORDER BY "COUNTED" DESC) WHERE ROWNUM<2;

SELECT IDBANK,COUNTED FROM (SELECT * FROM (SELECT IDBANK,SUM("COUNTED") AS "COUNTED" FROM (SELECT ba.id as "IDBANK",COUNT(*) AS "COUNTED" FROM
    bank ba join branch br on ba.id=br.bank_id join managers ma on ma.fk_id=br.subsidiary_id 
    join handles ha on ha.manager_id=ma.id GROUP BY ha.manager_id,ba.id) GROUP BY IDBANK) ORDER BY "COUNTED" ASC);
    SELECT TRANSACTION_DATE FROM TRANSACTION WHERE ATM_ID=2 ORDER BY TRANSACTION_DATE desc) WHERE ROWNUM<2