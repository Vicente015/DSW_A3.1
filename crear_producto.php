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

// Si no hay categorías, añadir 2 por defectos
if (empty($categorias)) {
  try {
    $stmt = $conn->query("
INSERT INTO Categorías (Nombre)
SELECT 'Moviles'
WHERE NOT EXISTS (SELECT 1 FROM Categorías);

INSERT INTO Categorías (Nombre)
SELECT 'Portatiles'
WHERE NOT EXISTS (SELECT 1 FROM Categorías);
");
    $stmt->execute();
  } catch (PDOException $e) {
    echo "Error al obtener las categorías: " . $e->getMessage();
  }
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
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header>
    <h1>Crear producto</h1>
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
