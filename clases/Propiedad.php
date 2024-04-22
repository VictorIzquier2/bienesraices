<?php 
  namespace App;

  class Propiedad extends ActiveRecord {

    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args = [])
    {
      $this->id = $args['id'] ?? NULL;
      $this->titulo = $args['titulo'] ?? '';
      $this->precio = $args['precio'] ?? '';
      $this->imagen = $args['imagen'] ?? '';
      $this->descripcion = $args['descripcion'] ?? '';
      $this->habitaciones = $args['habitaciones'] ?? '';
      $this->wc = $args['wc'] ?? '';
      $this->estacionamiento = $args['estacionamiento'] ?? '';
      $this->creado = date('Y/m/d');
      $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function validar() {
      if(!$this->titulo){array_push(self::$errores, "El título es obligatorio");};
      if(!$this->precio){array_push(self::$errores, "El precio es obligatorio");};
      if(!$this->imagen){array_push(self::$errores, "La imagen es obligatoria");};
      if(!$this->descripcion){array_push(self::$errores, "La descripción es obligatoria");};
      if(!$this->habitaciones){array_push(self::$errores, "El nº de habitaciones es obligatorio");};
      if(!$this->wc){array_push(self::$errores, "El nº de baños es obligatorio");};
      if(!$this->estacionamiento){array_push(self::$errores, "El nº de estacionamientos es obligatorio");};
      if(!$this->vendedores_id){array_push(self::$errores, "El id del vendedor es obligatorio");};
      return self::$errores;
    }
  }
?>