<?php

include "utils/database.php";
include "utils/subida_archivos.php";
include "utils/validacion.php";

//* Cargar categorías
try {
  $sql = "SELECT Id, Nombre FROM Categorías";
  $stmt = $conn->query($sql);
  $categorias = $stmt->fetchAll();
} catch (PDOException $e) {
  echo "Error al obtener las categorías: " . $e->getMessage();
}

// ? Si hay POST validar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {
  $nombre = $_POST["nombre"];
  $precio = $_POST["precio"];
  $categoria = $_POST["categoria"];

  //* Validación
  validarCampos($nombre, $precio, $categoria);
  validarImagen();

  //* Subida archivos SI NO hay errores
  if (count($errores) < 1) {
    $fichero_destino = subir_archivos("ficheros/");
    $sql = "INSERT INTO `Productos` (`id`, `Nombre`, `Precio`, `Imagen`, `Categoría`) VALUES (NULL, :nombre, :precio, :imagen, :categoria);";
    $stmt = $conn->prepare($sql);

    // Vincular las variables
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':imagen', $fichero_destino);
    $stmt->bindParam(':categoria', $categoria);

    // Ejecuta la consulta
    try {
      $stmt->execute();
      echo "Inserción exitosa";
    } catch (PDOException $e) {
      echo "Error en la inserción: " . $e->getMessage();
    }
  }
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
    <?php if (empty($_POST)) : ?>
      <form action="crear_producto.php" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre">
        <label for="precio">Precio: </label>
        <input type="number" name="precio" id="precio" min="0">
        <label for="imagen">Imagen: </label>
        <input type="file" name="imagen" id="imagen">
        <label for="categoria">Categoría: </label>
        <select name="categoria" id="categoria">
          <?php
          //? Cargar categorias - ID como VALUE
          foreach ($categorias as $categoria) {
            echo "<option value='" . $categoria['Id'] . "'>" . $categoria['Nombre'] . "</option>";
          }
          ?>
        </select>
        <button type="reset">Reset</button>
        <button type="submit">Enviar</button>
      </form>
    <?php elseif (count($errores) === 0) : ?>
      <h2>¡Se ha creado el producto correctamente!</h2>
      <button><a href="/index.php">Volver atrás</a></button>
    <?php elseif (count($errores) > 0) : ?>
      <h2>Errores:</h2>
      <ul>
        <?php
        foreach ($errores as $key => $error) {
          echo "<li>" . $error . "</li>";
        }
        ?>
      </ul>
      <button><a href="/crear_producto.php">Volver atrás</a></button>
    <?php endif; ?>
  </main>
</body>

</html>
