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

<!-- All boostrap crap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
    
    function back() {
        window.location.href='manage.php';
    }
    function searchq() {
        var searchTxt = $("input[name='search']").val();
        if(searchTxt == '') {
            $("#output").html('');
        } else {
            $.post("modifycur.php", {searchVal: searchTxt}, function(output) {
                $("#output").html(output);
            });
        }
    }

</script>


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
    text-align: right; 
    width:400px;
    display:inline-block;
    padding: 0px;
}

#myInput {
  background-position: 10px 12px; /* Position the search icon */
  background-repeat: no-repeat; /* Do not repeat the icon image */
  width: 500px; /* Full-width */
  font-size: 16px; /* Increase font-size */
  padding: 12px 20px 12px 40px; /* Add some padding */
  border: 1px solid #ddd; /* Add a grey border */
  margin-bottom: 12px; /* Add some space below the input */
  margin-top: 100px;
  margin-left:600px;
}

#output {
  /* Remove default list styling */
  list-style-type: none;
  padding: 0;
  margin-left: 600px;
}

#output li a {
  border: 1px solid #ddd; /* Add a border to all links */
  margin-top: -1px; /* Prevent double borders */
  background-color: #f6f6f6; /* Grey background color */
  padding: 12px; /* Add some padding */
  text-decoration: none; /* Remove default text underline */
  font-size: 18px; /* Increase the font-size */
  color: black; /* Add a black text color */
  display: block; /* Make it into a block element to fill the whole list */
}

#output li a:hover:not(.header) {
  background-color: #eee; /* Add a hover effect to all links, except for headers */
}

</style>

    <form action="manage.php" method="POST">
        <input type="submit" name="submit" class="btn btn-danger" value="back">
    </form>


<center> <h2>Modify</h2> </center>

<?php 

    //make search box to search products
    //after choosing one , confirm for deletion of product
    //if yes then delete
    echo '<input type="text" name="search" id="myInput" onkeydown="searchq();" placeholder="Search for names.." autocomplete="off">' ;

    echo '<ul id="output" >
    </ul>';



?>

