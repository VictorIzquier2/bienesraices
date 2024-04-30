<?php 
  namespace App;

  class Vendedor extends ActiveRecord {
    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = [])
    {
      $this->id = $args['id'] ?? NULL;
      $this->nombre = $args['nombre'] ?? '';
      $this->apellido = $args['apellido'] ?? '';
      $this->telefono = $args['telefono'] ?? '';
    }

    public function validar() {
      if(!$this->nombre){array_push(self::$errores, "El nombre es obligatorio");};
      if(!$this->apellido){array_push(self::$errores, "El apellido es obligatorio");};
      if(!$this->telefono){array_push(self::$errores, "El teléfono es obligatorio");};
      if(!preg_match('/[0-9]{9}/', $this->telefono)){array_push(self::$errores, "El teléfono debe contener 9 números");};
      return self::$errores;
    }
  }
?>
