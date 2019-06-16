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
          $user = Doctrine_Query::create()->from('Administrador')
            ->where('alias = ?', $username_email)
            ->orWhere('correo = ?', $username_email)
            ->execute()
            ->getFirst();

          if ($user != null) {
            //if (password_verify($password, $user->password) == true) {
            if ($password == $user->contrasena || password_verify($password, $user->contrasena) == true) {

              header('Content-type: application/json');
              echo json_encode(['type' => 'ok', 'data' => 'Acceso valido']);
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
        $plataformasArray = Doctrine_Query::create()->from('Plataforma')
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
    case 'setCategoria': {
        $nom_original = $_POST['nombre'];
        $categoria= ucwords(strtolower($nom_original));
        $id = $_POST['id'];
        if (isset($_POST['id'])) {
          $categorias = Doctrine_Query::create()->from('Categoria')
            ->where('id = ?', $_POST['id'])
            ->execute()
            ->getFirst();
          $categorias->nombre = $categoria;
        } else {
          $categorias = new Categoria();
          $categorias->nombre = $categoria;
        }

        try {
          $categorias->save();
          header('Content-type: application/json');
          echo json_encode(['type' => 'ok', 'data' => 'nueva categoria subida']);

          header('location:  ../intranet/index.php?page=Categorias');
        } catch (Exception $e) {
          header('Content-type: application/json');
          echo json_encode(['type' => 'error', 'data' => 'fallo al subir']);
        }
        break;
      }

    case 'setAdministradores': {
        $administrador = Doctrine_Query::create()->from('Administrador')
          ->where('id = ?', $_POST['id'])
          ->execute()
          ->getFirst();
        //si devuelve hace el update

        if (isset($administrador->id)) {
          $administrador->nombre = $_POST['usuario'];
          $administrador->apellidos = $_POST['apellido'];
          $administrador->alias = $_POST['alias'];
          $administrador->correo = $_POST['correo'];
          if (isset($_POST['contrasena'])) {
            $administrador->contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
          }
          // si no hace el insert
        } else {
          $administrador = new Administrador();
          $administrador->nombre = $_POST['usuario'];
          $administrador->apellidos = $_POST['apellido'];
          $administrador->alias = $_POST['alias'];
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
        if (isset($_FILES['file'])) {

          $name_file = $_FILES['file']['name'];
          $tmp_name = $_FILES['file']['tmp_name'];
          $local_image = "../../assets/images/";
          move_uploaded_file($tmp_name, $local_image . $name_file);
        } else {
          echo "no se encontro imagen alguna";
        }
        if (isset($_POST['id'])) {

          $plataforma = Doctrine_Query::create()->from('Plataforma')
            ->where('id = ?', $_POST['id'])
            ->execute()
            ->getFirst();

          //si devuelve hace el update
          if (isset($plataforma->id)) {
            $plataforma->titulo = $_POST['titulo'];
            if (isset($_FILES['file'])) {
              $plataforma->foto = $name_file;
            }
            $plataforma->enlace = $_POST['enlace'];
            // si no hace el insert
          }
        } else {

          $plataforma = new Plataforma();
          $plataforma->titulo = $_POST['titulo'];
          if (isset($_FILES['file'])) {
            $plataforma->foto = $name_file;
          }
          $plataforma->enlace = $_POST['enlace'];
        }

        try {

          $plataforma->save();
          header('Content-type: application/json');
          echo json_encode(['type' => 'ok', 'data' => 'nueva plataforma subida']);
          header('location:  ../intranet/index.php?page=Plataformas');
        } catch (Exception $e) {
          header('Content-type: application/json');
          echo json_encode(['type' => 'error', 'data' => 'fallo al subir']);
        }
        break;
      }

    case 'setNoticias': {
        $titulo = $_POST['titulo'];
        $categoria_id = $_POST['categorias'];
        $video=$_POST['video'];
        $arrayArchivos = [];
        
        if (isset($_FILES["archivo"]['name'])) {
          foreach ($_FILES["archivo"]['name'] as $key => $tmp_name) {
            
            //Validamos que el archivo exista
            if ($_FILES["archivo"]["name"][$key]) {
              $filename = $_FILES["archivo"]["name"][$key]; //Obtenemos el nombre original del archivo
			        $source = $_FILES["archivo"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
              
              $directorio = '../../assets/images'; //Declaramos un  variable con la ruta donde guardaremos los archivos

              //Validamos si la ruta de destino existe, en caso de no existir la creamos
              if (!file_exists($directorio)) {
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");
              }

              $dir = opendir($directorio); //Abrimos el directorio de destino
              $target_path = $directorio . '/' . $filename; //Indicamos la ruta de destino, así como el nombre del archivo

              //Movemos y validamos que el archivo se haya cargado correctamente
              //El primer campo es el origen y el segundo el destino
              if (move_uploaded_file($source, $target_path)) {
                
                echo "El archivo $filename se ha almacenado en forma exitosa.<br>";
              } else {
                echo "Ha ocurrido un error, por favor inténtelo de nuevo.<br>";
              }
              array_push($arrayArchivos,$filename);
              closedir($dir); //Cerramos el directorio de destino
            }
          }
        }

        //ACTUALIZAR / UPDATE
        if(isset($_POST['id'])){
          $descripcion = $_POST['descripcion1'];
          //si no pues hace un insert;
         $noticia = Doctrine_Query::create()->from('Noticia')
            ->where('id = ?', $_POST['id'])
            ->execute()
            ->getFirst();

          $noticia->titulo = $titulo;
          $noticia->descripcion = $descripcion;
          $noticia->categoria_id = $categoria_id;

          $noticia->save();
          //si contiene valores hace los cambios (borrar y luego introduce)
          if(sizeof($arrayArchivos) != 0){
              $q = Doctrine_Query::create()
              ->delete('Multimedia')
              ->where("noticia_id = ?", $id)
              ->execute();
            foreach($arrayArchivos as $archivo){
              $multimedia= new Multimedia();
              $multimedia->url=$archivo;
              $multimedia->noticia_id=$noticia->id;
              $multimedia->save();
            }
          }

          if(isset($video)){
             $multimedia = Doctrine_Query::create()->from('Multimedia')
              ->where('id = ?',  $_POST['id_video'])
              ->execute()
              ->getFirst();
             if(isset($multimedia->id)){
             
              $multimedia->url=$video;
              $multimedia->noticia_id=$_POST['id'];
              $multimedia->save();
             }else{
              $multimedia= new Multimedia();
              $multimedia->url=$video;
              $multimedia->noticia_id=$_POST['id'];
              $multimedia->save();
             }
             
           } 
           
          if(isset($_POST['arrayFotos'])){
            
            $cadena=$_POST['arrayFotos'];
            
            $array = explode(",", $cadena);
            
            foreach($array as $valor){
              
              $multimedia = Doctrine_Query::create()->from('Multimedia')
              ->where('id = ?',  $valor)
              ->execute()
              ->getFirst();
              $multimedia->eliminado=1;
              $multimedia->save();
            }
          }

          $noticia = Doctrine_Query::create()
          ->from('Noticia')
          ->where('titulo = ?', $_POST['titulo'])
          ->execute()
          ->getFirst();

          $noticia->multimedia_id=$noticia->id;
          $noticia->save();
           
        }
        // INSERTAR / INSERT
        
        else{
          $descripcion = $_POST['descripcion'];
          //si no pues hace un insert;
          $noticia = new Noticia();
          $noticia->titulo = $titulo;
          $noticia->descripcion = $descripcion;
          $noticia->categoria_id = $categoria_id;

          $noticia->save();
          if(!empty($arrayArchivos)){
            foreach($arrayArchivos as $archivo){
              $multimedia= new Multimedia();
              $multimedia->url=$archivo;
              $multimedia->noticia_id=$noticia->id;
              $multimedia->save();
            }
          }

          if(isset($video)){
            $multimedia= new Multimedia();
            $multimedia->url=$video;
            $multimedia->noticia_id=$noticia->id;
            $multimedia->save();
          } 
          
          $noticia = Doctrine_Query::create()
          ->from('Noticia')
          ->where('titulo = ?', $_POST['titulo'])
          ->execute()
          ->getFirst();

          $noticia->multimedia_id=$noticia->id;
          $noticia->save();
        }
         
        header('location:  ../intranet/index.php?page=Noticias');
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

        if($categorias=='Noticia'){
          
          $q = Doctrine_Query::create()
          ->delete('Multimedia')
          ->where("noticia_id = ?", $id)
          ->execute();
        }


        header('Content-type: application/json');
        header('location:  ../intranet/index.php?page=$categorias');
        break;
      }

      /*---------------------------------------------------------------------*/
  } //fin switch

} //fin if
else {
  header('Content-type: application/json');
  echo json_encode(['type' => 'error', 'message' => 'No se ha enviado método de API']);
}


function getFileExtension($string)
{
  $array = explode('.', $string);
  return end($array);
}
