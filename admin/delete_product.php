<?php
    session_start();
    /*
     *  for security reasons
     */

    if(!$_SESSION['username'] || !$_SESSION['password']) {
        die("You are not allowed here");
    }
?>
<!-- All boostrap crap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script> 

    function back() {
        //go back to admin panel
        window.location.href="remove.php";
    }
</script>

<style>
.status {
    position:absolute;
    margin-top:100px;
    width:500px;
    margin-left:600px;
}
</style>

    <form action="remove.php" method="POST">
        <input type="submit" name="submit" class="btn btn-danger" value="back">
    </form>


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


    //first get the folder name of the product
    $sql = "select * from $product_table where id=$productId";
    $res = mysqli_query($conn , $sql);
    $row = mysqli_fetch_array($res);
    $productFile   = $row[$product_file];


    //note that files are not deleted yet
    //directly delete from database
    $sql = "delete from $product_table where id=$productId";
    $status = "";
    if(mysqli_query($conn , $sql)) {
        $status = "[+] Product is deleted successfully !!!";
    } else {
        $status = "[-] Can't delete product";
    }



    //all products files are present here
    //$Ppath = '../../rn/trial/products/';

    $filePath = $PATH.'/'.$productFile.'/';

    //now we will delete files
    //remove the photos of corresponding product , and delete its directory
    //fucntion to delete all files in a folder including folder itself
    function delete_files($target) {
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

            foreach( $files as $file ){
                delete_files( $file );      
            }

            rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );  
        }
    }
    delete_files($filePath);

    echo '<div class="panel panel-default status">
      <div class="panel-heading">Status</div>
      <div class="panel-body">'.$status.'</div>
    </div>';

?>

<!--
 require_once "../MilestoneIndustries/backend/loginfo.php";

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
    $sql = "select * from $product_table where $product_name like '%$sch%'";
    if($res = mysqli_query($conn , $sql)) {
        $count = mysqli_num_rows($res);
        if($count==0) {
            $output = "<li class='service-list'><a href='#'>There are no search results !!</a></li>";
        }
        else {
            while($row = mysqli_fetch_array($res)) {
                $nameOfproduct = repSpace($row[$product_name]);
                $productId     = $row[$product_id];
                $productFile   = $row[$product_file];

                $urlOfproduct = "delete_product.php?productId=$productId";
                //get the  extension of mainFrame files
   -->
