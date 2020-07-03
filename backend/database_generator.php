<?php

    //File is meant for generating the database required for website in sql

    //login info for mysql
    require_once "../loginfo.php";


    //sql connection
    $conn = new mysqli($servername , $username , $password);
    if(!$conn) {
        die("[-] CONNECTION ERROR -> mysql");
    }


    //this is for email database
    $sql = "CREATE DATABASE $email_database";
    if(!mysqli_query($conn , $sql)) {
        die("[-] DATABASE CREATION ERROR -> email database");
    }
    //this is for products database
    $sql = "CREATE DATABASE $product_database";
    if(!mysqli_query($conn , $sql)) {
        die("[-] DATABASE CREATION ERROR -> product database");
    }


    //first switch to emails table to create table
    $sql = "USE $email_database";
    if(!mysqli_query($conn , $sql)) {
        die("[-] ERROR WHILE USING DATABASE -> email_database");
    }

    //create table for emails : 
    $sql = "CREATE TABLE emails(email VARCHAR(50));";
    if(!mysqli_query($conn , $sql)) {
        die("[-] TABLE CREATION ERROR -> email table");
    }

    //first switch to emails table to products table 
    $sql = "USE $product_database";
    if(!mysqli_query($conn , $sql)) {
        die("[-] ERROR WHILE USING DATABASE -> product_database");
    }


    //TODO : add new column for catogeries of products 

    //create table for products in product_database : 
    $sql = "CREATE TABLE product(prod_file VARCHAR(50) , prod_name VARCHAR(50) , mainFrame VARCHAR(30) , categories VARCHAR(50) id INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (id));";
    if(!mysqli_query($conn , $sql)) {
        die("[-] TABLE CREATION ERROR -> product table");
    }
    
    die("DATABASE INSTALLATION SUCCESSFUL !!");

?>
