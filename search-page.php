<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Business HTML-5 Template </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<style>
/*to remove all white space at left and right sides of screen*/
html,body
{
    width: 100%;
    height: 100%;
    margin: 0px;
    padding: 0px;
    overflow-x: hidden; 
}


/*if you enable below code it will show all marking for debugging css*/
/*{
  //background: #000 !important;
  //color: #0f0 !important;
  //outline: solid #f00 1px !important;
//}
*/
</style>

<body class="body-bg">
    <!--? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="assets/img/logo/loder.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
<?php
    require_once "header.php" ; 
?>

<?php

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

    if(isset($_POST['submit'])) {
        //echo $_POST['search'].'<br>';
        //echo $_POST['category'].'<br>';

        //take posted data from header.php
        $src = $_POST['search'];
        $ctg = $_POST['category'];

        //first take all product from database and then show them (add link to their seperate page)
        if($src != "") {
            $sql = "select * from $product_table where $product_name like '%$src%'";
            $res = mysqli_query($conn , $sql);
            if(!$res) {
                echo "[-] Error while querying in product database";
            } else {
                //while($row = mysqli_fetch_assoc($res)) {
                    //echo $row[$product_name].'<br>';
                //}
            }
        }
    }


?>




<main>
    <div class="search-list">
        <div class="row">
        <ul>
            <?php

                //echo '<h5>
                    //Showing results for search word : "'.$src.'" in category : '.$ctg.'
                //</h5>';
                
                //show all products here
                if($src!="" && mysqli_num_rows($res)>0) {
                    while($row = mysqli_fetch_assoc($res)) {
                        $image_path = $PATH.'/'.$row[$product_file].'/photos/'.$row[$mainFrame];
                        $product_link = 'product/'.$row[$product_file].'/'.$row[$product_id];
                        
                        //access json file for another  info about product 
                        $jsonfile = $PATH.'/'.$row[$product_file].'/info.json';
                        $jsondata = file_get_contents($jsonfile);
                        $array = json_decode($jsondata , true);

                        echo '
                            <a href='.$product_link.' style="text-decoration:none">
                                <li>
                                        <img src='.$image_path.'>
                                        <h3>'.$row[$product_name].'</h3>
                                        <p>Brand : '.$array['data']['brand'].'</p>
                                        <span> Category : '.$row[$category].'</span>
                                    
                                </li>
                            </a>
                        ';
                    }
                } else {
                    echo "
                        <div class='alert alert-danger' role='alert'>
                            Opps ! No such product available
                        </div>
                    ";
                }

            ?>
        </ul>
    </div>
    </div>

         
</main>
<?php
include("footer.html");
?>
    <!-- Scroll Up -->
    <div id="back-top">
        <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
    </div>
    <div id="chat">
        <a title="Go to Top" href="#"> <i class="fas fa-comments"></i></a>
    </div>

    <!-- JS here -->

    <script src="./assets/js/vendor/modernizr-3.5.0.min.js "></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="./assets/js/vendor/jquery-1.12.4.min.js "></script>
    <script src="./assets/js/popper.min.js "></script>
    <script src="./assets/js/bootstrap.min.js "></script>
    <!-- Jquery Mobile Menu -->
    <script src="./assets/js/jquery.slicknav.min.js "></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="./assets/js/owl.carousel.min.js "></script>
    <script src="./assets/js/slick.min.js "></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="./assets/js/wow.min.js "></script>
    <script src="./assets/js/animated.headline.js "></script>
    <script src="./assets/js/jquery.magnific-popup.js "></script>

    <!-- Nice-select, sticky -->
    <script src="./assets/js/jquery.nice-select.min.js "></script>
    <script src="./assets/js/jquery.sticky.js "></script>

    <!-- counter , waypoint -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js "></script>
    <script src="./assets/js/jquery.counterup.min.js "></script>

    <!-- contact js -->
    <script src="./assets/js/contact.js "></script>
    <script src="./assets/js/jquery.form.js "></script>
    <script src="./assets/js/jquery.validate.min.js "></script>
    <script src="./assets/js/mail-script.js "></script>
    <script src="./assets/js/jquery.ajaxchimp.min.js "></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="./assets/js/plugins.js "></script>
    <script src="./assets/js/main.js "></script>

</body>

</html>
