<?php
    require "session.php";

    $database = new Database();
    
    $sqlTask = "SELECT id_task FROM `purpose_workers` WHERE `id_worker` = :id";
    $paramTask = array(
      "id" => $_GET["id"]
    );
    
    $task = $database->selectFirstCell($sqlTask, $paramTask);
    
    $sqlDelete = "DELETE FROM `purpose_workers` WHERE `id_task` = :id_task";
    $paramDelete = array(
      "id_task" => $task
    );

    $database->doRequest($sqlDelete, $paramDelete);

    $sql = "UPDATE `tasks` SET `id_worker`= :id_user, `state`=:state WHERE id_task = :id_task";
    $param = array(
      "id_user" => $_GET["id"],
      "state" => "private",
      "id_task" => $task
    );
    
    $database->doRequest($sql, $param);

    addNotification($_SESSION["id"], $task, "Вы назначили исполнителя");
    addNotification($_GET["id"], $task, "Вас выбрали исполнителем");

    header("location: http://localhost/lk.php");

//   var_dump($database->selectAll($sqlTask, $paramTask));
