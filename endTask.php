<?php
    require "session.php";

    $database = new Database();

    $sqlUser = "SELECT id_worker FROM `tasks` WHERE `id_task` = :id";
    $paramUser = array(
      "id" => $_GET["id"]
    );
    
    $User = $database->selectFirstCell($sqlUser, $paramUser);

    $sql = "UPDATE `tasks` SET `state`=:state WHERE id_task = :id_task";
    $param = array(
      "state" => "finished",
      "id_task" => $_GET["id"]
    );
    
    $database->doRequest($sql, $param);

    addNotification($User, $_GET["id"], "Заказчик завершил задание");
    addNotification($_SESSION["id"], $_GET["id"], "Вы завершили задание");

    header("location: http://localhost/lk.php");

//   var_dump($database->selectAll($sqlTask, $paramTask));
