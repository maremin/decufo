<?php
   require "session.php";
  
   if(isset($_POST["name"]) && isset($_POST["pwd"])) {

  $dataBase = new Database();
    $sql = "SELECT * from users where e_mail = :name and pwd = :pwd";
    $param = array(
      "name" => $_POST["name"],
      "pwd" => $_POST["pwd"]
    );
   
        if($dataBase->countRow($sql, $param) == 1) {
            $user = $dataBase->selectAll($sql, $param); 
            saveAuth($dataBase->selectFirstCell($sql, $param));
            if($_SESSION["rule"] > 99){
            header("location: http://localhost/admin.php");
          }
            else{
              header("location: http://localhost/");
            }
        }
        else {
            include("auth.php");
            echo "<p>Неправильно введен пароль или логин</p>";
        }
  }
  else {
    include("auth.php");
}
?>