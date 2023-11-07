<?php

include "utils/database.php";
include "utils/subida_archivos.php";
include "utils/validacion.php";

$mensajeError = "";
$nombre = $_POST["nombre"];
$precio = $_POST["precio"];
$categoria = $_POST["categoria"];

//* Cargar categorías
$sql = "SELECT Id, Nombre FROM Categorías";
$stmt = $conn->query($sql);
$categorias = $stmt->fetchAll();
// TODO: Catch de posible error aquí

// TODO: Si hay algún error de validación, informará al usuario de cuáles son los errores y le permitirá, mediante un enlace, volver a rellenar el formulario
// TODO: Si no hay ningún error, se mostrará un mensaje de confirmación y mediante un enlace se podrá acceder al menú principal.

// ? Si hay POST validar
if (!empty($_POST)) {
  //* Validación
  validarCampos($nombre, $precio, $categoria);
  validarImagen();

  //? Si hay errores
  if (count($errores) > 0) {
  }

  //* Subida archivos
  $subidaCorrecta = subir_archivos("ficheros/");
}

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear producto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
    span {
      color: var(--text-bright);
    }
    </style>
  </head>

  <body>
    <header>
      <h1>CRUD</h1>
      <a href="crear_producto.php"><span class="fa-solid fa-plus-circle"></span>Crear producto</a>
      <a href="listado_productos.php"><span class="fa-solid fa-repeat"></span>Consultar listado</a>
      <a href="edita_producto.php"><span class="fa-solid fa-pen-to-square"></span>Modificar producto</a>
      <a href=""><span class="fa-solid fa-trash"></span>Eliminar producto</a>
    </header>
    <main>
      <?php if(empty($DATOS)): ?>
      <form action="crear_producto.php" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" required>
        <label for="precio">Precio: </label>
        <input type="number" name="precio" id="precio" min="0" required>
        <label for="imagen">Imagen: </label>
        <input type="file" name="imagen" id="imagen" required>
        <label for="categoria">Categoría: </label>
        <select name="categori" id="categoria">
          <?php
        // Cargar categorias
        foreach ($categorias as $categoria) {
          echo "<option value='" . $categoria['Id'] . "'>" . $categoria['Nombre'] . "</option>";
        }
        ?>
        </select>
        <button type="reset">Reset</button>
        <button type="submit">Enviar</button>
      </form>
      <?php elseif($mostrarConfirmacion === true): ?>
      // TODO: Mensaje confirmación
      <?php elseif($mostrarErrores === true): ?>
      <?php endif; ?>
    </main>
  </body>

</html>
