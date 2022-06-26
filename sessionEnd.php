<?php
    require "session.php";

    session_destroy();
    header("location: http://localhost/login.php");
?>