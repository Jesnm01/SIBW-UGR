<?php

  class BaseDatos{
    public $servidor = "mysql";
    private $nombreUsuario = "jesus";
    private $contraseña = "practicas_sibw";
    private $nombreBD = "SIBW";

    public $conexion;
    //Para manejar manualmente si la conexion con la bd está abierta o cerrada (no se como hacerlo de otra manera)
    private bool $conectado = false;


    //Si no tenemos conexion, la hacemos
    public function conectarBD(){
      if(!$this->conectado){
        $this->conexion = new mysqli($this->servidor, $this->nombreUsuario, $this->contraseña, $this->nombreBD);
        $this->conectado = true;

          if ($this->conexion->connect_errno) {
            echo ("Fallo al conectar: " . $this->conexion->connect_error);
          }
      }
    }

    //Cerramos conexion con la bd
    public function cerrarConexionBD(){
      $this->conexion->close();
      $this->conectado = false;
    }

    public function checkLogin($nick, $pass){

      $this->conectarBD();
      
      $resultado = $this->conexion->query("SELECT * FROM usuarios");
      $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);

// var_dump(sizeof($usuarios));
// var_dump($usuarios[0]['nombre']);
// var_dump($nick);   
// var_dump($usuarios[0]['pass']);
// var_dump(password_verify($pass, $usuarios[0]['pass']));

      for ($i = 0 ; $i < sizeof($usuarios) ; $i++) {
        if ($usuarios[$i]['nombre'] === $nick) {
        
          if (password_verify($pass, $usuarios[$i]['pass'] )) {
            return true;
          }
        }
      }
      
      return false;
    }

    public function getUser($nick){

      $this->conectarBD();
      
      $resultado = $this->conexion->query("SELECT * FROM usuarios");
      $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);

      for ($i = 0 ; $i < sizeof($usuarios) ; $i++) {
        if ($usuarios[$i]['nombre'] === $nick) {
          return $usuarios[$i];
        }
      }
      
      return 0;
    }

    public function getNameUser($id_usuario){

      $this->conectarBD();
      
      $resultado = $this->conexion->query("SELECT nombre FROM usuarios where id = '$id_usuario'"); //Solo debe devolver 1 fila de la tabla
      $usuario = $resultado->fetch_assoc();
      
      return $usuario['nombre'];
    }








    public function getUsersList(){

      $this->conectarBD();
      
      $resultado = $this->conexion->query("SELECT nombre, email, super, gestor, moderador FROM usuarios ORDER BY super DESC, gestor DESC, moderador DESC");
      $lista_usuarios = $resultado->fetch_all(MYSQLI_ASSOC);

      return $lista_usuarios;
    }

    public function getEventsList(){

      $this->conectarBD();
      
      $resultado = $this->conexion->query("SELECT * FROM eventos ORDER BY id");
      $lista_comentarios = $resultado->fetch_all(MYSQLI_ASSOC);
      
      return $lista_comentarios;
    }
    
    public function getCommentList(){

      $this->conectarBD();
      
      $resultado = $this->conexion->query("SELECT * FROM comentarios ORDER BY id_evento");
      $lista_comentarios = $resultado->fetch_all(MYSQLI_ASSOC);
      
      return $lista_comentarios;
    }

    public function getComment($id_comentario){

      $this->conectarBD();

      // Aqui hago los prepared statements porque uso id_comentario, que lo cojo directamente del $_GET
      $stmt = $this->conexion->prepare("SELECT * FROM comentarios WHERE id_comentario = ?");
      $stmt->bind_param("i", $id_comentario);
      $stmt->execute();
      
      $comentario = $stmt->get_result()->fetch_assoc();
      
      return $comentario;
    }

    public function getTagList($id_evento){

      $this->conectarBD();

      $stmt = $this->conexion->prepare("SELECT * FROM tags WHERE id_evento = ? ORDER BY id");

      $stmt->bind_param("i", $id_evento);
      $stmt->execute();
  
      $lista_tags = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      
      return $lista_tags;

    }

    public function aniadirTags($id_evento, $descripcion){

      $this->conectarBD();
      
      $resultado = $this->conexion->query("INSERT INTO tags (id_evento, descripcion) VALUES ('$id_evento','$descripcion')"); 

      return $resultado;
      
    }

    public function borrarTags($id_evento){

      $this->conectarBD();
      
      $resultado = $this->conexion->query("DELETE FROM tags WHERE id_evento = '$id_evento'"); 

      return $resultado;
      
    }







    public function borrarComentario($id_comentario){

      $this->conectarBD();
      
      $resultado = $this->conexion->query("DELETE FROM comentarios WHERE id_comentario = '$id_comentario'"); 

      return $resultado;
      
    }

    public function borrarEvento($id_evento){

      $this->conectarBD();
      
      $resultado = $this->conexion->query("DELETE FROM eventos WHERE id = '$id_evento'"); 

      return $resultado;
      
    }

    public function borrarFoto($id_foto){

      $this->conectarBD();
      
      $resultado = $this->conexion->query("DELETE FROM fotos WHERE id = '$id_foto'"); 

      return $resultado;
      
    }

    public function editarComentario($id_comentario, $nueva_descripcion){

      $this->conectarBD();
      
      $resultado = $this->conexion->query("UPDATE comentarios SET descripcion = '$nueva_descripcion' WHERE id_comentario = '$id_comentario'"); 

      return $resultado;
      
    }

    public function nuevoEventoInfoBasica($nombre, $lugar, $fecha, $organizadores, $descripcion, $twitter, $facebook){

      $this->conectarBD();
      
      $resultado = $this->conexion->query("INSERT INTO eventos(nombre, lugar, fecha, organizadores, descripcion, twitter, facebook) VALUES 
      ('$nombre','$lugar','$fecha','$organizadores','$descripcion','$twitter', '$facebook')"); 

      return $resultado;
      
    }

    public function editarInfoBasicaEvento($id_evento, $nombre, $lugar, $fecha, $organizadores, $descripcion, $twitter, $facebook){

      $this->conectarBD();
      
      $resultado = $this->conexion->query("UPDATE eventos SET nombre = '$nombre',
                                                              lugar = '$lugar',
                                                              fecha = '$fecha',
                                                              organizadores = '$organizadores',
                                                              descripcion = '$descripcion',
                                                              twitter = '$twitter',
                                                              facebook = '$facebook'
                                                              WHERE id = '$id_evento'"); 

      return $resultado;
      
    }


    public function editarFotoCabeceraEvento($id_evento, $path_foto_cabecera){
      
      $this->conectarBD();
      
      $resultado = $this->conexion->query("UPDATE eventos SET path_foto_cabecera = '$path_foto_cabecera' WHERE id = '$id_evento'"); 

      return $resultado;
            
    }

    public function aniadirFotoSlideShowEvento($id_evento, $path_foto_slideshow){
      
      $this->conectarBD();
      
      $resultado = $this->conexion->query("INSERT INTO fotos(id_evento, path_imagen) VALUES ($id_evento,'$path_foto_slideshow')"); 

      return $resultado;
            
    }

    public function editarCaptionSlideShowEvento($id_evento, $id_foto, $caption){

      $this->conectarBD();
      
      $resultado = $this->conexion->query("UPDATE fotos SET caption = '$caption' WHERE id_evento = '$id_evento' and id = '$id_foto'"); 

      return $resultado;

            
    }





    public function cambiarRolModerador($nick,$rol_moderador){

      $this->conectarBD();

      
// var_dump($nick, $rol_moderador, $rol_gestor, $rol_super);      
      $resultado = $this->conexion->query("UPDATE usuarios SET moderador = '$rol_moderador' WHERE nombre = '$nick'");
      // $lista_usuarios = $resultado->fetch_all(MYSQLI_ASSOC);
// var_dump($resultado);
      return 0;
    }

    public function cambiarRolGestor($nick,$rol_gestor){

      $this->conectarBD();

      
      $resultado = $this->conexion->query("UPDATE usuarios SET gestor = '$rol_gestor' WHERE nombre = '$nick'");
      // $lista_usuarios = $resultado->fetch_all(MYSQLI_ASSOC);
      return 0;
    }

    public function cambiarRolSuper($nick,$rol_super){

      $this->conectarBD();

      $resultado1 = $this->conexion->query("SELECT count(super) cuenta FROM usuarios WHERE super = 1");
      $resultado2 = $this->conexion->query("SELECT super, gestor, moderador FROM usuarios WHERE nombre = '$nick'");

      $cantidad_supers = $resultado1->fetch_assoc();
      $roles_usuario_a_cambiar = $resultado2->fetch_assoc();

      if($cantidad_supers['cuenta'] == 1 and $rol_super == 0 and $roles_usuario_a_cambiar['super'] == 1){
        return false;
      }
      else{
        $this->conexion->query("UPDATE usuarios SET super = '$rol_super' WHERE nombre = '$nick'");
        return true;
      }
    }










    public function registrarUsuario($nick, $pass, $email, $fecha_nac){

      $this->conectarBD();

      if(empty($nick) || empty($email) || empty($pass) || empty($fecha_nac)){
        return false;
      }
          
      $hash = password_hash($pass, PASSWORD_DEFAULT);

      if($this->conexion->query("INSERT INTO usuarios (nombre, pass, email, fecha_nacimiento, moderador, gestor, super) VALUES ('$nick', '$hash', '$email', '$fecha_nac', 0, 0, 0)"))
        return true;
      else
        return false;
    }


    public function modificarDatosPerfil($nuevo_nick, $nick, $pass, $new_pass, $email, $fecha_nac){

      $this->conectarBD();


      $resultado = $this->conexion->query("SELECT pass FROM usuarios where nombre = '$nick'");
      $array_pass = $resultado->fetch_assoc(); //Este array_pass solo deberia tener 1 elemento dentro, que es la contraseña del usuario en cuestion

      $pass_bd = $array_pass['pass'];
      $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);

      //Si new_pass tiene algo, es porque se quiere cambiar la contraseña
      if(!empty($new_pass)){
        if(password_verify($pass, $pass_bd)){
          $this->conexion->query("UPDATE usuarios SET nombre = '$nuevo_nick', pass = '$new_hash', email = '$email', fecha_nacimiento = '$fecha_nac' WHERE nombre = '$nick'");
        }
        else{
          return "contraseña erronea";
        }
      }
      else{
        if (password_verify($pass, $pass_bd)) {
          $this->conexion->query("UPDATE usuarios SET nombre = '$nuevo_nick', email = '$email', fecha_nacimiento = '$fecha_nac' WHERE nombre = '$nick'");
        }
        else{
          return "contraseña erronea";
        }
      }
    }

    public function subirComentario($id_evento, $id_usuario, $mensaje_a_postear, $fecha){

      $this->conectarBD();

      // Aqui hago los prepared statements porque uso id_evento, que lo cojo directamente del $_GET
      $stmt = $this->conexion->prepare("INSERT INTO comentarios (id_evento, id_usuario, descripcion, fecha) VALUES (?, $id_usuario, '$mensaje_a_postear', '$fecha')");
      $stmt->bind_param("i", $id_evento);
      $stmt->execute();
    }


    // Funcion para extraer la informacion relevante del evento
    public function getEvento($idEv) {
    
      $this->conectarBD();
  
      $stmt = $this->conexion->prepare("SELECT * FROM eventos WHERE id = ?");

      //Aqui indicamos que el ? solo puede ser un entero, y le asociamos el valor de $idEv
      $stmt->bind_param("i", $idEv);
      $stmt->execute();

  
      $res = $stmt->get_result()->fetch_assoc();

      // $this->cerrarConexionBD();
      
      return $res;
  
      
    }

    // funcion para extraer las fotos del evento
    public function getFotosEvento($idEv){
  
      $this->conectarBD();
  
      $stmt = $this->conexion->prepare("SELECT * FROM fotos WHERE id_evento = ?");
  
      //Aqui indicamos que el ? solo puede ser un entero, y le asociamos el valor de $idEv
      $stmt->bind_param("i", $idEv);
      $stmt->execute();
  
      $res = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
      // $stmt->close();

      // $this->cerrarConexionBD();
      
      return $res;
  
    }

    public function getComentarios($idEv){
      
      $this->conectarBD();
  
      $stmt = $this->conexion->prepare("SELECT * FROM comentarios WHERE id_evento = ?");
  
      //Aqui indicamos que el ? solo puede ser un entero, y le asociamos el valor de $idEv
      $stmt->bind_param("i", $idEv);
      $stmt->execute();

      $arr = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

      // $stmt->close();

      // $this->cerrarConexionBD();
      
      return $arr;
    }

    public function getPalabrasBan(){
      
      $this->conectarBD();

      // $arr = [];
  
      $res = $this->conexion->query("SELECT palabra FROM palabras_ban");

      // Sacamos los elementos de la base de datos
      // $arr = $res->fetch_row();
      for($i = 0; $i < $res->num_rows; $i++){
        // array_push($arr,$res->fetch_row());
        $arr[$i] = $res->fetch_row();
      }

      // Como en el $arr tengo los datos extraidos en un formato que no me gusta, lo paso a otro array mas conveniente
      $arr2 = [];
      for($i = 0; $i < $res->num_rows; $i++){
        // array_push($arr,$res->fetch_row());
        $arr2[$i] = $arr[$i][0];
      }

      // var_export($arr2);
      

      // $stmt->close();

      // $this->cerrarConexionBD();
      
      return $arr2;
    }
  }
?>
