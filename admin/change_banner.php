<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php
    
    session_start();
    /*
     *  for security reasons
     */

    if(!$_SESSION['username'] || !$_SESSION['password']) {
        die("You are not allowed here");
    }

    echo '<form action="manage.php" method="POST">
        <input type="submit" name="submit" class="btn btn-danger" value="back">
    </form>

    <center> <h2> banner settings </h2> </center>';

    //This section shows the admin the images currently available for display
    $imagespath = '../assets/img/hero/';

    $files = glob($imagespath."*.*");

    echo '<div class="show-image">';
    echo "Images you have currently for display as banner: <br><br>";
    foreach($files as $image) {
        echo basename($image);
        echo '<br>';
        echo '<img width="200px" src='.$image.'>';
        echo '<br>';
    }

    echo '<br>
    <form action="change_banner.php" method="POST">
    Enter name of image to delete it : 
        <input style="width:20%" type="text" class="form-control" name="image"  autocomplete="off" placeholder="Enter the name of image to delete"><br>
        <input type="hidden" name="path" value="'.$imagespath.'">
        <input type="submit" class="btn btn-primary" name="delete" value="Delete">
    </form>
    <br>';

        if(isset($_POST['delete'])) {
            $imagename = $_POST['image'];
            $imagepath = $_POST['path'];
            if(file_exists($imagepath.$imagename)) {
                unlink($imagepath.$imagename);
            }
            header("Refresh:0");
        } 

    echo '<form action="change_banner.php" method="POST">
        Enter name of image to rename : 
        <input style="width:20%"type="text" class="form-control" name="old_name"  autocomplete="off" placeholder="old name"><br>
        Enter name of new image : 
        <input style="width:20%"type="text" class="form-control" name="new_name"  autocomplete="off" placeholder="new name"><br>
        <input type="hidden" name="path" value="'.$imagespath.'">
        <input type="submit" class="btn btn-primary" name="rename" value="Rename">
    </form>
    <br>';

        if(isset($_POST['rename'])) {
            $oldname = $_POST['old_name'];
            $newname = $_POST['new_name'];
            $imagepath = $_POST['path'];
            rename($imagespath.$oldname , $imagespath.$newname);
            header("Refresh:0");
        } 

     echo '<form action="change_banner.php" enctype="multipart/form-data" method="post">
    
        <div>
            <label for="upload">Add Attachments:</label>
            <input id="upload" name="upload[]" type="file" multiple="multiple" />
        </div>

        <p><input type="submit" name="add" value="Submit"></p>

    </form>
    ';

        if(isset($_POST['add'])) {
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
                        $filePath = "../assets/img/hero/".$_FILES['upload']['name'][$i];

                        //Upload the file into the temp dir
                        if(move_uploaded_file($tmpFilePath, $filePath)) {

                            $files[] = $shortname;
                            //insert into db 
                            //use $shortname for the filename
                            //use $filePath for the relative url to the file

                        } else {
                            echo "permission deneied !! (give chown permission to folder)";
                        }
                      }
                }
            }

            //show success message
            //echo "<h1>Uploaded:</h1>";    
            //if(is_array($files)){
                //echo "<ul>";
                //foreach($files as $file){
                    //echo "<li>$file</li>";
                //}
                //echo "</ul>";
            //}
            header("Refresh:0");
        } 

        $jsonfile = '../assets/js/timeout.json';
        $jsondata = file_get_contents($jsonfile);
        $array = json_decode($jsondata,true);
        $time = $array["timeout"]["time"];
        echo '<br>
        <form action="change_banner.php" method="POST">
        current banner time :'.$time.'          <br>
        set banner time : 
            <input style="width:20%" type="text" class="form-control" name="time"  autocomplete="off" placeholder="Time in ms"><br>
            <input type="submit" class="btn btn-primary" name="banner_time" value="change time">
        </form>
        <br>';

        if(isset($_POST["banner_time"])) {
            $new_time = $_POST['time'];
            $ar['time'] = $new_time; 
            $json = json_encode(array('timeout' => $ar),JSON_PRETTY_PRINT);
            file_put_contents($jsonfile , $json);
            header("Refresh:0");
        }

    echo '</div>';
?>
