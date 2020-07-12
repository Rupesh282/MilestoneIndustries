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
    $sql = "USE $product_database";
    if (!mysqli_query($conn, $sql)) {
        die("[-] Error while using database !!");
    }

    $sql = "select * from $category_table";
    $allcat = mysqli_query($conn , $sql);

    
    

?>


<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" type="text/css" href="../assets/css/admin-style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
    function back() {
        window.location.href='manage.php';
    }
    function searchq() {
        var searchTxt = $("input[name='search']").val();
        if(searchTxt == '') {
            $("#output").html('');
        } else {
            $.post("cur.php", {searchVal: searchTxt}, function(output) {
                $("#output").html(output);
            });
        }
    }
</script>

<style>
</style>


<html>
<body>
    <form action="manage.php" method="POST">
        <input type="submit" name="submit" class="btn btn-danger" value="back">
    </form>
    <center>
    <div class="add-category">
               <h2> Add category : </h2> 
            <form action="add_category.php" method="POST">
                <input type="text" name="category" placeholder="type here .." class="category-text">
                <input type="submit" value="ADD" name="add" class="category-submit">
            </form>
            <div class="list-cat">
            <?php
                echo "<h4>Currently present categories:</h4>";

                if(mysqli_num_rows($allcat)==0) {
                    echo "<p>NONE</p>";
                } else {
                    while($row = mysqli_fetch_assoc($allcat)) {
                        echo '<p>'.$row['category'].'</p>';
                    }
                }

        echo '</div> 
        <div class="display-message">';
                
        if(isset($_POST["add"])) {

        $cat_name = $_POST['category'];

        if(empty($cat_name)) {
            echo "<p>text box is empty !!</p>";
        } else {
            $sql = "select * from $category_table where $category_name='$cat_name'";
            $res = mysqli_query($conn , $sql);
            if($res) {
                $cnt = mysqli_num_rows($res);
                if($cnt>0) {
                    echo "<p>Already present !!</p>";
                } else {
                        $sql = "insert into $category_table values('$cat_name');";
                        if(!mysqli_query($conn , $sql)) {
                            echo  "[-] Error while adding category!!";
                        }
                        echo "<p>Category added successfully !!</p>";
                }
            } else {
                echo "<p>[-] Error while querying in category table</p>";
            }

        }
    }
        echo '</div>';
            ?>
        </div>
    <!-- </div> -->
    </center>
</body>
</html>

