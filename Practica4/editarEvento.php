<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);


  $bd = new BaseDatos();


  session_start();

  if (isset($_GET['id'])) {
    $id_evento = $_GET['id'];
    // $nombre_usuario_comentario = $_GET['nombre_usuario'];
  } else {
    $id_evento = -1;
  }

  if (isset($_SESSION['nickUsuario'])){
    $user = $bd->getUser($_SESSION['nickUsuario']);
    $usuario = array('nick' => $user['nombre'], 'email' => $user['email'], 'fecha_nac' => $user['fecha_nacimiento'], 'mod' => $user['moderador'], 'gestor' => $user['gestor'], 'super' => $user['super']);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST['id_evento'])) { $id_evento = $_POST['id_evento']; }
    if(isset($_POST['nombre'])) { $nombre = $_POST['nombre']; }
    if(isset($_POST['lugar'])) { $lugar = $_POST['lugar']; }
    if(isset($_POST['fecha'])) { $fecha = $_POST['fecha']; }
    if(isset($_POST['organizadores'])) { $organizadores = $_POST['organizadores']; }
    if(isset($_POST['descripcion'])) { $descripcion = $_POST['descripcion']; }
    if(isset($_POST['twitter'])) { $twitter = $_POST['twitter']; }
    if(isset($_POST['facebook'])) { $facebook = $_POST['facebook']; }
    if(isset($_POST['tags'])) { $tags = explode(';',$_POST['tags']); }


    $res = $bd->editarInfoBasicaEvento($id_evento, $nombre, $lugar, $fecha, $organizadores, $descripcion, $twitter, $facebook);
    
    $bd->borrarTags($id_evento);
    foreach ( $tags as $descripcion){
        $bd->aniadirTags($id_evento, $descripcion);
    }

  }
// var_dump($tags);
  $evento = $bd->getEvento($id_evento);
  $fotos_slideshow = $bd->getFotosEvento($id_evento);
  $lista_tags = $bd->getTagList($id_evento);

  $lista_tags_descripciones = array();
  foreach ($lista_tags as $tag){
      array_push($lista_tags_descripciones, $tag['descripcion']);
  }  
  $tags_formateadas = implode(';',$lista_tags_descripciones);

  echo $twig->render('editarEvento.html', ['user' => $usuario, 'evento' => $evento, 'errores' => $errors, 'fotos_slideshow' => $fotos_slideshow, 
  'tags_formateadas' => $tags_formateadas, 'lista_tags_descripciones' => $lista_tags_descripciones]);

?>