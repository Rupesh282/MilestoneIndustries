<?php
    session_start();
    /*
     *  for security reasons
     */

    if(!$_SESSION['username'] || !$_SESSION['password']) {
        die("You are not allowed here");
    }
    header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
?>

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
    width:500px;
    display:inline-block;
    padding: 0px;
}
</style>
<?php


    //rename this file as load_products.php
    //this file basically laods the products from database

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
    // TODO : use json for this (some times + sign comes in search results in names of products)
    function repSpace($string) {
        $string = preg_replace('/\s+/', '+', $string);
        return $string;
    }

    if(isset($_POST['searchVal'])) {
        $sch = $_POST['searchVal'];
        $cat = $_POST['category'];
        if($cat!="ALL Type") {
            $sql = "select * from $product_table where $product_name like '%$sch%' AND $category='$cat' LIMIT 4";
        }
        else {
            $sql = "select * from $product_table where $product_name like '%$sch%' LIMIT 4";
        }
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

                    $urlOfproduct = "change_product.php?productId=$productId";
                    //get the  extension of mainFrame files
                    $mainFramephoto = $row[$mainFrame];

                    // check if file is there in the folder
                    $imagepath = "";
                    if(file_exists( $rPATH.'/'.$productFile.'/photos/'.$mainFramephoto)) {
                        $imagepath = $rPATH.'/'.$productFile.'/photos/'.$mainFramephoto;
                    } else $imagepath= $rPATH.'/dummy/default.png';

                    $output .= '<li class="service-list">
                        <img width=79px src='.$imagepath.' class="alignnone size-full wp-image-156">
                        <a href='.$urlOfproduct.'>'.$nameOfproduct.'</a>
                    </li><br>';
                }
            }
        }
    } 
    echo $output;

    /*
       ../MilestoneIndustries/backend/products/ 
     */

     //To clear the cashe from the page

    //  $this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT"); 
    // $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
    // $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); 
    // $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false); 
    // $this->output->set_header("Pragma: no-cache");
?>




