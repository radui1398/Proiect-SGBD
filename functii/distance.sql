CREATE OR REPLACE FUNCTION compute_distance (lat1 IN NUMBER,long1 IN NUMBER, lat2 IN NUMBER, long2 IN NUMBER,radius IN NUMBER DEFAULT 3963) 
RETURN NUMBER IS
degreesToRadius NUMBER := 57.29577951;
BEGIN

RETURN(NVL(radius,0) * ACOS((sin(NVL(lat1,0) / degreesToRadius) * SIN(NVL(lat2,0) / degreesToRadius)) +
        (COS(NVL(lat1,0) / degreesToRadius) * COS(NVL(lat2,0) / degreesToRadius) *
         COS(NVL(long2,0) / degreesToRadius - NVL(long1,0)/ degreesToRadius))));
END;
/

BEGIN
    DBMS_OUTPUT.PUT_LINE(COMPUTE_DISTANCE(38.898556,-77.037852,38.897147,-77.043934));
END;

