<?php
    //MYSQL:
    //1. select * from students LIMIT 3;
    //2. ORDER BY ASC/DSC

    //Insert, Update, Delete, Truncate..All Basic.

    //select count(*) as total, city from customer group by city - We will get two rows total and city. For the count, we can use any aggregate function. We can also use group by for multiple column like 'group by city, postal_code'

    ////Filtering when group by used, Use 'Having' rather than 'where'': select sum(income) as total, city from customer group by city HAVING total > 5000
    
    //Multiple condition in where clause: and, or, grouping by parenthesis-
    //select / from CUSTOMER where (City = 'Ishurdi' AND postal = IN('1', '3')) OR (City = 'Patuakhali' and postal = '3')
    //select CUSTOMER.ID, City, Birth, Name from CUSTOMER, INDIVIDUAL where city = 'barishal' and CUSTOMER.id = INDIVIDUAL.id    (If we mentioned just id rather than customer.id, then two id column will be shown because id are present in both table)
    //Same Query As Inner Join(More Readable and recommended, Common in the tables like intersection): select CUSTOMER.ID, City, Birth, Name from CUSTOMER JOIN INDIVIDUAL ON  CUSTOMER.id = INDIVIDUAL.id where city= 'bit' - Can write 'inner join' also.

    //Sub Select(In parenthesis select, it will work as a virtual table, use alias for that table): select * from (another select query) as virtualTable where...

    //Multiple Table Joining: select account.id, sum(balance) as total, BRANCH.address from ACCOUNT JOIN INDIVIDUAL on INDIVIDUAL.id = ACCOUNT.id JOIN BRANCH on... group by...

    //Left Join or Left Outer Join(All Data from Left Table and Common data from both table, for uncommon data 'null' value): LEFT JOIN. Just uncommon data: use 'IS NULL' at last. 'IS NOT NULL'

    //Right JOIN: Inverse of LEFT JOIN

    //Import Data from Table Randomly: create table newTable select * from oldTable order by rand() limit 1500

    //If column data is boy then replace it with M rather than F in a new column- select name, IF(sex = 'boy', 'M', 'F') as gender from...

    //Fill Specif Table from another tables: insert into students (name, sex) select name,  IF(sex = 'boy', 'M', 'F') as sex from OldTable

    //Generate Random Value: select RAND(), select FLOOR(RAND()*6)- From 0 to 6, CEIL- 1 to .., Rand in 10 to 20- select 10+CEIL(RAND()*10) - use as 20-10, sum small number, multiply the difference.

    //Pick from a list: select ELT(1, 'A', 'B'), randomly- select ELT(CEIL(RAND()*2), 'A', 'B')

    //UPDATE students SET class = CEIL(RAND()*10), section = (SELECT ELT(CEIL(RAND()*4), 'A', 'B', 'C', 'D'))

    // SET @roll=0; UPDATE students SET roll = @roll: = @roll + 1 where..

    //Duplicating Table: create table NEW LIKE OLDName - no data, just structure with index, Insert into tableName select from anotherTable

    //Stored Procedure: Like a function writing and call it as necessary.
        /*- 
        DELIMITER $$
        CREATE PROCEDURE get_all_studs()
        BEGIN
            select * from students;
        END $$
        DELIMITER ;
        */
        //Run the procedure: call get_all_students

    //Parameterized Stored Procedure
        /*- 
        DELIMITER $$
        CREATE PROCEDURE get_studs_by_class(IN c INT, IN s VARCHAR(1))
        COMMENT "get_studs_by_class = Get Students"
        BEGIN
            select * from students where class = c and section = s;
        END $$
        DELIMITER ;
        call get_studs_by_class(2, 'A')
        */
    // procedure status
    //Deleting Procedure: DROP PROCEDURE get_all_studs;
    //No Direct Way to Modify It- Drop and make new

    //Prepared Statement(Antidode of SQL Injection, fast)
        
     
?>