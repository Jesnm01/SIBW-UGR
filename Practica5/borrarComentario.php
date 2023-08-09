<?php
  include("bd.php");


  $bd = new BaseDatos();
  session_start();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_comentario = $_POST['id_comentario'];

    $bd->borrarComentario($id_comentario);
    header("Location: panelComentarios.php");

  }
?>