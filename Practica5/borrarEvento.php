<?php
  include("bd.php");


  $bd = new BaseDatos();
  session_start();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_evento = $_POST['id_evento'];

    $bd->borrarEvento($id_evento);
    header("Location: panelEventos.php");

  }
?>