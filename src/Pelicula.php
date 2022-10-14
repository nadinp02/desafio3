<?php

namespace Clases;

class Pelicula
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
    
        $query = $this->connect()->prepare("INSERT INTO peliculas (`titulo`, `descripcion`, `foto`, `precio`, `categoria_id`, `fecha`) 
        VALUES (:titulo, :descripcion, :foto, :precio, :categoria_id, :fecha)");
        try {
            $query->execute($_params);
            return true;
        } catch (\PDOException $e) {
            return false;
        }

    
    }

    public function actualizar($_params)
    {
        $query = $this->connect()->prepare("UPDATE peliculas SET `titulo`=:titulo,`descripcion`=:descripcion,`foto`=:foto,`precio`=:precio,`categoria_id`=:categoria_id,`fecha`=:fecha WHERE 'id' =:id");

        try {
            
            $query->execute($_params);

            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
    
    // public function actualizar($_params){
    //     $sql = "UPDATE `peliculas` SET `titulo`=:titulo,`descripcion`=:descripcion,`foto`=:foto,`precio`=:precio,`categoria_id`=:categoria_id,`fecha`=:fecha WHERE 'id' =:id";

    //     $resultado = $this->cn->prepare($sql);
    //     $_array = array(
    //         ":titulo" =>$_params['titulos'],
    //         ":descripcion" =>$_params['descripcion'],
    //         ":foto" =>$_params['foto'],
    //         ":precio" =>$_params['precio'],
    //         ":categoria_id" =>$_params['categoria_id'],
    //         ":fecha" =>$_params['fecha'],
    //         ":id" =>$_params['id']
    //     );

    //     if($resultado->execute($_array))
    //         return true;
    //     return false;
    
        
    // }
    public function mostrar()
    {
        $items = [];

        try {
            $query = $this->connect()->query("SELECT peliculas.id, titulo, descripcion, foto,nombre,precio,fecha,estado FROM peliculas
            INNER JOIN categorias
            ON peliculas.categoria_id = categorias.id ORDER BY peliculas.id DESC");

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
        $query = $this->connect()->prepare("SELECT * FROM peliculas  WHERE id ='" . $id . "'");

        try {
            $query->execute();
            $row = $query->fetch();
            return $row;
        } catch (\PDOException $e) {
            return null;
        }
    }


    public function eliminar($id)
    {

        $query = $this->connect()->prepare("DELETE FROM peliculas  WHERE id ='" . $id . "'");
        try {
            $query->execute();
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
}

