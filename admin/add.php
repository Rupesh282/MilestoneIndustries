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


    $sql = "select * from $category_table";
    $getcat = mysqli_query($conn , $sql); 
    if(!$getcat) {
        die("[-] Error while querying the category info");
    }



    

?>


<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
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
.form{
    position:absolute;
    margin-left:550px;
    width:500px;
    margin-top:200px;
}
</style>


<html>
<body>

    <form action="manage.php" method="POST">
        <input type="submit" name="submit" class="btn btn-danger" value="back">
    </form>

<center> <h2> Add product </h2> </center>


<div>
    <form action="insert_product.php" enctype="multipart/form-data" method="post" class="form">

        <div>
           <label for="usr">Product Name :</label> 
            <input type="text" class="form-control" name="product_name" placeholder="Enter name">
        </div>
        <br>
        <div>
          Category type : 
          <select data-trigger=""  name="category">
                <option placeholder="">ALL Type</option>
                <?php
                    while($row = mysqli_fetch_assoc($getcat)) {
                        echo '<option>'.$row['category'].'</option>';
                    }
                ?>
          </select>
          <br><br>
           <label for="usr">Product Description :</label> 
            <input type="text" class="form-control" name="brand"            autocomplete="off" placeholder="Brand"><br>
            <input type="text" class="form-control" name="grinder-type"     autocomplete="off" placeholder="GrinderType"><br>


            <input type="text" class="form-control" name="model-name"       autocomplete="off" placeholder="Model Name/Number"><br>
            <input type="text" class="form-control" name="usage"            autocomplete="off" placeholder="Usage/Application"><br>
            <input type="text" class="form-control" name="wattage"          autocomplete="off" placeholder="Wattage"><br>
            <input type="text" class="form-control" name="color"            autocomplete="off" placeholder="Color"><br>
            <input type="text" class="form-control" name="place-of-origin"  autocomplete="off" placeholder="Place Of Origin"><br>
            <input type="text" class="form-control" name="no-of-jars"       autocomplete="off" placeholder="No Of jars"><br>
            <input type="text" class="form-control" name="voltage"          autocomplete="off" placeholder="voltage"><br>
            <input type="text" class="form-control" name="warrenty"         autocomplete="off" placeholder="warrenty"><br>
            <input type="text" class="form-control" name="nspeed"           autocomplete="off" placeholder="Number Of Speed Settings"><br>
            <input type="text" class="form-control" name="motorhp"          autocomplete="off" placeholder="Motor HP"><br>
            <input type="text" class="form-control" name="housing"          autocomplete="off" placeholder="Housing"><br>
            <input type="text" class="form-control" name="certification"    autocomplete="off" placeholder="Certification"><br>
            <input type="text" class="form-control" name="dimensions"       autocomplete="off" placeholder="Dimensions"><br>
            <input type="text" class="form-control" name="box-content"      autocomplete="off" placeholder="Box Content"><br>
            <input type="text" class="form-control" name="nblades"          autocomplete="off" placeholder="Number Of blades"><br>
            <input type="text" class="form-control" name="bodyshape"        autocomplete="off" placeholder="Body shape"><br>
            <input type="text" class="form-control" name="additionalinfo"   autocomplete="off" placeholder="Additional Info"><br>
            <textarea class="form-control rounded-0" placeholder="This will be shown on side panel" autocomplete="off" name="sideinfo" rows="3"></textarea>
            <br>
            
            <input type="text" class="form-control" name="vproduct_link"   autocomplete="off" placeholder="insert link including http">

            <br>
        </div>
        <br>

         <div class="input-group">
              <div class="custom-file">
                <input type="file" name="upload[]" multiple class="custom-file-input" id="inputGroupFile04">
                <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
          </div>
          <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" name="submit">ADD</button>  
          </div>
        </div>   

    </form>
</div>

</body>
</html>


<!--
          <textarea class="form-control rounded-0 " placeholder="Description" name="product_des" id="exampleFormControlTextarea1" rows="10"></textarea>
        <div class="input">
        <input type="text" class="form-control" placeholder="Product Name">
        </div>

        <div>
            <label for='upload'>Add Attachments:</label>
            <input id='upload' name="upload[]" type="file" multiple="multiple" />
        </div>

        <p><input type="submit" name="submit" value="Submit"></p>

            <textarea  class="form-control" name="product_dis" placeholder="Description">
        "Brand": "rupesh",
        "GrinderType": "-",
        "Model Name\/Number": "-",
        "Usage\/Application": "-",
        "Wattage": "-",
        "Color": "-",
        "Place Of Origin": "-",
        "No Of Jars": "-",
        "voltage": "-",
        "Warrenty": "-",
        "Number Of Speed Settings": "-",
        "Housing": "-",
        "Certification": "-",
        "Dimensions": "-",
        "Box Content": "-",
        "Number Of Blades": "-",
        "Motor Hp": "-",
        "Body Shape": "-",
        "Additional Info": "-",
        "Price": "1232132"

-->
