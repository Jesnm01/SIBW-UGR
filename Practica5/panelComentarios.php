<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    
    
    $bd = new BaseDatos();


    session_start();
    if (isset($_SESSION['nickUsuario'])){
        $user = $bd->getUser($_SESSION['nickUsuario']);
        $usuario = array('nick' => $user['nombre'], 'email' => $user['email'], 'fecha_nac' => $user['fecha_nacimiento'], 'mod' => $user['moderador'], 'gestor' => $user['gestor'], 'super' => $user['super']);
    }


    $lista_comentarios = $bd->getCommentList();

    // Añado en el array asociativo de cada comentario, el nombre de quien lo posteó
    for ($i = 0 ; $i < sizeof($lista_comentarios) ; $i++) {
        $lista_comentarios[$i]['nombre_usuario'] = $bd->getNameUser($lista_comentarios[$i]['id_usuario']);
    }
  
  echo $twig->render('panelComentarios.html', ['user' => $usuario, 'lista_comentarios' => $lista_comentarios]);
?>