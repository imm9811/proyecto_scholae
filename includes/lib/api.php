<?php

// poner este archivo en la ** raíz ** del proyecto

include('php/loadAll.php');

//if($apiKey == 'd5501f1f-ba83-4a82-b9b0-0bc96d1927b1') {
$apiMethod = $_POST['apiMethod'];
/*OJO: El nombre de la tabla para Doctrine es SIEMPRE LA PRIMERA EN MAYUSCULAS (Doctrine = 'User', tabla en bbdd = 'user')

CONSULTAS SELECT

// quitale el getFirst() para obtener un array de resultados de la tabla user

$reg = Doctrine_Query::create()->from('User')
                            ->where('token = ?',$_POST['editToken'])
                            ->execute()
                            ->getFirst();
                            
INSERT/UPDATE

$account = new Account();
$account->name = 'test 1';

$account->amount = '100.00';
$account->save();

$account = new Account();
$account->name = 'test 2';
$account->amount = '200.00';
$account->save();

// para guardar el registro utilizamos save()

NOTA: Si obtienes el registro de la siguiente forma:

$account = Doctrine_Query::create()->from('Account')
                            ->where('id = ?', 1)
                            ->execute()
                            ->getFirst();

Tambien puedes actualizar los campos y lo hará Doctrine solo:

$account->name = 'nombre actualizado';
$account->save();                            */
if (isset($apiMethod)) {
  switch ($apiMethod) {
    case 'login': {
        $username_email = $_POST['usuario'];
        $password = $_POST['contrasena'];
        // $lang = $_POST['lang'];
        

        if (isset($username_email)  && isset($password)) {
          
          $user = Doctrine_Query::create()->from('Administradores')
            ->where('username = ?', $username_email)
            ->orWhere('correo = ?', $username_email)
            ->execute()
            ->getFirst();
            
         // if (password_verify($password, $user->password) == true) {
           if($password == $user->contrasena){
              //hace que las cookie solo dure un dia
              
              session_start([
                'cookie_lifetime' => 86400,
                'read_and_close'  => true
              ]);
              $_SESSION['id'] = $rows[0]['id'];
              $_SESSION['email'] = $rows[0]['email'];
            
              $_SESSION['session_id'] = session_id();
            
              header('Content-type: application/json');
              echo json_encode(['type' => 'ok', 'data' => 'Acceso valido']);
              //aqui que hago xD
            }else {
           
            header('Content-type: application/json');
            echo json_encode(['type' => 'error', 'data' => 'error en la contraseña, repitala por favor...']);
          }
        } else {
          //no se ha encontrado o introducido usuario
          header('Content-type: application/json');
          echo json_encode(['type' => 'error', 'data' => 'no se ha introducido un usuario o contraseña correcta']);
        }

        break;
      } //fin case

    case 'register': {
        $name = $_POST['nombre'];
        $username = $_POST['nameuser'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $checkpassword = $_POST['checkpassword'];
        if ($pass == $passConfirm && password_verify($pass, $passHash) && password_verify($passConfirm, $passHashConfirm)) {
          $enabled = 1;
          echo ("correcto");
        }
        break;
      }
    case 'getPlataformas': {
        $plataformasArray = Doctrine_Query::create()->from('Plataformas')
          ->execute();
        if (!isset($plataformasArray)) {
          header('Content-type: application/json');
          echo json_encode(['type' => 'ok', 'data' => $plataformasArray]);
        } else {
          header('Content-type: application/json');
          echo json_encode(['type' => 'error', 'data' => 'fallo al buscar plataformas']);
        }
        break;
      }

    case 'setPlataformas': {
        $plataforma = new plataforma();
        if (!isset($_POST['titulo']) || !isset($_POST['foto']) || !isset($_POST['descripcion'])) {
          $account->titulo = '100.00';
          $account->save();

          $account = new Account();
          $account->name = 'test 2';
          $account->amount = '200.00';
          $account->save();
          header('Content-type: application/json');
          echo json_encode(['type' => 'ok', 'data' => 'inserccion / actualizacion correcta']);
        } else {
          header('Content-type: application/json');
          echo json_encode(['type' => 'error', 'data' => 'fallo al introducir plataforma ']);
        }

        break;
      }



      /*case modelo
    case '  ':{
      
      break;
    }
*/



      /*---------------------------------------------------------------------*/
  } //fin switch

} //fin if
else {
  header('Content-type: application/json');
  echo json_encode(['type' => 'error', 'message' => 'No se ha enviado método de API']);
  die;
}


function getFileExtension($string)
{
  $array = explode('.', $string);
  return end($array);
}
