
<?php

    //for security...
    session_start();

    if(($_SESSION['username'] && $_SESSION['password'])) {
        //render this page
    } else if($_POST['username']=="admin" && $_POST['password']=="admin") {
        $_SESSION['username'] = "admin";
        $_SESSION['password'] = "admin";
    } else {
        session_destroy();
        header('location:index.php?status=1');
    }


?>




<!--All bootstrap and jquery and ajax crap-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
    
    function logout() {
        window.location.href='logout.php';
    }
    function add() {
        window.location.href='add.php';
    }
    function remove() {
        window.location.href='remove.php';
    }
    function modify() {
        window.location.href='modify.php';
    }

</script>


<style>
    .panel {
        position:absolute;
        left:450px;
        width:500px;
    }
    #btn {
        margin:50px;
        width:190px;
        height:60px;
    }
</style>
<center>
<img src="./../assets/img/logo/logo.png" alt=" " style="padding-top: 20px; padding-right: 0px; margin-left: 50px;">


<?php 
    
    echo '<div style="float:right;margin:10px;"><button type="button" class="btn btn-danger btn-lg" onclick="logout();">Log Out</button></div>';
    echo '<br><br><br>';
    echo '<div class="panel">
            <form action="add.php" method="POST">
                <input type="submit" value="ADD" class="btn btn-primary" id="btn" name="submit">
            </form>
            <form action="remove.php" method="POST">
                <input type="submit" value="DELETE"class="btn btn-danger" id="btn" name="submit">
            </form>
            <form action="modify.php" method="POST">
                <input type="submit" value="MODIFY" class="btn btn-success" id="btn" name="submit">
            </form>
          </div>';
?>
</center>
