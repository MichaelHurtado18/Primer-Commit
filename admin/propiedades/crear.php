<?php

require '../../includes/config/database.php';

$mysqli = conectarBD();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilos/estilos.css">
    <title>Bienes Raices</title>
</head>

<body>
    <header class="header ">
        <div class="contenedor__header">
            <div class="barra">
                <a href="/">
                    <img class="barra__logo" src="../../../Bienes__Raices/bienesraices_inicio/src/img/logo.svg" alt="Logo De la pagina" />
                </a>
                <div class="menu__barras__mobile">
                    <img src="Bienes__Raices/bienesraices_inicio/src/img/barras.svg">
                </div>
                <div class="derecha">
                    <div class="boton__dark__mode">
                        <img src="../../../Bienes__Raices/bienesraices_inicio/src/img/dark-mode.svg">
                    </div>
                    <nav class="navegacion">
                        <a href="nosotros.php">Nosotros</a>
                        <a href="anuncios.php">Anuncios</a>
                        <a href="blog.php">Blog</a>
                        <a href="contacto.php">Contacto</a>
                    </nav>
                </div>
            </div>

        </div>
    </header>


    <?php
    /*consulta para traer el nombre de los vendedores */
    $sqlVendedor = $mysqli->query("SELECT * FROM vendedor");


    /*array con mensajes de errores */
    $errores = [];


    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedor = '';


    if ($_SERVER["REQUEST_METHOD"] === "POST") {


        $titulo = $_POST["titulo"];
        $precio = $_POST["precio"];
        $descripcion = $_POST["descripcion"];
        $habitaciones = $_POST["habitaciones"];
        $wc = $_POST["wc"];
        $estacionamiento = $_POST["estacionamiento"];
        $vendedor = $_POST["vendedor"];
        $imagen = $_FILES["imagen"];





        /* Validacion del formulario */
        if (!$titulo) {
            $errores[] = "El titulo no puede estar vacio";
        }

        if (!$precio) {
            $errores[] = "La casa debe tener un precio";
        }
        if (!$descripcion) {
            $errores[] = "La descripcion tiene menos de 20 caracteres";
        }

        if (!$habitaciones  || filter_var($habitaciones, FILTER_VALIDATE_INT) == false) {
            $errores[] = "Ingrese un numero de habitaciones";
        }
        if (!$wc || filter_var($wc, FILTER_VALIDATE_INT) == false) {
            $errores[] = "Ingrese un numero de  baños";
        }
        if (!$estacionamiento || filter_var($estacionamiento, FILTER_VALIDATE_INT) == false) {
            $errores[] = "Ingrese numero de estacionamiento, si no tiene pomga '0'";
        }
        if (!$vendedor) {
            $errores[] = "La casa no tiene vendedor";
        }

        if (!$imagen["name"]) {
            $errores[] = "Dese seleccionar una imagem";
        }

        if (count($errores) == 0) {
            $directorio = "../../directorio/";

            if (!is_dir($directorio)) {
                mkdir($directorio, 0777);
            }
            $tmp = $imagen["tmp_name"];
            $nombreImagen = $imagen["name"];
            move_uploaded_file($tmp, $directorio . $nombreImagen);


            /*Insertamos en la BD  */
            $sqlInsert = $mysqli->query("INSERT INTO propiedades (titulo,precio,imagen,descripcion,habitaciones,wc,estacionamiento,vendedorId)  
        VALUES ('$titulo','$precio','$nombreImagen','$descripcion','$habitaciones','$wc','$estacionamiento','$vendedor')");
            if ($sqlInsert == false) {
                die("ERROR MYSQL " . $mysqli->error);
            }
            header("Location:../index.php?mensaje=1");
        }
    }

    ?>



   
    <a href="../index.php" class="boton__naranja__inline">VOLVER</a>
    <main class="contenedor">
    <?php foreach ($errores as $valor) : ?>
        <div class=" alerta alerta_error">
            <?php echo $valor; ?>
        </div>
    <?php endforeach; ?>

        <form class="formulario" method="POST" action="crear.php" class="formulario" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion General</legend>


                <label for="titulo">Titulo</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo $titulo ?>">

                <label for="precio">Precio Propiedad</label>
                <input type="number" id="precio" name="precio" value="<?php echo $precio ?>">

                <label for="imagen">imagen</label>
                <input type="file" id="imagen" name="imagen" accept="img/jpeg">

                <label for="descripcion ">Descripcion</label>
                <textarea id="descripcion" name="descripcion" cols="30" rows="10"><?php echo $descripcion ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Información Propiedad</legend>

                <label for="habitaciones">Habitaciones</label>
                <input type="number" id="habitaciones" name="habitaciones" value="<?php echo $habitaciones ?>">

                <label for="wc">Baño</label>
                <input type="number" id="wc" name="wc" value="<?php echo $wc ?>">

                <label for="estacionamiento">EStacionamiento</label>
                <input type="number" id="estacionamiento" name="estacionamiento" value="<?php echo $estacionamiento ?>">

            </fieldset>
            <fieldset>
                <legend>Vendedores</legend>
                <select name="vendedor">
                    <option value="">--Seleccionar--</option>
                    <?php while ($rowVendedor = $sqlVendedor->fetch_assoc()) : ?>}
                    <option value="<?php echo $rowVendedor["idvendedor"] ?>" <?php echo $vendedor == $rowVendedor["idvendedor"] ? 'selected ' : ''; ?>><?php echo $rowVendedor["nombre"] . " " . $rowVendedor["apellido"] ?></option>
                <?php endwhile; ?>
                </select>
            </fieldset>
            <input class="boton__naranja" type="submit" value="Enviar">
        </form>
    </main>

</body>