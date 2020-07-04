<!-- This are required for ajax-jqry to work -->
<script src="jquery-3.5.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<!--This is ajax-jqry method to update page without refresh-->
<!--used for email subscription-->

<!--for search box-->
<style>
    #input {
        width:500px;
    }
    .has-search .form-control {
        padding-left: 2.375rem;
    }
    #myInput {
        background-position: 10px 12px;
        /* Position the search icon */
        background-repeat: no-repeat;
        /* Do not repeat the icon image */
        width: 100%;
        /* Full-width */
        font-size: 16px;
        /* Increase font-size */
        padding: 12px 20px 12px 40px;
        /* Add some padding */
        border: 1px solid #ddd;
        /* Add a grey border */
        margin-bottom: 12px;
        /* Add some space below the input */
    }
    
    #output {
        /* Remove default list styling */
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    
    #output li a {
        border: 1px solid #ddd;
        /* Add a border to all links */
        margin-top: -1px;
        /* Prevent double borders */
        background-color: #f6f6f6;
        /* Grey background color */
        padding: 12px;
        /* Add some padding */
        text-decoration: none;
        /* Remove default text underline */
        font-size: 18px;
        /* Increase the font-size */
        color: black;
        /* Add a black text color */
        display: block;
        /* Make it into a block element to fill the whole list */
    }
    
    #output li a:hover:not(.header) {
        background-color: #eee;
        /* Add a hover effect to all links, except for headers */
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {
        $("#submit").click(function(e) {
            e.preventDefault();
            var email = $("#email").val();
            $.ajax({
                type: "POST",
                url: "backend/email_subscribe.php",
                dataType: "json",
                data: {
                    email: email
                },
                success: function(data) {
                    $("#status").html(data);
                }
            });
        });
    });

    function searchq() {
        var searchTxt = $("input[name='search']").val();
        var ctg = $('#category').val();
        if (searchTxt == '') {
            $("#output").html('');
        } else {
            $.post("backend/cur.php", {
                searchVal: searchTxt,
                category: ctg
            }, function(output) {
                $("#output").html(output);
            });
        }
    }
</script>


<?php

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
        die("[-] Error while using product database !!");
    }


    $sql = "select * from $category_table";
    $res = mysqli_query($conn , $sql); 
    if(!$res) {
        die("[-] Error while querying the category info");
    }
?>



<header>
    <!-- Header Start -->
    <div class="header-area">
        <div class="main-header ">
            <div class="header-top d-none d-lg-block">
                <div class="container">
                    <div class="col-xl-12">
                        <div class="row d-flex justify-content-between align-items-center">
                            <!-- <div class="header-info-left">
                                <ul>
                                    <li><i class="far fa-clock"></i> Mon - SAT: 6.00 am - 10.00 pm</li>
                                    <li>Sun: Closed</li>
                                </ul>
                            </div>
                            <div class="header-info-right">
                                <ul class="header-social">
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li> <a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                </ul>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom">
                <div class="container">
                    <div class="row align-items-center" style="flex-wrap: nowrap;">
                        <!-- Logo -->
                        <div class=" col-xl-3 col-lg-3 col-6">
                            <div class=" logo ">
                                <a href="index.php"><img src="assets/img/logo/logo.png " alt=" " style="padding-top: 20px; padding-right: 0px;"></a>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <div class="menu-wrapper d-flex align-items-center justify-content-end ">
                                <!-- Main-menu -->
                                <div class="main-menu d-none d-md-block ">
                                    <nav>
                                        <ul class="tagline" style="white-space: nowrap; right: 100px;bottom: -30px;position: absolute;">
                                            <li><a style="font-size: 20px;">EXPORTS</a></li>
                                            <li>|</li>
                                            <li><a style="font-size: 20px;">DISTRIBUTION</a></li>
                                            <li>|</li>
                                            <li><a style="font-size: 20px;">ONLINE</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class=" col-xl-3 col-lg-3 col-6" style="flex-wrap: nowrap; ">
                            <div class="menu-wrapper d-flex align-items-center justify-content-end ">
                                <!-- Main-menu -->
                                 <!--<div class="main-menu d-none d-lg-block "> -->
                                <nav>
                                    <ul>
                                        <li>
                                            <div class="input-group" id="input" style="position:absolute;top:20px;left:10px;">
                                                    <input style="position:absolute;left:10px;width:290px;top:3px;" type="text" name="search" class="form-control" placeholder="Search here.." onkeydown="searchq();" autocomplete="off">
                                                <div class="input-group-append" style="position:absolute;left:300px;">
                                                          <select data-trigger="" name="choices-single-defaul" id="category">
                                                            <option placeholder="">ALL Type</option>
                                                                <?php
                                                                    while($row = mysqli_fetch_assoc($res)) {
                                                                        echo '<option>'.$row['category'].'</option>';
                                                                    }
                                                                ?>
                                                          </select>
                                                  <button class="btn btn-secondary" type="button">
                                                    <i class="fa fa-search">
                                                    </i>
                                                  </button>
                                                </div>
                                            </div>
                                            <!--
                                                        search results will be  displayed here 
                                                    -->
                                            <ul id="output" style="position:absolute;left:20px;top:65px;">
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                                 <!--</div> -->

                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <!-- <div class="col-xl-12 col-lg-12 "> -->
                        <div class="menu-wrapper d-flex align-items-center justify-content-end ">
                            <!-- Main-menu -->
                            <div class="main-menu d-none d-lg-block ">
                                <nav>
                                    <ul id="navigation" style="padding-left: 200px; padding-top: 15px;">
                                        <li><a href="#">APPLIANCES</a>
                                            <ul class="submenu" style="width: 280px;">
                                                <li><a href="# ">Mixer Grinder</a></li>
                                                <li><a href="# ">Food Processor and Grinder</a></li>
                                                <li><a href="# ">Juicer Mixer Grinder</a></li>
                                                <li><a href="# ">Food Processor and Grinder</a></li>
                                                <li><a href="# ">Wet Grinder</a></li>
                                                <li><a href="# ">Centrifugal Juicer</a></li>
                                                <li><a href="# ">Juicer Mixer Grinder</a></li>
                                                <li><a href="# ">Portable Hand Blender</a></li>
                                                <li><a href="# ">Roti Maker / Roaster</a></li>
                                                <li><a href="# ">Electric Fan</a></li>
                                                <li><a href="# ">Gas Stove</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="# ">COOKWARE</a>
                                            <ul class="submenu" style="width: 250px;">
                                                <li><a href="# ">Non-Stick Cookware</a></li>
                                                <li><a href="# ">Hard Anodized Cookware</a></li>
                                                <li><a href="# ">Stainless Steel Cookware</a></li>
                                                <li><a href="# ">Aluminium Cookware</a></li>
                                                <li><a href="# ">Cooper ware</a></li>
                                                <li><a href="# ">Brass ware</a></li>
                                                <li><a href="# ">Pressure Cooker</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="# ">BRANDS</a>
                                            <ul class="submenu">
                                                <li><a href="# ">Veronica</a></li>
                                                <li><a href="# ">Blackstone</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="contact.php">CONTACT US</a></li>
                                        <li>
                                            <a href="#social">SOCIAL</a>
                                        </li>
                                        <li><a href="about.php">ABOUT US</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <!-- <div class="col-xl-4 col-lg-4 "> -->
                            <!-- <div class="main-menu d-none d-lg-block "> -->
                            <!-- <nav> -->
                            <ul>
                                <li>

                                    <div id="google_translate_element" style="position:absolute;left:1430px;top:30px" class=""></div>

                                    <script type="text/javascript">
                                        function googleTranslateElementInit() {
                                            new google.translate.TranslateElement({
                                                pageLanguage: 'en',
                                                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                                            }, 'google_translate_element');
                                        }
                                    </script>

                                    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                                </li>
                            </ul>
                            </nav>
                            <!-- </div>                                           -->
                        </div>
                    </div>
                </div>
                <!-- Mobile Menu -->
                <div class="col-12">
                    <div class="mobile_menu d-block d-lg-none"></div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- Header End -->
</header>
