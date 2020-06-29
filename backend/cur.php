<style>
.service-list {
list-style-type: none;
margin-left:0px;
padding-left:0px;
display: inline-block;
}
.service-list img
{
margin:2px;
float:left;
}
.service-list a{
    margin:0px;
    text-align: center; 
    width:300px;
    display:inline-block;
    padding: 0px;
}
</style>
<?php


    //rename this file as load_products.php
    //this file basically laods the products from database

    //this is path to stored data of products (it json , images)
    $path = "../../../rn/trial/products/";

    require_once "loginfo.php";

    //Connection
    $conn = new mysqli($servername , $username , $password);
    if(!$conn) {
        die("[-] Connection error with MySql");
    }

    //first use database
    $sql = "USE $product_database";
    if(!mysqli_query($conn , $sql)){
        die("Error while using database !!");
    }



    //replace white spaces in string with '+' sign (for using in url)
    //TODO:  use json here (bug : '+' sign comes when there is space in name of product)
    function repSpace($string) {
        $string = preg_replace('/\s+/', '+', $string);
        return $string;
    }

    if(isset($_POST['searchVal'])) {
        $sch = $_POST['searchVal'];
        $sql = "select * from $product_table where $product_name like '%$sch%'";
        if($res = mysqli_query($conn , $sql)) {
            $count = mysqli_num_rows($res);
            if($count==0) {
                $output = "<li class='service-list'><a href='#'>There are no search results !!</a></li>";
            }
            else {
                while($row = mysqli_fetch_array($res)) {
                    $nameOfproduct = $row[$product_name];
                    $productId     = $row[$product_id];
                    $productFile   = $row[$product_file];

                    //get the  extension of mainFrame files
                    $mainFramephoto = $row[$mainFrame];

                    $urlOfproduct = "show.php?productId=$productId";

                    $imagepath = "";
                    //this path is relative to index.php
                    $relpath = "../../rn/trial/products/";
                    if(file_exists($path.$productFile.'/photos/'.$mainFramephoto)) {
                        $imagepath = $relpath.$productFile.'/photos/'.$mainFramephoto;
                    } else $imagepath= $relpath.'dummy/default.png';

                    $output .= '<li class="service-list">
                        <img width=80px src='.$imagepath.' class="alignnone size-full wp-image-156">
                        <a href='.$urlOfproduct.'>'.$nameOfproduct.'</a>
                    </li><br>';
                }
            }
        }
    } 
    echo $output;
?>
