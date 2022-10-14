<?php

namespace Clases;

class Usuario
{

    private $host;
    private $db;
    private $user;
    private $password;
    private $database;

    public function __construct(){
        $this->host ='localhost';
        $this->db ='nadin';
        $this->user = 'root';
        $this->password = '';
        $this->database = 'utf8mb4';
    }

    function connect(){
        try{
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->database;
            $options = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            
            $pdo = new \PDO($connection, $this->user, $this->password, $options);

            return $pdo;
        }catch(\PDOException $e){
            print_r('Error connection: ' . $e->getMessage());
        }
    }


    public function login($nombre, $clave)
    {
        $query = $this->connect()->prepare("SELECT nombre_usuario FROM `usuarios` WHERE nombre_usuario = '" . $nombre . "' AND clave = '" . $clave . "'");

        try {
            $query->execute();
            $row = $query->fetch();
            return $row;
        } catch (\PDOException $e) {
            return null;
        }
    }



}
?>