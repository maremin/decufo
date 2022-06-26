<?php
require("session.php");

$database = new Database();

if($_SESSION["theme"] == "light"){
    $_SESSION["theme"] = "dark";
}
else{
    $_SESSION["theme"] = "light";
}

header("location: lk.php")
?>