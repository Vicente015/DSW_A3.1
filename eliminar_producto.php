<?php

include "utils/database.php";
include "utils/validacion.php";

//* Cargar categorías
try {
  $sql = "SELECT Id, Nombre FROM Categorías";
  $stmt = $conn->query($sql);
  $categorias = $stmt->fetchAll();
} catch (PDOException $e) {
  echo "Error al obtener las categorías: " . $e->getMessage();
}

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
  
    $sql = "DELETE FROM Productos WHERE Id = '$id'";
    $stmt = $conn->prepare($sql);
  
    // Ejecuta la consulta
    try {
      $stmt->execute();
      echo "Borrado exitoso";
    } catch (PDOException $e) {
      echo "Error al borrar: " . $e->getMessage();
    }
  }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar producto</title>
    <!-- Otros enlaces y estilos aquí -->
</head>

<body>
    <header>
        <h1>Eliminación de un producto</h1>
    </header>
    <main>
        
    <title>Eliminar producto</title>
    <!-- Otros
<?php if (empty($_GET) || !isset($_GET["id"])) : ?>
            <form action="eliminar_producto.php" method="GET">
                <label for="id">Seleccione un producto a eliminar: </label>
                <select name="id" id="id">
                    <?php
                    // Cargar productos
                    foreach ($productos as $producto) {
                        echo "<option value='" . $producto['Id'] . "'>" . $producto['Nombre'] . "</option>";
                    }
                    ?>
                </select>
                <button type="submit">Eliminar</button>
            </form>
        <?php endif; ?>
    </main>
</body>

</html>
