<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  
  $bd = new BaseDatos();

// var_dump($bd->checkLogin($nick, $pass));

  session_start();
  if (isset($_SESSION['nickUsuario'])){
    $user = $bd->getUser($_SESSION['nickUsuario']);
    $usuario = array('nick' => $user['nombre'], 'email' => $user['email'], 'fecha_nac' => $user['fecha_nacimiento'], 'mod' => $user['moderador'], 'gestor' => $user['gestor'], 'super' => $user['super']);
  }

  $error = 0;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_nick = $_POST['nick'];
    $pass = $_POST['contraseña'];
    $new_pass = $_POST['new_contraseña'];
    $email = $_POST['email'];
    $fecha_nac = $_POST['fecha_nac'];

    $anterior_nick = $usuario['nick'];


    // Si no introduce el nombre, se le indica mediante un error (el nombre no puede estar vacio)
    if(empty($nuevo_nick)){
        $error = 2;
    }
    else{
        // Si no introduce la contraseña, devuelvo $error=1 para mostrar un mensaje informativo en el html
        // Si introduce contraseña, llamamos a modificarDatosPerfil
        if (!empty($pass)) {
            $resultado = $bd->modificarDatosPerfil($nuevo_nick, $anterior_nick, $pass, $new_pass, $email, $fecha_nac);

            // Si la llamada de modificarDatosPerfil no devuelve error, actualizamos la variable de sesion y redirigimos al perfil para ver los cambios
            if($resultado != "contraseña erronea"){
                $_SESSION['nickUsuario'] = $nuevo_nick;  // guardo en la sesión el nick del usuario despues de que haya cambiado sus datos (esto sirve por si cambia de nombre, sino, simplemente machaca con el mismo valor y ya) 
                header("Location: perfil.php");
            }
        }
        else{
            $error = 1;
        }
    }
  }

  
  echo $twig->render('editarPerfil.html', ['user' => $usuario, 'error' => $error, 'resultado' => $resultado]);
?>