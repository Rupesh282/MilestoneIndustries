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


    //first switch to emails database to create table
    $sql = "USE $email_database";
    if(!mysqli_query($conn , $sql)) {
        die("[-] ERROR WHILE USING DATABASE -> email_database");
    }

    //create table for emails : 
    $sql = "CREATE table $email_table($email_col VARCHAR(50) , $isSubed bool default 1);";
    if(!mysqli_query($conn , $sql)) {
        die("[-] TABLE CREATION ERROR -> email table");
    }

    //first switch to products table 
    $sql = "USE $product_database";
    if(!mysqli_query($conn , $sql)) {
        die("[-] ERROR WHILE USING DATABASE -> product_database");
    }


    //create table for products in product_database : 
    $sql = "CREATE TABLE $product_table($product_file VARCHAR(50) , $product_name VARCHAR(50) , $mainFrame VARCHAR(30) , $category VARCHAR(50), $product_sideinfo VARCHAR(120), $product_id INT NOT NULL AUTO_INCREMENT , PRIMARY KEY ($product_id));";
    if(!mysqli_query($conn , $sql)) {
        die("[-] TABLE CREATION ERROR -> product table");
    }

    //create table for categories
    $sql = "CREATE TABLE $category_table($category_name VARCHAR(100));";
    if(!mysqli_query($conn , $sql)) {
        die("[-] TABLE CREATION ERROR -> category table");
    }

    //create table for otp
    $sql = "create table $otp_table(email VARCHAR(30) , code VARCHAR(20) , time TIMESTAMP);";
    if(!mysqli_query($conn , $sql)) {
        die("[-] TABLE CREATION ERROR -> otp table");
    }
    
    //create table for feedback
    $sql = "create table $feedback_table(message VARCHAR(240), name VARCHAR(50) , email VARCHAR(50) , subject VARCHAR(100) , cellno VARCHAR(20));";
    if(!mysqli_query($conn , $sql)) {
        die("[-] TABLE CREATION ERROR -> feedback table");
    }
        
    die("DATABASE INSTALLATION SUCCESSFUL !!");

?>
