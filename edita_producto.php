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

// ? GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET) && isset($_GET["id"])) {
  $id = $_GET["id"];

  //* Carga el producto si tiene ID
  try {
    $sql = "SELECT Id, Nombre, Precio, Imagen, Categoría from Productos WHERE Id = " . $id;
    $stmt = $conn->query($sql);
    $producto = $stmt->fetch();
  } catch (PDOException $e) {
    echo "Error al obtener el producto recibido por ID: " . $e->getMessage();
  }
} else {
  //* Cargar productos
  try {
    $sql = "SELECT Id, Nombre, Precio, Imagen, Categoría from Productos";
    $stmt = $conn->query($sql);
    $productos = $stmt->fetchAll();
  } catch (PDOException $e) {
    echo "Error al obtener los productos: " . $e->getMessage();
  }
}

// ? POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {
  $id = $_POST["id"];
  $imagenURL = $_POST["imagen_url"];
  $nombre = $_POST["nombre"];
  $precio = $_POST["precio"];
  $categoria = $_POST["categoria"];

  //* Validación
  validarCampos($nombre, $precio, $categoria);
  // Validar imagen solo si adjunta una nueva
  if (!empty($_FILES['imagen']['name'])) validarImagen();

  //* Subida archivos SI NO hay errores
  if (count($errores) < 1) {
    $fichero_destino = !empty($_FILES['imagen']['name']) ? subir_archivos("ficheros/") : $imagenURL;
    $sql = "UPDATE `Productos` SET Nombre = :nombre, Precio = :precio, Imagen = :imagen, Categoría = :categoria WHERE Id = :id;";
    $stmt = $conn->prepare($sql);

    // Vincular las variables
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':imagen', $fichero_destino);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':id', $id);

    // Ejecuta la consulta
    try {
      $stmt->execute();
      echo "Actualización exitosa";
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
  <title>Editar producto</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
  </style>
</head>

<body>
  <header>
    <h1>Edición de un producto</h1>
  </header>
  <main>
    <?php if (empty($_POST) && !empty($id)) : ?>
      <?php
      echo '<form action="edita_producto.php" method="post" enctype="multipart/form-data">';
      // Añade dos inputs ocultos para guardar la ID del producto y la imagen cuando se envíen
      echo '  <input class="hidden" name="imagen_url" type="text" value="' . $producto['Imagen'] . '">';
      echo '  <input class="hidden" name="id" type="text" value="' . $producto['Id'] . '">';
      echo '  <label for="nombre">Nombre: </label>';
      echo '  <input type="text" name="nombre" id="nombre" value="' . $producto['Nombre'] . '">';
      echo '  <label for="precio">Precio: </label>';
      echo '  <input type="number" name="precio" id="precio" min="0" value="' . $producto['Precio'] . '">';
      echo '  <label for="imagen">Imagen: </label>';
      echo '  <input type="file" name="imagen" id="imagen">';
      echo '  <label for="categoria">Categoría: </label>';
      echo '  <select name="categoria" id="categoria">';
      //? Cargar categorias - ID como VALUE';
      foreach ($categorias as $categoria) {
        echo "<option value='" . $categoria['Id'] . "' " . ($categoria['Id'] === $producto['Categoría'] ? 'selected' : '') . ">" . $categoria['Nombre'] . "</option>";
      }
      echo '</select>';
      echo '<button type="reset">Reset</button>';
      echo '<button type="submit">Enviar</button>';
      echo '</form>';
      ?>
      <!-- SI NO HAY ID, ABRIR DESPLEGABLE -->
    <?php elseif (empty($_GET) && empty($id)) : ?>
      <form action="edita_producto.php" method="GET">
        <label for="id">Seleccione un producto: </label>
        <select name="id" id="id">
          <?php
          //? Cargar productos
          foreach ($productos as $producto) {
            echo "<option value='" . $producto['Id'] . "'>" . $producto['Nombre'] . "</option>";
          }
          ?>
        </select>
        <button type="submit">Enviar</button>
      </form>
    <?php elseif (count($errores) === 0) : ?>
      <h2>¡Se ha editado el producto correctamente!</h2>
      <a href="/index.php">Volver atrás</a>
    <?php elseif (count($errores) > 0) : ?>
      <h2>Errores:</h2>
      <ul>
        <?php
        foreach ($errores as $key => $error) {
          echo "<li>" . $error . "</li>";
        }
        ?>
      </ul>
      <a href="/crear_producto.php">Volver atrás</a>
    <?php endif; ?>
  </main>
</body>

</html>
