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

    case 'setPp_aside': {
        if (isset($_FILES['foto'])) {

          $name_file = $_FILES['foto']['name'];
          $tmp_name = $_FILES['foto']['tmp_name'];
          $local_image = "../../assets/images/";
          move_uploaded_file($tmp_name, $local_image . $name_file);
        } else {
          echo "no se encontro imagen alguna";
        }
        if (isset($_FILES['archivos'])) {
          $total_files = count($_FILES['archivos']['name']);
          for ($key = 0; $key < $total_files; $key++) {

            $name_archivos = $_FILES['archivos']['name'];
            $tmp_name = $_FILES['archivos']['tmp_name'];
            $local_image = "../../assets/images/";
            move_uploaded_file($tmp_name, $local_image . $name_archivos);
          }
        } else {
          echo "no se encontro archivo alguno";
        }
        if (isset($_POST['id'])) {

          $noticia_lateral = Doctrine_Query::create()->from('Pp_aside')
            ->where('id = ?', $_POST['id'])
            ->execute()
            ->getFirst();
          //si devuelve hace el update
          if (isset($noticia_lateral->id)) {

            $noticia_lateral->titulo = $_POST['titulo'];
            $noticia_lateral->descripcion = $_POST['descripcion'];
            $noticia_lateral->foto = $name_file;
            if (isset($_FILES['archivos'])) {
              $total_files = count($_FILES['archivos']['name']);
              for ($key = 0; $key < $total_files; $key++) {

                $name_archivos = $_FILES['archivos']['name'];
                $noticia_lateral->descripcion =  $name_archivos;
              }
            }
          }
        } else {
          echo "entro en insert";
          $noticia_lateral = new Pp_aside();
          $noticia_lateral->titulo = $_POST['titulo'];
          $noticia_lateral->descripcion = $_POST['descripcion'];
          $noticia_lateral->foto = $name_file;

          $noticia_lateral->archivos = $name_archivos;
        }

        try {
          move_uploaded_file($tmp_name, $local_image . $name_file);
          $noticia_lateral->save();
          header('Content-type: application/json');
          echo json_encode(['type' => 'ok', 'data' => 'nueva noticia lateral subida']);

          header('location:  ../intranet/index.php?page=Noticias_lateral');
        } catch (Exception $e) {
          header('Content-type: application/json');
          echo json_encode(['type' => 'error', 'data' => 'fallo al subir']);
        }
        break;
      }



    case 'setNoticias': {
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $categoria_id = $_POST['categorias'];
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
        } else {
          $multimedia = new Multimedia();
          $multimedia->save();
        }

        //si no pues hace un insert;
        $noticia = new Noticia();
        $noticia->titulo = $titulo;
        $noticia->descripcion = $descripcion;
        $noticia->categoria_id = $categoria_id;

        $noticia->save();

         foreach($arrayArchivos as $archivo){
          $multimedia= new Multimedia();
          $multimedia->url=$archivo;
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
        
          /*¿no funca?*/

        header('Content-type: application/json');
        header("location:  ../intranet/index.php?page=" . $categorias);
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
