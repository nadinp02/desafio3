<?php
require '../vendor/autoload.php';

$pelicula = new Clases\Pelicula;

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if($_POST['accion'] ==='Registrar'){

        if(empty($_POST['titulo']))
        exit('Completar titulo');

        if(empty($_POST['descripcion']))
        exit('Completar descripcion');

        if(empty($_POST['categoria_id']))
        exit('Seleccionar una Categoria');

        if(!is_numeric($_POST['categoria_id']))
        exit('Seleccionar una Categoria válida');

        $_params = array(
            'titulo'=>$_POST['titulo'],
            'descripcion'=>$_POST['descripcion'],
            'foto'=> subirFoto(),
            'precio'=>$_POST['precio'],
            'categoria_id'=>$_POST['categoria_id'],
            'fecha'=> date('Y-m-d')
        );

        $rpt= $pelicula->registrar($_params);
    }  

    if($rpt) 
        header('Location:peliculas/index.php');
    else 
        print 'Error al registrar pelicula';
    
}

function subirFoto(){
    $carpeta = __DIR__.'/../upload/';

    $archivo = $carpeta.$_FILES['foto']['name'];

    move_uploaded_file($_FILES['foto']['tmp_name'], $archivo);

    return $_FILES['foto']['name'];
}