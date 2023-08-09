<?php
  include("bd.php");


  $bd = new BaseDatos();
  session_start();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Si la variable name 'checbox' existe es porque el checkbox está con el tick puesto. Si no lo tiene puesto, el isset este da false
    if(isset($_POST['checkbox'])){
        //Actualizamos el campo publicado del evento a 1
        $bd->actualizarPublicacionEvento($_POST['id_evento'], 1);
    }
    else{
        $bd->actualizarPublicacionEvento($_POST['id_evento'], 0);
    }


    header("Location: panelEventos.php");

  }
?>