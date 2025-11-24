<?php
// Doctrine is a collection of PHP's library that mainly focus around Database Layer and Object Mapping.
// DBAL: Database Abstraction Layer. I am coding but I dont know its using mysql, sqlite etc by seeing query- Its an abstraction, right?
// DBAL is like an interface which allows us to work with different kind of database implementation like MySQL, SQLITE, MSSQL etc.
// PDO was not a Database Abstraction Layer, It was just a Data Access Layer. But Doctrin DBAL library is.

// Getting a Database Connection
require_once 'vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
$connectionParams = [
    'dbname' => 'mydb',
    'user' => 'user',
    'password' => 'secret',
    'host' => 'localhost',
    'driver' => 'pdo_mysql'
];
// $conn = DriverManager::getConnection($connectionParams);

// Now, execute queries ans use doctrin's many easy functionalities.
// We can use query builder like select('id')->where('amount > ?')->fetchAllAssociative(). join(), groupBy(), having() etc.

// DBAL is A common API for multiple databases, A powerful Query Builder.
// Laravel has its own complete database stack built on top of PDO with additional components.
// Laravel’s database engine is built directly on native PHP PDO, not on Doctrine ORM.
// Laravel does not use Doctrine ORM, but Laravel does use Doctrine DBAL optionally. Everything (Eloquent, Query Builder, DB::select) ultimately uses PDO under the hood.
// Laravel requires Doctrine DBAL for: Renaming columns in migration, Changing columns, Dropping columns safely, Column introspection.
// Laravel’s schema builder alone cannot read existing column definitions. So if you run migrations like:
// Schema::table('users', function (Blueprint $table) {
//     $table->renameColumn('old', 'new');
// });
// This is why Laravel often says: To rename a column, you must require the doctrine/dbal package.

// Real uses of Doctrine DBAL in Laravel:
// When renaming a column
// When modifying a column type
// When changing a column from nullable to not-null
// When reading database metadata like column-type, default-values, length, indexes

// We can call createQueryBuilder method of entityManager class, and use query builder.

// DQL: Doctrine Query Language, Like SQL, rather thinking table and clums, think as entity and map properties. This allows to write complex query in DQL format.
// It is the custom query language used by Doctrine ORM
// DQL is not SQL. Instead, it is a high-level, object-oriented query language that queries PHP objects (Entities), not tables.
// DQL does not exist in Laravel, because Laravel does not use Doctrine ORM.
// SELECT u FROM App\Entity\User u WHERE u.active = 1

// Doctrine ORM:
// ORM standa for Object Relational Mapping that sits in between your application and database layer.
// It converts database rows into PHP objects so you can query your database without writing SQL.
// Both Doctrine and Laravel provide an ORM — but they work very differently.
// Laravel ORM: Eloquent- Eloquent is an Active Record ORM. Each Model = one table, Models provide direct CRUD methods, Model is aware of its database table
// There are many patterns like Active Record Pattern, Data Mapper Pattern
// Laravel Eloquent use active record pattern, doctrine use data mapper pattern


// Migration: Doctrine has anothe library called migration
// Migration are like versioning system of your database.