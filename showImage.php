<?php
include_once "resource/database.php";
if (isset($_GET['CompanyName'])) {
    $username = mysql_real_escape_string($_GET['CompanyName']);
    $query = mysql_query("SELECT * FROM products WHERE 'CompanyName' = '$username'");
    while ($row = mysql_fetch_assoc($query){
    $imageData = $row["image"];
}
    header("content-type: image/jpeg");
    echo $imageData;
} else {

    echo "Error!";
}


?>