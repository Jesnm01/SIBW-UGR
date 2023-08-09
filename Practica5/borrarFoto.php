<?php
  include("bd.php");


  $bd = new BaseDatos();
  session_start();

  if (isset($_GET['id'])) {
    $id_foto = $_GET['id'];
  } else {
    $id_foto = -1;
  }

    $bd->borrarFoto($id_foto);
    header("Location: panelEventos.php");

?>