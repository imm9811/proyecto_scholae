<?php

include('php/loadAll.php');

//$apiMethod = $_POST['apimethod'];
//$apiMethod = $_POST['apiMethod'];
$apiMethod="prueba";
$password=123;
if (isset($apiMethod)) {
  switch ($apiMethod) {
      case 'prueba':{
        
        $username_email='alfonso';
        $user = Doctrine_Query::create()->from('Administradores')
        ->where('username = ?', $username_email)
        ->orWhere('correo = ?', $username_email)
        ->execute()
        ->getFirst();


        if(password_verify($password, $user->contrasena) == true){
          echo $user->nombre;
        }
        if(!isset($user->nombre)){
          echo "null";
        }
        else{
         echo $user->id;
        }
        break;
      }
    }
  }

?>