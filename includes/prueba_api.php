<?php

include('lib/php/loadAll.php');

//$apiMethod = $_POST['apimethod'];
$apiMethod = "login";

if (isset($apiMethod)) {
  switch ($apiMethod) {
    case 'login': {
        if (!isset($username)  && !isset($password)) {
          $user = Doctrine_Query::create()->from('Administradores')
            ->where('username = ?', $username_email)
            ->orWhere('email = ?', $username_email)
            ->execute()
            ->getFirst();

          if (password_verify($password, $user->password) == true) {
            //hace que las cookie solo dure un dia
            session_start([
              'cookie_lifetime' => 86400,
              'read_and_close'  => true
            ]);
            $_SESSION['id'] = $rows[0]['id'];
            $_SESSION['email'] = $rows[0]['email'];
            //$_SESSION['session_id'] = session_id();

            header("location: ../home.php?page=menu");
            header('Content-type: application/json');
            echo json_encode(['type' => 'error', 'data' => 'error en la contraseña, repitala por favor...']);

            //aqui que hago xD

          }
        }
        ?>
      <div>
        <?php

        foreach ($reg as $key => $value) {

          echo "<div>$value</div>";
        }

        ?>
      </div> <?php
              break;
            }
        }
      }


      ?>