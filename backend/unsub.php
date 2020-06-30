<?php
        

    //login info for mysql
    require_once "../loginfo.php";

    //get email by GET method
    $emaild = $_GET['email'];

    //sql connection
    $conn = new mysqli($servername , $username , $password);
    if(!$conn) {
        die("[-] Connection error with MySql");
    }

    //first use database
    $sql = "USE $email_database";
    if(!mysqli_query($conn , $sql)){
        die("[-] Error while using database !!");
    }

    $sql = "delete from $email_table where $email_col='$emaild'";
    if(!mysqli_query($conn , $sql)) {
        die("[-] Cant delete email from database");
    } else {
        echo '<h2>[+] You have unsubbed successfully</h2>';
    }
?>
