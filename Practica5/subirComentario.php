<?php
  include("bd.php");
  date_default_timezone_set('Europe/Madrid');

  $bd = new BaseDatos();

  session_start();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $mensaje_a_postear = $_POST['user_message'];

      if(!empty($mensaje_a_postear)){

          if (isset($_SESSION['nickUsuario'])){
              $user = $bd->getUser($_SESSION['nickUsuario']);
              $usuario = array('id' => $user['id'] ,'nick' => $user['nombre'], 'mod' => $user['moderador'], 'gestor' => $user['gestor'], 'super' => $user['super']);

              $bd->subirComentario($_GET['ev'],$usuario['id'],$mensaje_a_postear,date("Y-m-d H:i:s"));
              header("Location: evento.php?ev=" . $_GET['ev']);
          }
      }
  }

?>