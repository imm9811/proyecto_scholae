<?php

// poner este archivo en la ** raíz ** del proyecto

include('lib/php/loadAll.php');

$apiKey = $_SERVER['HTTP_X_API_KEY'];

// tipos de mime
$types = array(
  'ai'      => 'application/postscript',
  'aif'     => 'audio/x-aiff',
  'aifc'    => 'audio/x-aiff',
  'aiff'    => 'audio/x-aiff',
  'asc'     => 'text/plain',
  'atom'    => 'application/atom+xml',
  'atom'    => 'application/atom+xml',
  'au'      => 'audio/basic',
  'avi'     => 'video/x-msvideo',
  'bcpio'   => 'application/x-bcpio',
  'bin'     => 'application/octet-stream',
  'bmp'     => 'image/bmp',
  'cdf'     => 'application/x-netcdf',
  'cgm'     => 'image/cgm',
  'class'   => 'application/octet-stream',
  'cpio'    => 'application/x-cpio',
  'cpt'     => 'application/mac-compactpro',
  'csh'     => 'application/x-csh',
  'css'     => 'text/css',
  'csv'     => 'text/csv',
  'dcr'     => 'application/x-director',
  'dir'     => 'application/x-director',
  'djv'     => 'image/vnd.djvu',
  'djvu'    => 'image/vnd.djvu',
  'dll'     => 'application/octet-stream',
  'dmg'     => 'application/octet-stream',
  'dms'     => 'application/octet-stream',
  'doc'     => 'application/msword',
  'dtd'     => 'application/xml-dtd',
  'dvi'     => 'application/x-dvi',
  'dxr'     => 'application/x-director',
  'eps'     => 'application/postscript',
  'etx'     => 'text/x-setext',
  'exe'     => 'application/octet-stream',
  'ez'      => 'application/andrew-inset',
  'gif'     => 'image/gif',
  'gram'    => 'application/srgs',
  'grxml'   => 'application/srgs+xml',
  'gtar'    => 'application/x-gtar',
  'hdf'     => 'application/x-hdf',
  'hqx'     => 'application/mac-binhex40',
  'htm'     => 'text/html',
  'html'    => 'text/html',
  'ice'     => 'x-conference/x-cooltalk',
  'ico'     => 'image/x-icon',
  'ics'     => 'text/calendar',
  'ief'     => 'image/ief',
  'ifb'     => 'text/calendar',
  'iges'    => 'model/iges',
  'igs'     => 'model/iges',
  'jpe'     => 'image/jpeg',
  'jpeg'    => 'image/jpeg',
  'jpg'     => 'image/jpeg',
  'js'      => 'application/x-javascript',
  'json'    => 'application/json',
  'kar'     => 'audio/midi',
  'latex'   => 'application/x-latex',
  'lha'     => 'application/octet-stream',
  'lzh'     => 'application/octet-stream',
  'm3u'     => 'audio/x-mpegurl',
  'man'     => 'application/x-troff-man',
  'mathml'  => 'application/mathml+xml',
  'me'      => 'application/x-troff-me',
  'mesh'    => 'model/mesh',
  'mid'     => 'audio/midi',
  'midi'    => 'audio/midi',
  'mif'     => 'application/vnd.mif',
  'mov'     => 'video/quicktime',
  'movie'   => 'video/x-sgi-movie',
  'mp2'     => 'audio/mpeg',
  'mp3'     => 'audio/mpeg',
  'mpe'     => 'video/mpeg',
  'mpeg'    => 'video/mpeg',
  'mpg'     => 'video/mpeg',
  'mpga'    => 'audio/mpeg',
  'ms'      => 'application/x-troff-ms',
  'msh'     => 'model/mesh',
  'mxu'     => 'video/vnd.mpegurl',
  'nc'      => 'application/x-netcdf',
  'oda'     => 'application/oda',
  'ogg'     => 'application/ogg',
  'pbm'     => 'image/x-portable-bitmap',
  'pdb'     => 'chemical/x-pdb',
  'pdf'     => 'application/pdf',
  'pgm'     => 'image/x-portable-graymap',
  'pgn'     => 'application/x-chess-pgn',
  'png'     => 'image/png',
  'pnm'     => 'image/x-portable-anymap',
  'ppm'     => 'image/x-portable-pixmap',
  'ppt'     => 'application/vnd.ms-powerpoint',
  'ps'      => 'application/postscript',
  'qt'      => 'video/quicktime',
  'ra'      => 'audio/x-pn-realaudio',
  'ram'     => 'audio/x-pn-realaudio',
  'ras'     => 'image/x-cmu-raster',
  'rdf'     => 'application/rdf+xml',
  'rgb'     => 'image/x-rgb',
  'rm'      => 'application/vnd.rn-realmedia',
  'roff'    => 'application/x-troff',
  'rss'     => 'application/rss+xml',
  'rtf'     => 'text/rtf',
  'rtx'     => 'text/richtext',
  'sgm'     => 'text/sgml',
  'sgml'    => 'text/sgml',
  'sh'      => 'application/x-sh',
  'shar'    => 'application/x-shar',
  'silo'    => 'model/mesh',
  'sit'     => 'application/x-stuffit',
  'skd'     => 'application/x-koan',
  'skm'     => 'application/x-koan',
  'skp'     => 'application/x-koan',
  'skt'     => 'application/x-koan',
  'smi'     => 'application/smil',
  'smil'    => 'application/smil',
  'snd'     => 'audio/basic',
  'so'      => 'application/octet-stream',
  'spl'     => 'application/x-futuresplash',
  'src'     => 'application/x-wais-source',
  'sv4cpio' => 'application/x-sv4cpio',
  'sv4crc'  => 'application/x-sv4crc',
  'svg'     => 'image/svg+xml',
  'svgz'    => 'image/svg+xml',
  'swf'     => 'application/x-shockwave-flash',
  't'       => 'application/x-troff',
  'tar'     => 'application/x-tar',
  'tcl'     => 'application/x-tcl',
  'tex'     => 'application/x-tex',
  'texi'    => 'application/x-texinfo',
  'texinfo' => 'application/x-texinfo',
  'tif'     => 'image/tiff',
  'tiff'    => 'image/tiff',
  'tr'      => 'application/x-troff',
  'tsv'     => 'text/tab-separated-values',
  'txt'     => 'text/plain',
  'ustar'   => 'application/x-ustar',
  'vcd'     => 'application/x-cdlink',
  'vrml'    => 'model/vrml',
  'vxml'    => 'application/voicexml+xml',
  'wav'     => 'audio/x-wav',
  'wbmp'    => 'image/vnd.wap.wbmp',
  'wbxml'   => 'application/vnd.wap.wbxml',
  'wml'     => 'text/vnd.wap.wml',
  'wmlc'    => 'application/vnd.wap.wmlc',
  'wmls'    => 'text/vnd.wap.wmlscript',
  'wmlsc'   => 'application/vnd.wap.wmlscriptc',
  'wrl'     => 'model/vrml',
  'xbm'     => 'image/x-xbitmap',
  'xht'     => 'application/xhtml+xml',
  'xhtml'   => 'application/xhtml+xml',
  'xls'     => 'application/vnd.ms-excel',
  'xml'     => 'application/xml',
  'xpm'     => 'image/x-xpixmap',
  'xsl'     => 'application/xml',
  'xslt'    => 'application/xslt+xml',
  'xul'     => 'application/vnd.mozilla.xul+xml',
  'xwd'     => 'image/x-xwindowdump',
  'xyz'     => 'chemical/x-xyz',
  'zip'     => 'application/zip'
);

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
        $username_email = $_POST['user'];
        $password = $_POST['password'];

       // $lang = $_POST['lang'];

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

            header("location: ../index.php?page=panel");
            header('Content-type: application/json');
            echo json_encode(['type' => 'ok', 'data' => 'Acceso valido']);

            //aqui que hago xD
          } else {
            header("location: ../index.php?page=login");
            echo "error en la contraseña, repitala por favor...";
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

    case 'register':{
      $name=$_POST['nombre'];
      $username=$_POST['nameuser'];
      $email=$_POST['email'];
      $password=$_POST['password'];
      $checkpassword=$_POST['checkpassword'];
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
        if(!isset($_POST['titulo']) || !isset($_POST['foto']) || !isset($_POST['descripcion'])){
          $account->titulo = '100.00';
          $account->save();

          $account = new Account();
          $account->name = 'test 2';
          $account->amount = '200.00';
          $account->save();
          header('Content-type: application/json');
          echo json_encode(['type' => 'ok', 'data' => 'inserccion / actualizacion correcta']);
        
        }
        else{
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
