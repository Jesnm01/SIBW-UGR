<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);


  $bd = new BaseDatos();


  session_start();

  if (isset($_GET['id'])) {
    $id_evento = $_GET['id'];
  } else {
    $id_evento = -1;
  }

  if (isset($_SESSION['nickUsuario'])){
    $user = $bd->getUser($_SESSION['nickUsuario']);
    $usuario = array('nick' => $user['nombre'], 'email' => $user['email'], 'fecha_nac' => $user['fecha_nacimiento'], 'mod' => $user['moderador'], 'gestor' => $user['gestor'], 'super' => $user['super']);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_FILES['foto_cabecera'])){

        $errors= array();
        if($_FILES['foto_cabecera']['error'] != 4){ //El error 4 se da cuando no se selecciona ninguna imagen
            
            $file_name = $_FILES['foto_cabecera']['name'];
            $file_size = $_FILES['foto_cabecera']['size'];
            $file_tmp = $_FILES['foto_cabecera']['tmp_name'];
            $file_type = $_FILES['foto_cabecera']['type'];
            $file_ext = strtolower(end(explode('.',$_FILES['foto_cabecera']['name'])));
            
            $extensions= array("jpeg","jpg","png");
            
            if (in_array($file_ext,$extensions) === false){
                $errors[] = "Extensión no permitida, elige una imagen JPG, JPEG o PNG.";
            }
            
            if ($file_size > 2097152){
                $errors[] = 'Tamaño del fichero demasiado grande';
            }
            
            if (empty($errors)) {
                move_uploaded_file($file_tmp, "images/" . $file_name);
                
                $path_imagen_cabecera = "images/" . $file_name;

                $res=$bd->editarFotoCabeceraEvento($id_evento, $path_imagen_cabecera);
            }
        }
        else{
            $errors[] = "No ha seleccionado ninguna imagen";
        }
    }




    if(isset($_FILES['imagenes_slideshow'])){
// var_dump($_FILES['imagenes_slideshow']);
        $imagenes_slideshow = [];
        $errors= array();


        if($_FILES['imagenes_slideshow']['error'][0] != 4){ //El error 4 se da cuando no se selecciona ninguna imagen

            //Aqui invierto la estructura del array del $_FILE y tener un array propio con todo
            for($i = 0; $i < sizeof($_FILES['imagenes_slideshow']['name']); $i++){
                $imagenes_slideshow[$i]['name'] = $_FILES['imagenes_slideshow']['name'][$i];
                $imagenes_slideshow[$i]['type'] = $_FILES['imagenes_slideshow']['type'][$i];
                $imagenes_slideshow[$i]['tmp_name'] = $_FILES['imagenes_slideshow']['tmp_name'][$i];
                $imagenes_slideshow[$i]['error'] = $_FILES['imagenes_slideshow']['error'][$i];
                $imagenes_slideshow[$i]['size'] = $_FILES['imagenes_slideshow']['size'][$i];
            }

            $extensions= array("jpeg","jpg","png");
            for($i = 0; $i < sizeof($_FILES['imagenes_slideshow']['name']); $i++){

                $imagenes_slideshow[$i]['ext'] = strtolower(end(explode('.',$imagenes_slideshow[$i]['name'])));
                if(in_array($imagenes_slideshow[$i]['ext'], $extensions) === false){
                    $errors[] = "Extensión no permitida para " . $imagenes_slideshow[$i]['name'] . ", elige una imagen JPG, JPEG o PNG.";
                }
                if ($imagenes_slideshow[$i]['size'] > 3145728){
                    $errors[] = "Tamaño del fichero " . $imagenes_slideshow[$i]['name'] . " demasiado grande. Máximo 3MB";
                }
            }
            
            $i = 0;
            if (empty($errors)) {
                foreach ($imagenes_slideshow as $imagen){

                    move_uploaded_file($imagen['tmp_name'], "images/" . $imagen['name']);

                    $path_imagen = "images/" . $imagen['name'];

                    $res=$bd->aniadirFotoSlideShowEvento($id_evento, $path_imagen);
                    $i++;
                }
            }
        }
        else{
            $errors[] = "No ha seleccionado ninguna imagen para los slideshows";
        }
    }

    if(isset($_POST['captions'])){
        $captions = $_POST['captions'];
        $ids_fotos_slideshow = $_POST['ids_fotos'];

        $i = 0;

        foreach ($ids_fotos_slideshow as $id){

            $res=$bd->editarCaptionSlideShowEvento($id_evento, $id, $captions[$i]);
            $i++;
        }
    }

  }

  $evento = $bd->getEvento($id_evento);
  $fotos_slideshow = $bd->getFotosEvento($id_evento);
  $lista_tags = $bd->getTagList($id_evento);

  $lista_tags_descripciones = array();
  foreach ($lista_tags as $tag){
      array_push($lista_tags_descripciones, $tag['descripcion']);
  }  
  $tags_formateadas = implode(';',$lista_tags_descripciones);


  echo $twig->render('editarEvento.html', ['user' => $usuario, 'evento' => $evento, 'errores' => $errors, 
  'fotos_slideshow' => $fotos_slideshow, 'tags_formateadas' => $tags_formateadas]);

?>