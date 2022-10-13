<?php

namespace Clases;

class Cliente
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
    public function registrar($_params){

        $cn = $this->connect();
    
        $query = "INSERT INTO clientes (`nombre`, `apellido`, `email`, `telefono`, `comentario`) VALUES (:nombre, :apellido, :email, :telefono, :comentario)";

        $resultado = $cn->prepare($query);

        if($resultado->execute($_params))
        return $cn->lastInsertId();

        // try {
        //     $query->execute($_params);
            
        //     return $this->connect()->lastInsertId();
        // } catch (\PDOException $e) {
        //     var_dump($e);

        //     return false;
        // }

    
    }



}

