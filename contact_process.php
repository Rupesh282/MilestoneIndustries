<?php


    //for checking phone number formate
    function validate_phone_number($phone)
    {
         // Allow +, - and . in phone number
         $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
         // Remove "-" from number
         $phone_to_check = str_replace("-", "", $filtered_phone_number);
         // Check the lenght of number
         // This can be customized if you want phone number from a specific country
         if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
            return false;
         } else {
           return true;
         }
    }

    if(isset($_POST['submitForm'])) {
        $name = $_POST['name'];
        $message = $_POST['message'];
        $cellno = $_POST['cellno'];
        $subject = $_POST['subject'];
        $email = $_POST['email'];
        if(empty($name) || empty($message) || empty($email) || empty($subject) || empty($cellno) || !validate_phone_number($cellno)
        || !filter_var($email,FILTER_VALIDATE_EMAIL)) {
            echo json_encode("0");
            die("");
        } else {
               $output =  '<h6> A OTP is sent to your email address :  '.$_POST['email'].' 
                  <br>Please submit it here , to verify your account. (OTP is valid for 3 minutes)
                 </h6>
                <form action="contact_process.php" method="POST" id="otp-submit">
                    <input id="otpValue" type="text" name="otpValue" autocomplete="off" required>
                    <input id="ValidateOtp" type="submit" value="submit OTP" name="ValidateOtp" >
                    <input id="message" type="hidden" name="message" value="'.$_POST['message'].'" >
                    <input id="name" type="hidden" name="name" value="'.$_POST['name'].'">
                    <input id="email" type="hidden" name="email" value="'.$_POST['email'].'">
                    <input id="subject" type="hidden" name="subject" value="'.$_POST['subject'].'">
                    <input id="cellno" type="hidden" name="cellno" value="'.$_POST['cellno'].'">
                </form>';

                echo json_encode($output);
        }
    }
    
            //this is resend from (add if asked)
                //<form action="contact_process.php" method="POST" id="otp-resend">
                    //<input id="ResendOtp" type="submit" value="Resend OTP" name="ResendOtp" >
                    //<input id="message" type="hidden" name="message" value="'.$_POST['message'].'" >
                    //<input id="name" type="hidden" name="name" value="'.$_POST['name'].'">
                    //<input id="email" type="hidden" name="email" value="'.$_POST['email'].'">
                    //<input id="subject" type="hidden" name="subject" value="'.$_POST['subject'].'">
                    //<input id="cellno" type="hidden" name="cellno" value="'.$_POST['cellno'].'">
                //</form>
?>

<?php



    require_once 'loginfo.php';


    //echo $otpTime.'<br>';
    //Connection
    $conn = new mysqli($servername , $username , $password);
    if(!$conn) {
        echo json_encode("[-] Connection error with MySql");
        die("");
    }

    //first use database
    $sql = "USE $product_database";
    if(!mysqli_query($conn , $sql)){
        echo json_encode("[-] Error while using database !!");
        die("");
    }

    function otpCleaner($conn , $otpTime , $otp_table) {
        $datetime = date('Y-m-d H:i:s');
        $sql = "select * from $otp_table";
        $res = mysqli_query($conn , $sql);

        $todelete = array();
        $i=0;
        while($row = mysqli_fetch_assoc($res)) {
            $cdatetime = date('Y-m-d H:i:s');
            $tdatetime = $row['time'];


            $cdatetime=explode(" " , $cdatetime); 
            $tdatetime=explode(" " , $tdatetime);

            $time1 = strtotime($cdatetime[1]);
            $time2 = strtotime($tdatetime[1]);
            $date1 = $cdatetime[0];
            $date2 = $tdatetime[0];

            $difTime = round(($time1 - $time2)/60 , 3);


            if(($difTime > $otpTime) || ($date1 != $date2)) {
                $todelete[$i]=$row['email'];
                $i++;
            }
        }
        for($i=0;$i<count($todelete);$i++) {
            $sql = "delete from $otp_table where email='".$todelete[$i]."'";
            if(!mysqli_query($conn ,$sql)) 
                echo json_encode("[-]Error while cleaning otps");
        }
    }

    //clean the otps which have expired (and not used by users)
    otpCleaner($conn , $otpTime , $otp_table);


    //get variable from user 
    $message = $_POST['message'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $cellno = $_POST['cellno'];

    $message = trim($message);


    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Load Composer's autoloader
    require 'backend/vendor/autoload.php';

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
            $mail->Subject = 'Hi';

            //TODO : add link for unsubscribe here
            $mail->Body    = '
                <h2>Greetings From Milestone , <br>
                </h2> <br>
                <h3>Your OTP is : '.$body.'</h3>
                <h4>PS : dont share it with anyone !!</h4>
            ';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
    }
    


    if(isset($_POST['ValidateOtp'])) {
        $sql = "select * from $otp_table where email='".$email."'";
        $res = mysqli_query($conn , $sql);
        $row = mysqli_fetch_assoc($res);

        $cdatetime = date('Y-m-d H:i:s');
        $tdatetime = $row['time'];

        $cdatetime=explode(" " , $cdatetime); 
        $tdatetime=explode(" " , $tdatetime);

        //echo $cdatetime;
        //echo '<br>';
        //echo $tdatetime;
        //echo '<br>';

        $time1 = strtotime($cdatetime[1]);
        $time2 = strtotime($tdatetime[1]);
        $date1 = $cdatetime[0];
        $date2 = $tdatetime[0];

        //$difTime = round(abs($time1 - $time2) / 60,2);
        $difTime = round(($time1 - $time2)/60 , 3);

        //echo $difTime;
        //echo '<br>';
        //echo $time1;
        //echo '<br>';
        //echo $time2;
        //echo '<br>';
        //echo $date1;
        //echo '<br>';
        //echo $date2;
        //echo '<br>';

        if($row['code'] == $_POST['otpValue'] && $difTime <= $otpTime && $date1 == $date2) {
            //otp verification is successful 
            //echo "<pre> SUCESSS </pre>";
            $sql = "delete from $otp_table where email='".$email."'";
            $res = mysqli_query($conn , $sql);
            if($res) {
                //you should add their name , message and cellno and email to database 
                $sql = "insert into $feedback_table(message , name , email , subject , cellno) values('".$message."' ,'".$name."' ,'".$email."' ,'".$subject."' ,'".$cellno."')";
                $res = mysqli_query($conn , $sql);
                if($res) {
                    echo json_encode("We have recieved your message , Thank you!");
                }
            } 
            die("");
        } else {
            $output = "Try again,OTP is wrong!!<br>";
            if($difTime > $otpTime || $date1!=$date2) {
                //delete otp (timed out)
                $sql = "delete from $otp_table where email='".$email."'";
                $res = mysqli_query($conn , $sql);
                $output.="generate new OTP by sending the message again !";
            }
            echo json_encode($output);
            die(""); }
        //if otp is correct , redirect to previous page
    } else if(isset($_POST['ResendOtp'])) {
        //remove the previous otp from database 
        $sql = "delete from $otp_table where email='".$email."'";
        $res = mysqli_query($conn , $sql);
        if($res)
            echo json_encode("new OTP sent to your email");
        else 
            echo json_encode("[+] Error while sending new OTP");
    }

    $otp = rand(100000, 999999);
    send_email($sender_email, $sender_password , $email , $otp);

    //now store otp in database with date and time and corresponding email
    $datetime = date('Y-m-d H:i:s');
    $sql = "insert into $otp_table(email,code,time) values('".$email."' , '".$otp."' , '".$datetime."')"; 
    $res = mysqli_query($conn , $sql);









    //$sql = "insert into test(content) values('".$message."')";
    //if(mysqli_query($conn , $sql)) {
        //echo "success ";
    //} else {
        //echo "NOOOO";
    //}


    //very important content on how to show textarea data on browser
    //$sql = "select * from test";
    //$res = mysqli_query($conn , $sql);
    //if($res) {
        //while($row=mysqli_fetch_assoc($res)) {
            //echo '<p style="white-space: pre-line">';       
                //echo $row['content'];
            //echo '</p>';
        //}
    //}



?>
