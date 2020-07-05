<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <!-- This is for url rewrite -->
    <!-- when using in local machine , use path to the assets folder here instaed of "/" from root directoryy i.e. /www/html/-->
    <!-- ex : if your assets folder is /www/html/MilstoneIndustries/  the replace "/" by "/MilstoneIndustries/"-->
    <base href="/"/>
    <!--<base href="/Milstone/MilestoneIndustries/"/>-->

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

<body class="body-bg">
    <!--? Preloader Start--> 
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
    
    //path to product file (json , images)
    //$path = '../../rn/trial/products/';

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


    $productname = $row[$product_name];
    $productfile = $row[$product_file];
    $mainframe   = $row[$mainFrame];




    //first take mainFrame and set it on screeen
    $image = $PATH.'/'.$productfile.'/photos/'.$mainframe;

    //if main frame is not there , show a default image
    if($mainframe=="" || !file_exists($image)) {
        $image = $PATH.'/'.'dummy/default.png';
    }


    $jsonfile = $PATH.'/'.$productfile."/info.json";
    $jsondata = file_get_contents($jsonfile);
    $array = json_decode($jsondata,true);

    //debug using print_r($array);


?>

<main>
<section class="blog_area section-padding">
            <div class="container">
                <div class="row">
                        <div class="col-lg-4 mb-5 mb-lg-0">
                            <article class="blog_item">
                                <div class="blog_item_img">
                                    <img class="card-img rounded-0" src="<?php echo $image;?>" alt="" style="width: 250px;height:250px">                
                                </div>                                 
                        </div>
                        <div class="col-lg-5 mb-5 mb-lg-0">
                                <div class="blog_details">
                                    <a class="d-inline-block" href="blog_details.html">
                                        <h2> <?php echo $productname; ?></h2>
                                    </a>
                                    <p>
                                        <?php 
                                                echo '<table class="table">';
                                                foreach($array as $key=>$value) {
                                                    foreach($value as $k=>$v) {
                                                        echo '<tr class="table-success"><td>'.$k.'</td><td>'.$v.'</td></tr>';
                                                    }
                                                } 
                                                echo '</table>';
                                         ?> 
                                    </p>
                                </div>
                            </article>
                        </div>
                    <div class="col-lg-3">
                        <div class="blog_right_sidebar">
                            <aside class="single_sidebar_widget post_category_widget">
                                <h4 class="widget_title">Sample Menu</h4>
                                <ul class="unordered-list">
                                    <li>
                                        <a href="#" class="d-flex">
                                            <p>A</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="d-flex">
                                            <p>B</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="d-flex">
                                            <p>C</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="d-flex">
                                            <p>D</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="d-flex">
                                            <p>E</p>
                                        </a>
                                        <ul>
                                            <li>Sub Item</li>
                                            <li>Sub Item</li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#" class="d-flex">
                                            <p>F</p>
                                        </a>
                                    </li>
                                </ul>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
