<?php
// There are few ways we can use database in our php application(Ex. native php functions for MYSQLi driver, PDO )
// MySQLi has both procedural and oop way, but pdo is only OOP way
// PDO (PHP Data Objects) is a database access layer in PHP that provides a consistent interface for interacting with databases, regardless of which database you're using (e.g., MySQL, PostgreSQL, SQLite, etc.).
// phpinfo(); - after running it if we search for pdo, we can see which drivers it supports like mysql, sqlsrv
// in xamppp, we can add any driver using php.ini if not present (like uncomment the ;mysql driver part)
// for docker, we can add this on dockerFile: RUN docker-php-ext-install pdo pdo_mysql (then command- docker-compose -d --build)

declare(strict_types=1);

namespace PDO;
use PDO;

class HomeController{
    public function basic(){
        // Database Connection
        try {
            $db = new PDO('mysql:host=127.0.0.1;dbname=my_db', 'root', '', [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                // PDO::ATTR_EMULATE_PREPARES => false, If we use this we cant use same parameter name in prepared statement like variable date cant be used for created_at and updated_at both
            ]);
            // Fetch Mode: fetchAll(PDO::FETCH_BOTH) = (index and column name as key), FETCH_OBJ, FETCH_ASSOC, FETCH_CLASS

            $email = $_GET['email'];
            $query = 'SELECT * FROM users WHERE email = "' . $email . '"';
            $stmnt = $db->query($query); // It will return a object of PDO Statement Class
            var_dump($stmnt->fetchAll());

            foreach($stmnt as $user){
                echo '<pre>';
                var_dump($user);
                echo '</pre>';
            }

            // Prepare Statement is a database management system which is more efficient, better protection from sql injection
            // SQL injection, also known as SQLI, is a common attack vector that uses malicious SQL code for backend database manipulation to access information that was not intended to be displayed. Like in query string, if attacker can write sql somehow.
            // Attacker can update data, delete data using ssql injection.
            // Using Prepared Staement:
            $stmnt2 = $db->prepare($query);
            $stmnt2->execute();
            foreach($stmnt2->fetchAll() as $user){
                echo '<pre>';
                var_dump($user);
                echo '</pre>';
            }

            // Using Placeholder to Prevent SQL Injection
            $query = 'SELECT * FROM users WHERE email = ?';
            $stmnt2->execute($email);
            $query2 = 'INSERT INTO users (email, full_name) VALUES (?, ?)';
            $id = (int) $db->lastInsertId();

            // But so much parameter will confuse you, We can use named parameters 
            // Using Named Parameter
            $query3 = 'INSERT INTO users (email, full_name, status) VALUES (:email, :name, :status)';
            $stmnt3 = $db->prepare($query3);
            $stmnt3->execute([
                'email'  => 'alim15@cse.pstu.ac.bd',
                'name'   => 'Abdul Alim',
                'status' => 1
            ]);

            // Or, before executing, we can bind the value with parameter
            $stmnt3->bindParam(':email', $email);
            $stmnt3->bindValue('name', 'Abdul Alim'); // Colon : is optional, It will work without colon
            $stmnt3->bindValue(':status', 0, PDO::PARAM_BOOL); // 3rd argument is the Data Type, Default is string. Can be PARAM_INT and so on.

            $email = 'another@gmail.com'; // It will be changed because we used bind param, Bind param is passed by reference, so we must use variable for this, cant use directly any value
            $status = 1; // It will not be changed, 0 will be executed because we used bindValue
            $stmnt3->execute();
            // If we use placeholder ? rather than named parameter, then bindValue will take index number- bindValue(2)
        }
        catch(\PDOException $e){
            throw new \PDoException($e->getMessage(), (int) $e->getCode());
            // If we dont throw Custom Exception, Out Database Credentials will be shown in PHP Default error, its not secured to do.
        }
    }

    public function intermediate(){
        // A database transaction is a sequence of database operations treated as a single, indivisible unit of work. It ensures data consistency and reliability by guaranteeing that all operations within the transaction either fully complete and are committed, or none of them are applied.
        // Like Transfaring Data from One Account to Another- One Account Decrease, One Account Increase. If one of query failed, whole process will be failed.
        // If All Query success, commit the transaction . If not then rollback the transaction

        $db = new PDO('mysql:host=127.0.0.1;dbname=my_db', 'root', '');
        
        try{
            $db->beginTransaction();
            $stmnt1 = $db->prepare('INSERT INTO users (email, name) VALUES (?, ?)');
            $stmnt2 = $db->prepare('INSERT INTO invoices (user_id, amount) VALUES (?, ?)');
            $stmnt1->execute('a@gmail.com', 'Lim');
            $stmnt2->execute(1, 200);
            $db->commit();
        }   
        
        catch(\Throwable $e){
            if($db->inTransaction()){
                $db->rollback();
            }
        }

        // In $db variable, we hard coded everything. Rather than We can use Environment Variables in Environment Files
        // An environment variable is a dynamic, named value that provides information to a computer's operating system and running processes. They act as a way to configure how programs and systems behave without modifying the source code of the applications. 
        // We wont commit it in Our Github Repository (doesnt matter private or public), because they are confidential, so we will use .env.example file for a template and we will commit it into repository.
        // Make two Files .env and .env.example. In .env assign value in variable, in .env.example, dont assign value. Put .env in .gitigore list
        // To Load Environment variables, we can use a package named vlucas/ppdotenv. After installing, follow the instruction of the package
        // Accessing: $_ENV['DB_PASS']
    }

    public function advanced(){
        // Refactor Codes: Database Connection, index.php, Route, Controller
        // Making Model
    }
}