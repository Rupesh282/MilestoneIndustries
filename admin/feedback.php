    <form action="manage.php" method="POST">
        <input type="submit" name="submit" class="btn btn-danger" value="back">
    </form>
<?php

    session_start();
    /*
     *  for security reasons
     */

    if(!$_SESSION['username'] || !$_SESSION['password']) {
        die("You are not allowed here");
    }

    //take contents here from data to show products
    //create connection and fetch data of product from sql
    require_once "loginfo.php";

    //Connection
    $conn = new mysqli($servername , $username , $password);
    if(!$conn) {
        die("[-] Connection error with MySql");
    }

    //first use database
    $sql = "USE $product_database";
    if(!mysqli_query($conn , $sql)){ die("[-] Error while using product database !!");
    }


    if(isset($_POST['delete'])) {
        $msg = $_POST['message'];
        $email = $_POST['email'];
        $sql = "delete from $feedback_table where message='".$msg."' and email='".$email."'";
        $res = mysqli_query($conn , $sql);
        if(!$res) {
            echo "[-]Error while deleting the record";
        } 
    }


    $sql = "select * from $feedback_table";
    $res = mysqli_query($conn , $sql);
    if(!$res) {
        echo "[-] Error while querying feedback";
        die("");
    }


    if(mysqli_num_rows($res)==0) {
        echo "No feedbacks available";
    } else {
        echo '<p>All feedbacks/queries recieved from customers : </p>';
    }

    while($row = mysqli_fetch_assoc($res)) {
        echo '<div style="border:1px solid black;width:30%">';
        echo "name : ".$row['name']."<br>";
        echo "subject : ".$row['subject'];
        echo '<p style="white-space: pre-line">';       
        echo "Message : <br>".$row['message'];
        echo '</p>';
        echo "cellno : ".$row['cellno']."<br><br>";
        echo "email : ".$row['email']."<br><br>";
        echo '<form action="feedback.php" method="post">';
        echo '<input type="submit" value="delete" name="delete">';
        echo '<input type="hidden" value="'.$row['message'].'" name="message">';
        echo '<input type="hidden" value="'.$row['email'].'" name="email">';
        echo '</form>';
        echo '</div><br>';
    }


?>
