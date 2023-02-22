<?php
/**
 * Validamos datos de usuario, el el caso de que sean correctos, redirigimos con header() a index.php
 * en el caso de que los datos seanincorrectos, salta una alerta con javascript que indica datos
 *  incorrectos, creamos una variable de sesión $_SESSION con el nombre de usuario
 * 
 * Incluimos session_start() 
 */
session_start();
if($_POST){

    if($_POST["usuario"]=="root" && ($_POST["contrasenia"]=="123456")){
        $_SESSION["usuario"] = "gimpana";
        header("location:index.php");

    }else{
        echo "<script> alert('Usuario o contraseña Incorrectos') </script>";
    }
}

?>

<!doctype html>
<html lang="es">

<head>
  <title>Login</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center g-2">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <br/>
                <div class="card">
                    <div class="card-header">
                        Iniciar Sesión
                    </div>
                    <div class="card-body">
                        <form action="login.php" method="post">

                            Usuario: <input class="form-control" type="text" name="usuario" id="">
                            <br>
                            Contraseña: <input class="form-control" type="password" name="contrasenia" id="">
                            <br>
                            <button class="btn btn-success" type="submit">Entrar al Portafolio</button>

                        </form>
                    </div>
                </div>
                
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</body>

</html>
