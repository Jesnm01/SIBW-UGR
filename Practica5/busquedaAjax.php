<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");
  
  $bd = new BaseDatos();

  session_start();

//   header('Content-Type: application/json');

  if (isset($_SESSION['nickUsuario'])){
    $user = $bd->getUser($_SESSION['nickUsuario']);
    $usuario = array('nick' => $user['nombre'], 'email' => $user['email'], 'fecha_nac' => $user['fecha_nacimiento'], 'mod' => $user['moderador'], 'gestor' => $user['gestor'], 'super' => $user['super']);

    /**
     * Si está iniciada sesion y el usuario es gestor o superusuario, que se le muestren todos los eventos en el search box
     * Si está iniciada sesion pero el usuario no es gestor ni super, se le muestran solo los eventos publicados
     * Y si ni siquiera está iniciado sesion, se le muestran tambien solo los publicados
     */
    // 
    if($usuario['gestor'] == 1 || $usuario['super'] == 1){
        $res = $bd->buscarEventos($_GET['term']);
        $res_tags = $bd->buscarTags($_GET['term']);
        
        comprobarTagsYCompletarEventos($res, $res_tags, $bd);
    }
    else{
        $res = $bd->buscarEventosPublicados($_GET['term']);
        $res_tags = $bd->buscarTags($_GET['term']);

        comprobarTagsYCompletarEventosPublicados($res, $res_tags, $bd);
    }
  }
  else{
    $res = $bd->buscarEventosPublicados($_GET['term']);
    $res_tags = $bd->buscarTags($_GET['term']);

    comprobarTagsYCompletarEventosPublicados($res, $res_tags, $bd);
  }

  echo (json_encode($res));



 /**
  * Esto es para poder hacer busquedas en el search box mediante etiquetas tambien. 
  * Necesito saber si los eventos que me buscan los tags ya los tengo en el array '$res' debido a que el termino de busqueda coincida directamente con el nombre del evento o alguna parte de su descripcion
  * Por cada tag encontrado, extraigo de la base de datos el evento asociado y comparo el nombre de ese evento con los nombres de cada uno del los eventos que he encontrado con la otra busqueda de la BD y que tengo guardados en la varible '$res'. 
  * Si no coincide ninguno, significa que hemos encontrado un evento mediante los tags, que no habiamos encontrado mediante el nombre o la descripcion, por lo que tenemos que añadirlo para que salga en el desplegable
 */
  function comprobarTagsYCompletarEventos(&$res, $res_tags, $bd){
    if(!empty($res_tags)){
      if(!empty($res)){
        foreach($res_tags as $tag){
          $esta = false;
          $evento_aux = $bd->getEvento($tag['id_evento']);
          for($i = 0; $i < sizeof($res); $i++){
            if($res[$i]['nombre'] == $evento_aux['nombre']){
              $esta = true;
            }
          }
          if(!$esta){
            array_push($res, ['id' => $evento_aux['id'], 'nombre' => $evento_aux['nombre'], 'path_foto_cabecera' => $evento_aux['path_foto_cabecera'], 'lugar' => $evento_aux['lugar'], 'fecha' => $evento_aux['fecha'], 'publicado' => $evento_aux['publicado']]);
          }
        }
      }
      else{
        for($i = 0; $i < sizeof($res_tags); $i++){
          $evento_aux = $bd->getEvento($res_tags[$i]['id_evento']);
          array_push($res, ['id' => $evento_aux['id'], 'nombre' => $evento_aux['nombre'], 'path_foto_cabecera' => $evento_aux['path_foto_cabecera'], 'lugar' => $evento_aux['lugar'], 'fecha' => $evento_aux['fecha'], 'publicado' => $evento_aux['publicado']]);
        }
      }
    }
  }

  function comprobarTagsYCompletarEventosPublicados(&$res, $res_tags, $bd){
    if(!empty($res_tags)){
      if(!empty($res)){
        foreach($res_tags as $tag){
          $esta = false;
          $evento_aux = $bd->getEvento($tag['id_evento']);
          for($i = 0; $i < sizeof($res); $i++){
            if($res[$i]['nombre'] == $evento_aux['nombre']){
              $esta = true;
            }
          }
          if(!$esta && $evento_aux['publicado'] == 1){
            array_push($res, ['id' => $evento_aux['id'], 'nombre' => $evento_aux['nombre'], 'path_foto_cabecera' => $evento_aux['path_foto_cabecera'], 'lugar' => $evento_aux['lugar'], 'fecha' => $evento_aux['fecha'], 'publicado' => $evento_aux['publicado']]);
          }
        }
      }
      else{
        for($i = 0; $i < sizeof($res_tags); $i++){
          $evento_aux = $bd->getEvento($res_tags[$i]['id_evento']);
          if($evento_aux['publicado'] == 1){
            array_push($res, ['id' => $evento_aux['id'], 'nombre' => $evento_aux['nombre'], 'path_foto_cabecera' => $evento_aux['path_foto_cabecera'], 'lugar' => $evento_aux['lugar'], 'fecha' => $evento_aux['fecha'], 'publicado' => $evento_aux['publicado']]);
          }
        }
      }
    }
  }
?>