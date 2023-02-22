<?php include("cabecera.php") ?>
<?php include("conexion.php") ?>

<?php

/**
 * Leemos la sesión, comprobamos que la sesión sean con un usuario correcto 
 * en caso de que sea un usuario con datos que no sean correctos o no tengamos la sesión iniciada
 * redireccionamos a la pantalla de login en el caso de que quieran acceder a la gestión del portafolio
 * 
 * 
 */

session_start();

if( isset($_SESSION["usuario"]) != "root" ){
    header("location:login.php");
}

?>

<?php 

/**
 * usamos un if para comprobar si se ha enviado algo por $_POST , 
 * en caso de ser cierto, asignamos $nombre,  $descripcion, $imagen y creamos la variable  $objConexion = new conexion
 * creamos sentencia sql donde reemplazamos el nombre en laconsulta,con sus correspondientes variables que vienen por POST
 * y usamos la función ejecutar
 * 
 */

if($_POST){

    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];

    //Instanciamos objeto para obtener la hora en milisegundos actual
    $fecha = new DateTime();

    //Asignamos al nombre de la imagen la hora que sea ha subido en milisegundos más el nombrede la imagen
    $imagen =$fecha->getTimestamp(). "_". $_FILES["archivo"]["name"];
    
    //Asignamos el nombre temporal de la imagen
    $imagen_temporal = $_FILES["archivo"]["tmp_name"];

    /**
     * Movemos la imagen, primer parametro el nombre temporal de la imagen y el segundo
     *  la ruta de la imagen junto el el nombre de la imagen
     */ 
    move_uploaded_file($imagen_temporal, "Imagenes/".$imagen);

    $objConexion = new conexion();

    //En la sentencia asignamos el nombre del proyecto la variable $nombre antes creada
    $sql = "INSERT INTO `proyectos` (`id`, `nombre`, `imagen`, `descripcion`) VALUES (NULL, '$nombre', '$imagen', '$descripcion')";

    $objConexion->ejecutar($sql);

    /**
     * Luego de realizar las operaciones con post, redirigimos al usuario a la misma página portafolio
     * Esto lo hacemos para que al refrescar la página no se ejecute devuelta la consulta
     * */
    header("location:portafolio.php");
    }

/**
 * Comprobamos que por $_GET tenemos el id que queremos borrar 
 * Vamos a recoger este dato para ejecutar la consulta de borrado con el id que se pasa por GET
 */

if($_GET){

    //Recogemos el ID
    $id = $_GET["borrar"];

    //Instanciamos objeto
    $objConexion = new conexion();

    //Obtenemos la infomación de la imagen con una consulta a la base de datos
    $imagen = $objConexion->consultar("SELECT imagen FROM `proyectos` WHERE id=".$id);

    //Eliminamos la imagén con la función unlink que elimina un archivo, de parametros pasamos la dirección del archivo
    unlink("Imagenes/".$imagen[0]["imagen"]);

    //Creamos consulta SQL
    $sql = "DELETE FROM `proyectos` WHERE `proyectos`.`id` =". $id;

    //Ejecutamos consulta
    $objConexion->ejecutar($sql);

     /**
     * Luego de realizar las operaciones con post, redirigimos al usuario a la misma página portafolio
     * Esto lo hacemos para que al refrescar la página no se ejecute devuelta la consulta
     * */
    header("location:portafolio.php");

}

$objConexion = new conexion();

//recibir los datos de un select de toda la tabla proyectos, vamos a mostrar todos los datos en la tabla del html
$proyectos = $objConexion->consultar("SELECT * FROM `proyectos`");


?>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <br>
                <div class="card">
                    <div class="card-header">
                        Datos del Proyecto
                    </div>
                        <div class="card-body">
                            <!--
                                Agregamos enctype="multipart/form-data" para recepcionar los archivos tipo file del input
                            -->
                            <form action="portafolio.php" method="post" enctype="multipart/form-data">

                                Nombre del proyecto: <input required class="form-control" type="text" name="nombre" id="">
                                <br/>
                                Imagenes del Proyecto: <input required class="form-control" type="file" name="archivo" id="">
                                <br/>
                                Descripción
                                <textarea required name="descripcion" id="" class="form-control" rows="3"></textarea>
                                <br/>
                                <input class="btn btn-success" type="submit" value="Enviar Proyecto">

                            </form>
                        </div>
                    </div>
                </div>
            <div class="col-md-6">
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Imagen</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Incrustamos código PHP que se extiende hasta el final de la tabla
                                mostramos en cada columna el id, nombre, imagen y descripcion 
                                que tiene almacenado $proyectos
                            -->
                            <?php foreach($proyectos as $proyecto){ ?>
                            <tr class="">
                                <td scope="row"><?php echo $proyecto["id"]; ?></td>
                                <td><?php echo $proyecto["nombre"]; ?></td>
                                <td>
                                    <img width="120" src="Imagenes/<?php echo $proyecto["imagen"]; ?>" alt="">
                                    
                                </td>
                                <td><?php echo $proyecto["descripcion"]; ?></td>
                                <!-- Nospasa por $_GET el id que queremos borrar  -->
                                <td><a name="" id="" class="btn btn-danger" href="?borrar=<?php echo $proyecto["id"]; ?>" role="button">Eliminar</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>


</body>
</html>
