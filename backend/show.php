<style>
.myclass {
    width:40%;
    height:50%;
    padding:20px;
    
}
.show {
    border:1px solid black;
    padding:20px;
    margin:20px;
}
.heading {
    text-align:center;
}
</style>


<script>
    function back() {
        window.location.replace("../index.php");
    }     
</script>

<?php
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


    //take product Id from Get method
    $productId = $_GET['productId'];


    $sql = "select * from $product_table where id=$productId";
    $res = mysqli_query($conn , $sql); 
    if(!$res) {
        die("[-] Error while querying the product info");
    }

    $row = mysqli_fetch_assoc($res);

//	$database 		= "products";
//	$product_table  = "product";
//    $product_name   = "prod_name";
//    $product_info   = "prod_description";
//    $product_id     = "id";
//    $product_file   = "prod_file"; 

    $nameOfproduct = $row[$product_name];
    $infoOfproduct = $row[$product_info];
    $fileOfproduct = $row[$product_file];


    /* --------------- presenting the data on page ------------------------*/
    //heading
    echo '<div class="heading show"> <h2>Product Description</h2> <button onclick="back();">Back</button> </div>';

    echo '<div class="show" ><h3>Product Name : '.$nameOfproduct.'</h3></div>';
    echo '<div class="show"><h3>Description: '.$infoOfproduct.'</h3></div>';

    //take path of file
    $dirname = '../../../rn/trial/products/'.$fileOfproduct.'/photos/';
    $images = glob($dirname."*.*");


    //show all images in file
    for($image=0;$image<count($images);$image++) {
        echo '<div class="show"><img  class="myclass" src='.$images[$image].'><br/></div>';
    }

?>
