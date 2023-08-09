<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    
    
    $bd = new BaseDatos();
    $error = 0;


    session_start();
    if (isset($_SESSION['nickUsuario'])){
        $user = $bd->getUser($_SESSION['nickUsuario']);
        $usuario = array('nick' => $user['nombre'], 'email' => $user['email'], 'fecha_nac' => $user['fecha_nacimiento'], 'mod' => $user['moderador'], 'gestor' => $user['gestor'], 'super' => $user['super']);
    }

    $lista_usuarios = $bd->getUsersList();


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rol_moderador = $_POST['rol_moderador'];
        $rol_gestor = $_POST['rol_gestor'];
        $rol_super = $_POST['rol_super'];
        $nick = $_POST['nick'];

        if(!empty($rol_moderador)){
            $bd->cambiarRolModerador($nick,$rol_moderador);
        }
        else{
            if(!empty($rol_gestor)){
                $bd->cambiarRolGestor($nick,$rol_gestor);
            }
            else{
                if(!$bd->cambiarRolSuper($nick,$rol_super)){ //Si no puedes cambiar el rol de superusuario, es porque solo hay 1 superusuario y siempre debe haber 1 al menos
                    $error = 1;
                };
            }
        }
    }

    // Volvemos a extraer los datos del usuario que tiene la sesion abierta, para comprobar el caso de que se haya quitado él mismo los poderes de superusuario, y que lo eche de la pagina de panel de usuarios
    if (isset($_SESSION['nickUsuario'])){
        $user = $bd->getUser($_SESSION['nickUsuario']);
        $usuario = array('nick' => $user['nombre'], 'email' => $user['email'], 'fecha_nac' => $user['fecha_nacimiento'], 'mod' => $user['moderador'], 'gestor' => $user['gestor'], 'super' => $user['super']);
    }

    if($usuario['super'] == 0){
        header("Location: index.php");
    }

    $lista_usuarios = $bd->getUsersList();
  
  echo $twig->render('panelUsuario.html', ['user' => $usuario, 'lista_usuarios' => $lista_usuarios, 'error' => $error]);
?>
