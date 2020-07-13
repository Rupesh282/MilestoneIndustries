<?php
    session_start();
    /*
     *  for security reasons
     */

    if(!$_SESSION['username'] || !$_SESSION['password']) {
        die("You are not allowed here");
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
        window.location.href='modify.php';
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
.form {
    position:absolute;
    margin-left:550px;
    width:500px;
    margin-top:200px;
}
.show-image {
    position:absolute;
    top:400px;
    left:50px;
}
</style>

<?php

     $Attr = array();

    /*
    $Attr[0] = "brand";          
    $Attr[1] = "grinder type";   
    $Attr[2] = "model name";     
    $Attr[3] = "usage";          
    $Attr[4] = "wattage";        
    $Attr[5] = "color";           
    $Attr[6] = "place of origin"; 
    $Attr[7] = "no of jars";      
    $Attr[8] = "voltage";         
    $Attr[9] = "warrenty";        
    $Attr[10] = "nspeed";          
    $Attr[11] = "motorhp";         
    $Attr[12] = "housing";         
    $Attr[13] = "certification";   
    $Attr[14] = "dimensions";      
    $Attr[15] = "box-content";     
    $Attr[16] = "nblades";         
    $Attr[17] = "bodyshape";       
    $Attr[18] = "additionalinfo";  
    */

    //total attributes of a product
    // $total_attr = 18;

    
     //create connection and fetch data of product from sql
     require_once "loginfo.php";

     //Connection
     $conn = new mysqli($servername , $username , $password);
     if(!$conn) {
         die("[-] Connection error with MySql");
     }
 
     //first use database
     $sql = "USE $product_database";
     if(!mysqli_query($conn , $sql)){
         die("[-] Error while using database !!");
     }
 
     $sql = "select * from $category_table";
     $getcat = mysqli_query($conn , $sql); 
     if(!$getcat) {
         die("[-] Error while querying the category info");
     }
 
     //take product Id from Get method
     $productId = $_GET['productId'];


 
     //first get the folder name of the product
     $sql = "select * from $product_table where id=$productId";
     $res = mysqli_query($conn , $sql);
     $row = mysqli_fetch_array($res);
     $productFile   = $row[$product_file];
     $productName = $row[$product_name];
     $sideinfo = $row[$product_sideinfo];

     //also get the name of mainFrame image from database
     $mainimage = $row[$mainFrame];

     $jsonfile = $rPATH.'/'.$productFile.'/info.json';
     $jsondata = file_get_contents($jsonfile);
     $array = json_decode($jsondata , true);

    $Attr[0]  = $array['data']['brand'];          
    $Attr[1]  = $array['data']['grinder-type'];   
    $Attr[2]  = $array['data']['model-name'];     
    $Attr[3]  = $array['data']['usage'];          
    $Attr[4]  = $array['data']['wattage'];        
    $Attr[5]  = $array['data']['color'];           
    $Attr[6]  = $array['data']['place-of-origin']; 
    $Attr[7]  = $array['data']['no-of-jars'];      
    $Attr[8]  = $array['data']['voltage'];         
    $Attr[9]  = $array['data']['warrenty'];        
    $Attr[10] = $array['data']['nspeed'];          
    $Attr[11] = $array['data']['motorhp'];         
    $Attr[12] = $array['data']['housing'];         
    $Attr[13] = $array['data']['certification'];   
    $Attr[14] = $array['data']['dimensions'];      
    $Attr[15] = $array['data']['box-content'];     
    $Attr[16] = $array['data']['nblades'];         
    $Attr[17] = $array['data']['bodyshape'];       
    $Attr[18] = $array['data']['additionalinfo'];  
    $Attr[19] = $array['data']['category'];  
    $Attr[20] = $array['data']['link'];  

     //add here and in input box if there are any new attributes
     


?>


<html>
<body>

    <form action="modify.php" method="POST">
        <input type="submit" name="submit" value="back">
    </form>

<div>
     <h2> You are currently modifying the product : <?php echo $productName;?> </h2>
    <form action="make_changes.php" enctype="multipart/form-data" method="post" class="form">

        <div>
           <label for="usr">Product Name :</label> 
            <input type="text" class="form-control" name="product_name" value="<?php echo $productName;?>" placeholder="Enter name">
            <input type="hidden" name="productId" value="<?php echo $productId; ?>" >
        </div>
        <br>
          Category type : 
          <select data-trigger=""  name="category">
              <option placeholder=""><?php echo $Attr[19]; ?></option>
                <?php
                    while($row = mysqli_fetch_assoc($getcat)) {
                        if($row['category']!=$Attr[19])
                            echo '<option>'.$row['category'].'</option>';
                    }
                ?>
          </select>
          <br><br>
        <div>
           <center><label for="usr">Product Description</label></center> <br>
            <label for="usr">brand : </label>
            <input type="text" class="form-control" name="brand"          value="<?php echo $Attr[0]; ?>"autocomplete="off" placeholder="Brand"><br>
            <label for="usr">grinder type : </label>
            <input type="text" class="form-control" name="grinder-type"   value="<?php echo $Attr[1]; ?>"   autocomplete="off" placeholder="GrinderType"><br>
            <label for="usr">model name : </label>
            <input type="text" class="form-control" name="model-name"     value="<?php echo $Attr[2]; ?>"   autocomplete="off" placeholder="Model Name/Number"><br>
            <label for="usr">usage : </label>
            <input type="text" class="form-control" name="usage"          value="<?php echo $Attr[3]; ?>"   autocomplete="off" placeholder="Usage/Application"><br>
            <label for="usr">wattage : </label>
            <input type="text" class="form-control" name="wattage"        value="<?php echo $Attr[4]; ?>"   autocomplete="off" placeholder="Wattage"><br>
            <label for="usr">color : </label>
            <input type="text" class="form-control" name="color"           value="<?php echo $Attr[5]; ?>"   autocomplete="off" placeholder="Color"><br>
            <label for="usr">place of origin : </label>
            <input type="text" class="form-control" name="place-of-origin" value="<?php echo $Attr[6]; ?>" autocomplete="off" placeholder="Place Of Origin"><br>
            <label for="usr">no of jars : </label>
            <input type="text" class="form-control" name="no-of-jars"      value="<?php echo $Attr[7]; ?>"    autocomplete="off" placeholder="No Of jars"><br>
            <label for="usr">voltage : </label>
            <input type="text" class="form-control" name="voltage"         value="<?php echo $Attr[8]; ?>"   autocomplete="off" placeholder="voltage"><br>
            <label for="usr">warrenty : </label>
            <input type="text" class="form-control" name="warrenty"         value="<?php echo $Attr[9]; ?>"   autocomplete="off" placeholder="warrenty"><br>
            <label for="usr">nspeed : </label>
            <input type="text" class="form-control" name="nspeed"            value="<?php echo $Attr[10]; ?>"    autocomplete="off" placeholder="Number Of Speed Settings"><br>
            <label for="usr">motorhp : </label>
            <input type="text" class="form-control" name="motorhp"           value="<?php echo $Attr[11]; ?>"    autocomplete="off" placeholder="Motor HP"><br>
            <label for="usr">housing : </label>
            <input type="text" class="form-control" name="housing"          value="<?php echo $Attr[12]; ?>"    autocomplete="off" placeholder="Housing"><br>
            <label for="usr">certification : </label>
            <input type="text" class="form-control" name="certification"    value="<?php echo $Attr[13]; ?>"    autocomplete="off" placeholder="Certification"><br>
            <label for="usr">dimensions : </label>
            <input type="text" class="form-control" name="dimensions"       value="<?php echo $Attr[14]; ?>"    autocomplete="off" placeholder="Dimensions"><br>
            <label for="usr">box-content : </label>
            <input type="text" class="form-control" name="box-content"      value="<?php echo $Attr[15]; ?>"    autocomplete="off" placeholder="Box Content"><br>
            <label for="usr">nblades : </label>
            <input type="text" class="form-control" name="nblades"          value="<?php echo $Attr[16]; ?>"    autocomplete="off" placeholder="Number Of blades"><br>
            <label for="usr">bodyshape : </label>
            <input type="text" class="form-control" name="bodyshape"        value="<?php echo $Attr[17]; ?>"    autocomplete="off" placeholder="Body shape"><br>
            <label for="usr">additionalinfo : </label>
            <input type="text" class="form-control" name="additionalinfo"   value="<?php echo $Attr[18]; ?>"   autocomplete="off" placeholder="Additional Info"><br>
            <label for="usr">sidepanel info: </label>
            <textarea class="form-control rounded-0" placeholder="This will be shown on side panel" autocomplete="off" name="sideinfo" rows="3"><?php echo $sideinfo; ?></textarea>
            <br>
            <label for="usr">link : </label>
            <input type="text" class="form-control" name="vproduct_link"   value="<?php echo $Attr[20]; ?>"   autocomplete="off" placeholder="product link"><br>
            <label for="usr">newmainframe : </label>
            <input type="text" class="form-control" name="newmainframe"   value="<?php echo $mainimage; ?>"   autocomplete="off" placeholder="Name of mainFrame Image"><br>
        </div>
        <br>

         <div class="input-group">
              <div class="custom-file">
                <input type="file" name="upload[]" multiple class="custom-file-input" id="inputGroupFile04">
                <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
          </div>
          <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" name="submit">MODIFY</button>  
          </div>
        </div>   

    </form>

<?php

        //This section shows the admin the images currently available for display
        $imagespath =$rPATH.'/'.$productFile."/photos/";

        $files = glob($imagespath."*.*");

        echo '<div class="show-image">';
        echo "Images you have currently for display : <br><br>";
        foreach($files as $image) {
            echo basename($image);
            echo '<br>';
            echo '<img width="200px" src='.$image.'>';
            echo '<br>';
        }

        echo '<br>
        <form action="delete_image.php" method="POST">
            <input type="text" class="form-control" name="image"  autocomplete="off" placeholder="Enter the name of image to delete"><br>
            <input type="hidden" name="path" value="'.$imagespath.'">
            <input type="submit" class="btn btn-primary" name="submit" value="Delete">
        </form>';



        echo '</div>';

?>

     

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
