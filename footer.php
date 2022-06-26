<?php
    if(isset($_POST["email"])){
        $sqlInsert = "INSERT INTO `feedbacks`(`info`, `feedback_type`) VALUES (:info, :type)";
        $paramInsert = array(
            'info' => $_POST['email'],
            'type' => 'email'
        );
        $database->getInsert($sqlInsert, $paramInsert);
    }

    if(isset($_POST["phone"])){
        $sqlInsert = "INSERT INTO `feedbacks`(`info`, `feedback_type`) VALUES (:info, :type)";
        $paramInsert = array(
            'info' => $_POST['phone'],
            'type' => 'phone'
        );
        $database->getInsert($sqlInsert, $paramInsert);
    }
?>



<footer>
          <div class="main-container">
            <section>
              <p>Подписывайтесь на наши новости</p>
              <form action="" method="POST">
                <div class="input">
                  <img src="/img/mail.svg" alt="mail">
                  <input type="text" name="email" placeholder="E-mail" />
                </div>
                <button type="submit">
                  <img src="/img/arrow.svg" alt="" />
                </button>
              </form>
            </section>
            <section>
              <p>Закажите звонок</p>
              <form action="" method="POST">
                <div class="input">
                  <img src="/img/phone.svg" alt="phone">
                  <input type="text" name="phone" placeholder="Ваш телефон" />
                </div>
                <button type="submit">
                  <img src="/img/arrow.svg" alt="" />
                </button>
              </form>
              <div class="social-media">
                <img src="/img/instagram.svg" alt="instagram" />
                <img src="/img/whatsapp.svg" alt="whatsapp" />
                <img src="/img/tiktok.svg" alt="tiktok" />
              </div>
            </section>
          </div>
</footer>