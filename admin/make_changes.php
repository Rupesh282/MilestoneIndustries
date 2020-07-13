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
        window.location.href="add.php";
    }
</script>
    <form action="modify.php" method="POST">
        <input type="submit" name="submit" class="btn btn-danger" value="back">
    </form>

<?php



        //Most important stufff
        /*
        // This is how you delete a file inside folder 
        if(unlink($fp)) echo "yes got delted";
        else echo "failed to delete the file in laptop";


        die("");

        // this is how you create a file inside a folder 
        $myfile = fopen($fp, "w") or die("Unable to open file!");
        $txt = "John Doe\n";
        fwrite($myfile, $txt);


        die("");


        //This is how you create a folder
        if(mkdir($fp)) {
            echo "yes folderr is created";
        } else {
            echo "FAILED";
        }
        */


    if (isset($_POST['submit']) && !empty($_POST['product_name'])) {


        //create connection and fetch data of product from sql
        require_once "loginfo.php";

        //Connection
        $conn = new mysqli($servername, $username, $password);
        if (!$conn) {
            die("[-] Connection error with MySql");
        }
        

        //first use database
        $sql = "USE $product_database";
        if (!mysqli_query($conn, $sql)) {
            die("[-] Error while using database !!");
        }


        //first create directories and in it , file
        //folder should contain a photos folder and a info.json file which will hold info about product

        /****************************** FILE CREATION ********************************/

        //temp get name by post method
        $PrName = $_POST['product_name'];

        $PrId = $_POST['productId'];

        $newmainimage = $_POST['newmainframe'];

        echo $PrName;
        echo $PrId.'<br>';

        //This is root path (all products will be inside it)
        //$path = '../../rn/trial/products/';


        //first create a folder
        //then create another folder of photos inside it
        //then create a file named info.json inside folder

        //create filename for product using product name (trip out all white space present in name)

        $PrFile = $rPATH.'/'.str_replace(' ', '', $PrName);

        echo $PrFile;
        echo '<br>';


        //rename the folder according to product name
        //first take the previous name of the folder 
        $sql = "select * from $product_table where id=$PrId";
        $res = mysqli_query($conn , $sql);
        if(!$res) {
            echo "cant find the product Id ".$productId;
        } else echo "got the product Id";
        
        $row = mysqli_fetch_array($res);

        $pastFileName = $rPATH.'/'.$row[$product_file];
        $newFileName = $PrFile;



        //now rename the file
        if(rename($pastFileName.'/' , $newFileName.'/')) {
            echo "renamed successfully !!";
        } else echo "[-] Error while renaming !!";


        // //create folder for products
        // if (mkdir($PrFile,0744)||is_dir($PrFile)) {
        //     echo "Yes , Root got created !!";
        // } else {
        //     die("[-] ERROR while creating root folder");
        // }

        $Photos_folder = $PrFile.'/photos/';

        // echo $Photos_folder;

        //create folder for photoes of products inside their folder
        // if (mkdir($Photos_folder,0744)||file_exists($Photos_folder)) {
        //     echo "Yes , photos folder got created !!";
        // } else {
        //     die("[-] ERROR while creating photoes folder");
        // }

        //create a json file inside first folder (folder of products)
        $json_file_path = $PrFile.'/info.json';
        // $json_file =  fopen($json_file_path, "w");
        // if (!$json_file) {
        //     echo "json file cant be created !!";
        // } else {
        //     echo "json fille got created ";
        //     fclose($json_file);
        // }
        



        //upto this point all files and folders should be present to work on
        /******************************************************************************/


        //after this take arguments from previous php file using POST and write all data to info.json
        //also upload photos to this folder (/photos/)

        //here we are going to write data to json file using php


        //first create empty array and then add one by one the elements which dont have value '-' ,
        //taken from add.php
        $array  = array();

        if ($_POST['brand']) {
            $array['brand'] = $_POST['brand'];
        }
        if ($_POST['grinder-type']) {
            $array['grinder-type'] = $_POST['grinder-type'];
        }
        if ($_POST['model-name']) {
            $array['model-name'] = $_POST['model-name'];
        }
        if ($_POST['usage']) {
            $array['usage'] = $_POST['usage'];
        }
        if ($_POST['wattage']) {
            $array['wattage'] = $_POST['wattage'];
        }
        if ($_POST['color']) {
            $array['color'] = $_POST['color'];
        }
        if ($_POST['place-of-origin']) {
            $array['place-of-origin'] = $_POST['place-of-origin'];
        }
        if ($_POST['no-of-jars']) {
            $array['no-of-jars'] = $_POST['no-of-jars'];
        }
        if ($_POST['voltage']) {
            $array['voltage'] = $_POST['voltage'];
        }
        if ($_POST['warrenty']) {
            $array['warrenty'] = $_POST['warrenty'];
        }
        if ($_POST['nspeed']) {
            $array['nspeed'] = $_POST['nspeed'];
        }
        if ($_POST['motorhp']) {
            $array['motorhp'] = $_POST['motorhp'];
        }
        if ($_POST['housing']) {
            $array['housing'] = $_POST['housing'];
        }
        if ($_POST['certification']) {
            $array['certification'] = $_POST['certification'];
        }
        if ($_POST['dimensions']) {
            $array['dimensions'] = $_POST['dimensions'];
        }
        if ($_POST['box-content']) {
            $array['box-content'] = $_POST['box-content'];
        }
        if ($_POST['nblades']) {
            $array['nblades'] = $_POST['nblades'];
        }
        if ($_POST['bodyshape']) {
            $array['bodyshape'] = $_POST['bodyshape'];
        }
        if ($_POST['additionalinfo']) {
            $array['additionalinfo'] = $_POST['additionalinfo'];
        }
        if ($_POST['category']) {
            $array['category'] = $_POST['category'];
        }
        if ($_POST['vproduct_link']) {
            $array['link'] = $_POST['vproduct_link'];
        }

        $json = json_encode(array('data' => $array), JSON_PRETTY_PRINT);
    
        if (file_put_contents($json_file_path, $json)) {
            echo "Written to json file ";
        } else {
            echo "failed to write to json file";
        }

        $cat = $_POST['category'];

        $sideinfo = trim($_POST['sideinfo']);

        //now add product to sql database 
        //add name of product and its foldername
        $folder_name = str_replace(' '  , '' , $PrName);
        $sql = "update $product_table set $product_file='$folder_name' , $product_name='$PrName' , $mainFrame='$newmainimage' , $category='$cat' , $product_sideinfo='$sideinfo' where $product_id=$PrId";
        if(mysqli_query($conn , $sql)) {
            echo "[+] Product changed to sql successfully !!";
        } else {
            echo "[-] Failed to change product to database !!";
        }

        
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';



        //now upload files
        if(count($_FILES['upload']['name']) > 0){
            //Loop through each file
            for($i=0; $i<count($_FILES['upload']['name']); $i++) {

              //Get the temp file path
                $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
    
                //Make sure we have a filepath
                if($tmpFilePath != ""){
                
                    //save the filename
                    $shortname = str_replace(' ' , '' ,$_FILES['upload']['name'][$i]);

                    //we set first image as our mainFrame.*(any extension)
                    // if ($i==0) {
                    //     //set the first image as mainframe for the product
                    //     $sql = "update $product_table set mainFrame='".$shortname."' where prod_file='".$folder_name."'";
                    //     $res = mysqli_query($conn , $sql);
                    //     if(!$res) echo "[-] failed to set mainFrame image";
                    //     else echo "[+] MainFrame set";
                    // }

    
                    //save the url and the file
                   // $filePath = "../../rn/trial/products/".$PrFile."/photos/".$_FILES['upload']['name'][$i];
                   $filePath = $PrFile."/photos/".$shortname;
                  

                    //Upload the file into the temp dir
                    if(move_uploaded_file($tmpFilePath, $filePath)) {
    
                        $files[] = $shortname;
                        //insert into db 
                        //use $shortname for the filename
                        //use $filePath for the relative url to the file
    
                    }
                    else {
                        echo "permission dineed !!! / Something may else have happend regarding uploading images";
                    }
                  }
            }
        }



        if(count($_FILES['upload']['name'])>0) {
            for($i=0;$i<count($_FILES['upload']['name']);$i++) {
                echo $_FILES['upload']['name'][$i]; 
                echo '<br>';
            }
        }
    }


/*
if(isset($_POST['submit'])){

    if(count($_FILES['upload']['name']) > 0){
        //Loop through each file
        for($i=0; $i<count($_FILES['upload']['name']); $i++) {
          //Get the temp file path
            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

            //Make sure we have a filepath
            if($tmpFilePath != ""){
            
                //save the filename
                $shortname = $_FILES['upload']['name'][$i];

                //save the url and the file
                $filePath = "../../rn/trial/products/cooker10/photos/".$_FILES['upload']['name'][$i];

                //Upload the file into the temp dir
                if(move_uploaded_file($tmpFilePath, $filePath)) {

                    $files[] = $shortname;
                    //insert into db 
                    //use $shortname for the filename
                    //use $filePath for the relative url to the file

                }
              }
        }
    }

    //show success message
    echo "<h1>Uploaded:</h1>";    
    if(is_array($files)){
        echo "<ul>";
        foreach($files as $file){
            echo "<li>$file</li>";
        }
        echo "</ul>";
    }
}
 */
?>

