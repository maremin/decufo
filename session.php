<?php
    require "database.php";
    // error_reporting(E_ERROR | E_PARSE);
    session_start();
    
    if($_SESSION["rule"] == FALSE){
        $_SESSION["rule"] = 5;
    }
    

    function saveAuth($id){
        $dataBase = new Database();
        $sql = "SELECT id_user, surname, user_name, last_name, id_user_role, group_rules from users join groups where users.id_group = groups.id_group AND id_user = :id";
        $param = array(
            "id" => $id
       );
       
       foreach ($dataBase->selectAll($sql, $param)   as $item) {
           $_SESSION["id"] = $item["id_user"];
           $_SESSION["rule"] = $item["group_rules"];
           $_SESSION["surname"] = $item["surname"];
           $_SESSION["user_name"] = $item["user_name"];
           $_SESSION["last_name"] = $item["last_name"];
           $_SESSION["user_role"] = $item["id_user_role"];
        }
        
        $_SESSION["theme"] = "light";
        
       checkrule();
    }


    function checkrule(){
        if ($_SESSION["rule"] == 5) {
            $_SESSION["rule"] = 30;
        }
    }

    function checkUser(){
        if($_SESSION["rule"] >= 99){
            return "admin.php";
        }

        else{
            return "lk.php";
        }
    } 

    function checkReg(){
        if($_SESSION["rule"] <= 10){
            return "login.php";
        }

        else{
            return "tasks.php";
        }
    }

    function countReview($id_user){
        $dataBase = new Database();

        $sql = "SELECT * FROM `reviews` WHERE `id_recipient` = :id";
        $param = array(
            "id" => $id_user
        );

        return $dataBase->countRow($sql, $param);
    }
    
    function countTasks($id_user){
        $dataBase = new Database();

        $sql = "SELECT * FROM `tasks` WHERE `id_worker` = :id";
        $param = array(
            "id" => $id_user
        );

        return $dataBase->countRow($sql, $param);
    }
    
    function addNotification($id_user, $id_task, $type){
        $dataBase = new Database();
        
        $sql = "INSERT INTO `notifications`(`id_user`, `notification_type`, `id_task`) VALUES (:id_user, :type, :id_task)";
        $param = array(
            "id_user" => $id_user,
            "id_task" => $id_task,
            "type" => $type
        );
        
        $dataBase->getInsert($sql, $param);
    }

    function randomString() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 32; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
