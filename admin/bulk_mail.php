<?php
    
    session_start();
      //for security reasons

    if(!$_SESSION['username'] || !$_SESSION['password']) {
        die("You are not allowed here");
    }


    require_once "loginfo.php";
    //gather all categories present in table :
    $conn = new mysqli($servername, $username, $password);
    if (!$conn) {
        die("[-] Connection error with MySql");
    }
    

    //first use database
    $sql = "USE $email_database";
    if (!mysqli_query($conn, $sql)) {
        die("[-] Error while using database !!");
    }

    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // // Load Composer's autoloader
    require '../backend/vendor/autoload.php';

    function send_email($sender_mail , $sender_password , $reciever_mail , $body) {
            $mail = new PHPMailer(true);
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $sender_mail;                     // SMTP username
            $mail->Password   = $sender_password;                               // SMTP password
            $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = '465';                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom($sender_mail , 'Milestone Industries');

            $mail->addAddress($reciever_mail);               // Name is optional

            //for attachmenst
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Announcment !!';

            //TODO : add link for unsubscribe here
            $mail->Body    = '
                <h2>Greetings From Milestone ! <br>
                </h2>
                <p style="white-space: pre-line">
                    '.$body.'
                </p>




                <h5><a href="#">Click here to unsubscribe</a></h5>
            ';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
    }

?>


<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<form action="manage.php" method="POST">
        <input type="submit" name="submit" class="btn btn-danger" value="back">
</form>

<div style="position:absolute;top:10%;left:30%">

    <form action="bulk_mail.php" method="post">

        <textarea class="form-control rounded-0" placeholder="message" autocomplete="off" required name="message" rows="20" cols="50"></textarea>
        <input type="submit" value="send" name="submit">

    </form>

    <?php

        if(isset($_POST['submit'])) {
            $message = $_POST['message'];
            $message = trim($message);
            $sql = "select * from $email_table where $isSubed=1";
            $res = mysqli_query($conn , $sql);
            if($res) {
                while($row = mysqli_fetch_assoc($res)) {
                    //send emails here 
                    send_email($sender_email , $sender_password , $row[$email_col] , $message);
                }
            } else {
                echo "ERROR while selecting emails";
            }
        }

    ?>

</div>


<!-- This script avoids resubmission of the form on refreshing the page -->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

