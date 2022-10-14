<?php

namespace Clases;

class Pedido
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
    
        $query = "INSERT INTO pedidos( `cliente_id`, `total`, `fecha`) VALUES (:cliente_id,:total, :fecha)";

        $resultado = $cn->prepare($query);

        if($resultado->execute($_params))
        return $cn->lastInsertId();
    
    }

    public function registrarDetalle($_params){
    
        $query = $this->connect()->prepare("INSERT INTO detalle_pedidos( `pedido_id`, `pelicula_id`, `precio`, `cantidad`) VALUES (:pedido_id, :pelicula_id, :precio,:cantidad)");
        try {
            $query->execute($_params);
            return true;
        } catch (\PDOException $e) {

            return false;
        }

    
    }

    public function mostrar()
    {
        $items = [];

        try {
            $query = $this->connect()->query("SELECT p.id, nombre, apellido, email, total, fecha FROM pedidos p 
            INNER JOIN clientes c ON p.cliente_id = c.id ORDER BY p.id DESC");

            while ($row = $query->fetch()) {
                array_push($items, $row);
            }

            return $items;
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function mostrarUltimos()
    {
        $items = [];

        try {
            $query = $this->connect()->query("SELECT p.id, nombre, apellido, email, total, fecha FROM pedidos p 
            INNER JOIN clientes c ON p.cliente_id = c.id ORDER BY p.id DESC LIMIT 10");

            while ($row = $query->fetch()) {
                array_push($items, $row);
            }

            return $items;
        } catch (\PDOException $e) {
            return [];
        }
    }


    public function mostrarPorId($id)
    {

         $query = $this->connect()->query("SELECT p.id, nombre, apellido, email, total, fecha FROM pedidos p 
        INNER JOIN clientes c ON p.cliente_id = c.id WHERE p.id = '" . $id . "'");

        try {
            $query->execute();
            $row = $query->fetch();
            return $row;
        } catch (\PDOException $e) {
            return null;
        }
    }


    public function mostrarDetallePorIdPedido($id)
    {
        $items = [];

        try {
            $query = $this->connect()->query("SELECT dp.id, pe.titulo, dp.precio, dp.cantidad, pe.foto FROM detalle_pedidos dp 
            INNER JOIN peliculas pe ON pe.id = dp.pelicula_id WHERE dp.pedido_id = '" . $id . "'");

            while ($row = $query->fetch()) {
                array_push($items, $row);
            }

            return $items;
        } catch (\PDOException $e) {
            return [];
        }
    }

    



}