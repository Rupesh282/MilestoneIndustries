<!DOCTYPE html>
<html>
    <head>
        <title>
            ADMIN Login page
        </title>
        <!-- All boostrap crap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    </head>
    <body>
        <header>
                <center>
                    <div class="jumbotron">
                       <h1>Milestone Admin Login</h1> 
                    </div>
                </center>
        </header>
        <hr>
        <center>
        	<a href="index.php"><img src="../assets/img/logo/logo.png" alt=" " style="padding-top: 20px; padding-right: 0px;"></a>
           <div class="form1">
            <br>
               <div style="width:400px">
                   <h3></h3>
                    <form action="manage.php" method="POST" autocomplete="off">
                            <input  type="text" class="form-control" name = "username" placeholder="Username"><br><br>
                            <input  type="password" class="form-control" name="password" placeholder="Password"><br><br>
                            <input  type="submit" class="btn btn-success" name="submit" value="Log In">
                    </form>
               </div>
                <h3>
                    <?php
                        $status = $_GET['status'];
                        if($status==1)echo "Password/username is Incorrect";
                        else if($status==2) echo "Please fill both username and password";
                    ?>
                </h3>
        </center>
    </body>
</html>

