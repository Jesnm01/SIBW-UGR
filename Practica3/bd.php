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


    // Funcion para extraer la informacion relevante del evento
    public function getEvento($idEv) {
    
      $this->conectarBD();
  
      $stmt = $this->conexion->prepare("SELECT nombre, lugar_y_fecha, organizadores, descripcion FROM eventos WHERE id = ?");

      //Aqui indicamos que el ? solo puede ser un entero, y le asociamos el valor de $idEv
      $stmt->bind_param("i", $idEv);
      $stmt->execute();

  
      $res = $stmt->get_result()->fetch_assoc();
      
      // while($row = $res->fetch_assoc()){
      //   $array[] = $row;
      // }
    
      // var_export($res);
      // $stmt->close();
  
      // return $array;
  
  
  
      // if ($stmt->affected_rows > 0) {
      //   $row = $res->fetch_assoc();
        
      //   $evento = array('nombre' => $row['nombre'], 
      //                   'lugar_y_fecha' => $row['lugar_y_fecha'], 
      //                   'organizadores' => $row['organizadores'], 
      //                   'descripcion' => $row['descripcion']
      //                   );
      // }

      // $this->cerrarConexionBD();
      
      return $res;
  
      
    }

    // funcion para extraer las fotos del evento
    public function getFotosEvento($idEv){
  
      $this->conectarBD();
  
      $stmt = $this->conexion->prepare("SELECT path_imagen_cabecera, path_imagen1_galeria, path_imagen2_galeria, caption_imagen1, caption_imagen2 FROM fotos_eventos WHERE id_evento = ?");
  
      //Aqui indicamos que el ? solo puede ser un entero, y le asociamos el valor de $idEv
      $stmt->bind_param("i", $idEv);
      $stmt->execute();
  
      $res = $stmt->get_result()->fetch_assoc();
    
      // $stmt->close();

      // $this->cerrarConexionBD();
      
      return $res;
  
    }

    public function getComentarios($idEv){
      
      $this->conectarBD();
  
      $stmt = $this->conexion->prepare("SELECT nombre_usuario, descripcion, fecha FROM comentarios WHERE id_evento = ?");
  
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







  // function conectarBD(){
  //   $mysqli = new mysqli("mysql", "jesus", "practicas_sibw", "SIBW");
  //   if ($mysqli->connect_errno) {
  //     echo ("Fallo al conectar: " . $mysqli->connect_error);
  //   }
  //   return $mysqli;
  // }

  // function cerrarConexionBD($mysqli){
  //   $mysqli->close();
  // }


  // Funcion para extraer la informacion relevante del evento
  // function getEvento($idEv) {
  
  //   $mysqli = conectarBD();

  //   $stmt = $mysqli->prepare("SELECT nombre, lugar_y_fecha, organizadores, descripcion FROM eventos WHERE id = ?");

  //   //Aqui indicamos que el ? solo puede ser un entero, y le asociamos el valor de $idEv
  //   $stmt->bind_param("i", $idEv);
  //   $stmt->execute();


  //   $res = $stmt->get_result()->fetch_assoc();
    
  //   // while($row = $res->fetch_assoc()){
  //   //   $array[] = $row;
  //   // }
  
  //   // var_export($res);
  //   $stmt->close();

  //   // return $array;



  //   // if ($stmt->affected_rows > 0) {
  //   //   $row = $res->fetch_assoc();
      
  //   //   $evento = array('nombre' => $row['nombre'], 
  //   //                   'lugar_y_fecha' => $row['lugar_y_fecha'], 
  //   //                   'organizadores' => $row['organizadores'], 
  //   //                   'descripcion' => $row['descripcion']
  //   //                   );
  //   // }
    
  //   return $res;

  //   // cerrarConexionBD($mysqli);
  // }

  // // funcion para extraer las fotos del evento
  // function getFotosEvento($idEv){

  //   $mysqli = conectarBD();

  //   $stmt = $mysqli->prepare("SELECT path_imagen_cabecera, path_imagen1_galeria, path_imagen2_galeria, caption_imagen1, caption_imagen2 FROM fotos_eventos WHERE id_evento = ?");

  //   //Aqui indicamos que el ? solo puede ser un entero, y le asociamos el valor de $idEv
  //   $stmt->bind_param("i", $idEv);
  //   $stmt->execute();

  //   $res = $stmt->get_result()->fetch_assoc();
  
  //   $stmt->close();
    
  //   return $res;

  // }
?>
