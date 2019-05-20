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

        if (isset($username_email)  && isset($password)) {

          $user = Doctrine_Query::create()->from('Administradores')
            ->where('username = ?', $username_email)
            ->orWhere('correo = ?', $username_email)
            ->execute()
            ->getFirst();

          if ($user != null) {
            //if (password_verify($password, $user->password) == true) {
            if ($password == $user->contrasena || password_verify($password, $user->contrasena) == true) {
              
              header('Content-type: application/json');
              echo json_encode(['type' => 'ok', 'data' => 'Acceso valido']);
              //aqui que hago xD
            } else {
              header('Content-type: application/json');
              echo json_encode(['type' => 'error', 'data' => 'error en la contraseña, repitala por favor...']);
            }
          } else {
            header('Content-type: application/json');
            echo json_encode(['type' => 'error', 'data' => 'no se ha encontrado usuario']);
          }
        } else {
          //no se ha encontrado o introducido usuario
          header('Content-type: application/json');
          echo json_encode(['type' => 'error', 'data' => 'no se ha introducido un usuario o contraseña']);
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
    case 'selectAdministradores': {


        $administrador = Doctrine_Query::create()->from('Administradores')
          ->where('id = ?', $_POST["id"])
          ->execute()
          ->getFirst();
        break;
      }


    case 'setAdministradores': {
        $administrador = Doctrine_Query::create()->from('Administradores')
          ->where('id = ?', $_POST['id'])
          ->execute()
          ->getFirst();
          //si devuelve hace el update
          
        if (isset($administrador->id)) {
        //  echo "hello";debug();die();
          $administrador->nombre = $_POST['usuario'];
          $administrador->apellidos = $_POST['apellido'];
          $administrador->username = $_POST['username'];
          $administrador->correo = $_POST['correo'];
          if (isset($_POST['contrasena'])) {
            $administrador->contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
          }
          // si no hace el insert
        } else {
          echo "entro en insert";
          $administrador = new Administradores();
          $administrador->nombre = $_POST['usuario'];
          $administrador->apellidos = $_POST['apellido'];
          $administrador->username = $_POST['username'];
          $administrador->correo = $_POST['correo'];
          if (isset($_POST['contrasena'])) {
            $administrador->contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
          }
        }

        try {
          $administrador->save();
          header('Content-type: application/json');
          echo json_encode(['type' => 'ok', 'data' => 'nuevo administrador subido']);

          header('location:  ../intranet/index.php?page=Administradores');
        } catch (Exception $e) {
          header('Content-type: application/json');
          echo json_encode(['type' => 'error', 'data' => 'fallo al subir']);
        }
        break;
      }
     
      case 'setPlataformas': {
        if(isset($_FILES['file'])){
         
          $name_file = $_FILES['file']['name'];
          $tmp_name = $_FILES['file']['tmp_name'];
          $local_image = "../../assets/images/";
          move_uploaded_file($tmp_name, $local_image.$name_file);
        }
        else{
          echo "no se encontro imagen alguna";
        }
        if(isset($_POST['id'])){
  
          $plataforma = Doctrine_Query::create()->from('Plataformas')
            ->where('id = ?', $_POST['id'])
            ->execute()
            ->getFirst(); 
            //si devuelve hace el update
            if (isset($plataforma->id)) {
              //  echo "hello";debug();die();
                $plataforma->titulo = $_POST['titulo'];
                $plataforma->foto = $name_file;
                $plataforma->descripcion = $_POST['enlace'];
                // si no hace el insert
              }
        } else {
          echo "entro en insert";
          $plataforma = new Plataformas();
          $plataforma->titulo = $_POST['titulo'];
          $plataforma->foto = $name_file;
          $plataforma->descripcion = $_POST['enlace'];
        }
  
        try {
          move_uploaded_file($tmp_name, $local_image.$name_file);
          $plataforma->save();
          header('Content-type: application/json');
          echo json_encode(['type' => 'ok', 'data' => 'nueva plataforma subida']);

          header('location:  ../intranet/index.php?page=Plataformas');
        } catch (Exception $e) {
          header('Content-type: application/json');
          echo json_encode(['type' => 'error', 'data' => 'fallo al subir']);
          debug();die();
        }
        break;
      }

    case 'delete': {
        $categorias = $_POST["categoria"];
        $id = $_POST['id'];

        $q = Doctrine_Query::create()
          ->delete($categorias)
          ->where("id = ?", $id)
          ->execute()
          ->getFirst();
        /*¿no funca?*/

        header('Content-type: application/json');
        header('location:  ../intranet/index.php?page=Administradores');
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
