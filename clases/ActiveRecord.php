<?php
namespace App;

class ActiveRecord {
  // Acceso estático a la BBDD
  protected static $db;
  protected static $columnasDB = [];
  protected static $tabla = '';

  // Errores 
  protected static $errores = [];
  protected $id;
  protected $imagen;

  // Definir la conexión a la BBDD 
  public static function setDB($database){
    self::$db = $database;
  }

  public function guardar() {
    if(!is_null( $this->id )){
      // actualizar
      $this->actualizar();
    }else{
      // creando un nuevo registro
      $this->crear();
    }
  }

  public function crear() {

    // Sanear los datos
    $atributos = $this->sanearDatos();

    // Insertar a la BBDD
    $query = " INSERT INTO " . static::$tabla . " ( ";
    $query .= join(', ', array_keys($atributos));
    $query .= " ) VALUES ('";
    $query .= join("', '", array_values($atributos));
    $query .= "') ";

    $resultado = self::$db->query($query);

    if($resultado){
      // Redireccionar al usuario 
      header('Location: /admin?resultado=1');
    }

  }

  public function actualizar() {
    // Sanear los datos
    $atributos = $this->sanearDatos();

    $valores = [];
    foreach($atributos as $key => $value){
      $valores[] = "{$key}='{$value}'";
    }

    // Actualizar a la BBDD 
    $query = "UPDATE " . static::$tabla . " SET "; 
    $query .= join(', ', $valores);
    $query .= " WHERE id = '" . self::$db->escape_string($this->id);
    $query .= "' LIMIT 1; ";

    $resultado = self::$db->query($query);

    if($resultado){
      // Redireccionar al usuario 
      header('Location: /admin?resultado=2');
    }
  }

  public function deleteOne() {
    // Eliminar propiedad
    $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1;";
    $resultado = self::$db->query($query);
    if($resultado) {
      $tipo = $_POST['tipo'];
      
      if(validarTipoContenido($tipo)){
        if($tipo === 'propiedad'){
          $this->borrarImagen();
          header('location: /admin?resultado=3'); 
        } else {
          header('location: /admin?resultado=4'); 
        }
      }
    }
  }

  // Lista todos los registros
  public static function all(){
    $query = "SELECT * FROM " . static::$tabla . " ORDER BY id;";
    $resultado = self::consultarSQL($query);
    return $resultado;
  }

  // Busca un registro por su id
  public static function findOne($id){
    $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";
    $resultado = self::consultarSQL($query);
    return array_shift($resultado);
  }

  public static function consultarSQL($query){
    // Consultar la base de datos 
    $resultado = self::$db->query($query);

    // Iterar los resultados 
    $arreglo = [];
    while($registro = $resultado->fetch_assoc()){
      array_push($arreglo, static::crearObjeto($registro));
    }

    // Liberar la memoria
    $resultado->free();
    
    // retornar los resultados 
    return $arreglo;

  }
  protected static function crearObjeto($registro) {
    $objeto = new static;
    foreach($registro as $key=>$value){
      if(property_exists($objeto, $key)){
        $objeto->$key = $value;
      }
    }
    return $objeto;
  }

  // Sincroniza el objeto en memoria con los cambios realizados por el usuario
  public function sincronizar($args = []){
    foreach($args as $key => $value){
      if(property_exists($this, $key) && !is_null($value)){
        $this->$key = $value;
      }
    }
  }

  public function atributos() : array {
    $atributos = [];
    foreach(static::$columnasDB as $columna){
      if($columna === 'id') continue;
      $atributos[$columna] = $this->$columna;
    }
    return $atributos;
  }
  
  public function sanearDatos() : array {
    $atributos = $this->atributos();
    $saneados = [];

    foreach($atributos as $key => $value){
      $saneados[$key] = self::$db->escape_string($value);
    }
    return $saneados;
  }

  // Subida de archivos
  public function setImagen($imagen) {
    // Eliminar la imagen previa 
    if(!is_null( $this->id )) {
      $this->borrarImagen();
    }
    // Asignar el atributo de imagen el nombre de la imagen
    if($imagen) {
      $this->imagen = $imagen;
    }
  }
  
  // Eliminar archivo 
  public function borrarImagen() {
    // Comprobar si exite el archivo 
    $existe_archivo = file_exists(CARPETA_IMAGENES . $this->imagen);
    if($existe_archivo){
      unlink(CARPETA_IMAGENES . $this->imagen);
    }
  }

  // Validacion
  public static function getErrores(){
    return static::$errores;
  }

  public function validar() {
    static::$errores = [];
    return static::$errores;
  }
}

