<?php

class Conexion extends PDO {
   public function __construct() {
      parent::__construct('mysql:host=localhost;dbname=mitecho', 'root', '');
      $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
}