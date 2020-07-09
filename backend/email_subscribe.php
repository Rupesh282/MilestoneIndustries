<?php

    //for mySql
    require_once "../loginfo.php";
    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Load Composer's autoloader
    require 'vendor/autoload.php';


    function send_email($sender_mail , $sender_password , $reciever_mail) {
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
            $mail->setFrom($sender_mail , 'Milstone Industries');

            $mail->addAddress($reciever_mail);               // Name is optional

            //for attachmenst
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Hi';

            //TODO : add link for unsubscribe here
            $mail->Body    = '
                <h2>Greetings From Milstone , <br>
                You have subscriberd to our channel successfully !!!
                </h2>
                <h3><a href="www.amazon.in">Click here to unsubscribe</a></h3>
            ';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
    }



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
                //now send email
                $reciever_email = $email;
                send_email($sender_email , $sender_password , $reciever_email);
                //show alert message to users and quite opened tab
                $output = "You are subscribed successfully !";
            }
        }
    }
    echo json_encode($output);
?>
