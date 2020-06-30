<?php

    //for mySql
    require_once "../loginfo.php";

    //Connection
    $conn = new mysqli($servername , $username , $password);
    if(!$conn) {
        die("[-] Connection error with MySql");
    }

    //first use database
    $sql = "USE $email_database";
    if(!mysqli_query($conn , $sql)){
        die("Error while using database !!");
    }

    //get email from ~/index.html
    $email = $_POST['email'];


    $output = '';

    //check if emails is in valid from
    if(!filter_var($email , FILTER_VALIDATE_EMAIL)) {
        $output = "Email is not valid , please enter again!";

    } else {
        //If email is valid check if it is already present in database
        $sql = "select count(1) from $email_table where $email_col='$email'"; 

        $res = mysqli_query($conn , $sql);
        if(!$res) {
            die("here");
        }
        $rows = mysqli_fetch_row($res);
        if($rows[0] >=1 ) {
            //if present show alert and close the tab
            $output = "You have already subscribed !!";
        } else {
            //insert current email into table
            $sql = "insert into $email_table values('$email')";
            if(!mysqli_query($conn , $sql)) {
                die("<h3>[-] Failed to add email to database !</h3>");
            }
            else {
                //show alert message to users and quite opened tab
                $output = "You subscribed successfully !!";
            }
        }
    }
    echo json_encode($output);
?>
