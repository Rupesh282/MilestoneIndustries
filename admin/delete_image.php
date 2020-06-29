<?php
    session_start();
    /*
     *  for security reasons
     */

    if(!$_SESSION['username'] || !$_SESSION['password']) {
        die("You are not allowed here");
    }
?>
<?php


    if(isset($_POST['submit'])) {
        //we will delete image here 
        $path = $_POST['path'];
        $imagename = $_POST['image'];
        if(file_exists($path.$imagename)) {
            if(unlink($path.$imagename)) {
                echo '<script> alert("[+] FILE GOT DELETED SUCCESSFULLY !!") </script> ';
                echo '<script>window.location=document.referrer;</script>';
            } else {
                echo "[-] ERROR WHITE UNLINKING THE FILE !!";
            }
        } else echo "[-] NO SUCH FILE EXISTS";
    } else {
        echo "<h2> Nothing is going to happen as submit button is not clicked yet </h2>";
    }



?>
