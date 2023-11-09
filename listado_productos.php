<?php

include "utils/database.php";

//* Cargar productos
try {
  $sql = "SELECT Id, Nombre, Precio, Imagen, Categoría from Productos";
  $stmt = $conn->query($sql);
  $productos = $stmt->fetchAll();
} catch (PDOException $e) {
  echo "Error al obtener los productos: " . $e->getMessage();
}


//* Cargar categorías
try {
  $sql = "SELECT Id, Nombre FROM Categorías";
  $stmt = $conn->query($sql);
  $categorias = $stmt->fetchAll();
} catch (PDOException $e) {
  echo "Error al obtener las categorías: " . $e->getMessage();
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

    p,
    h1,
    h2,
    h3 {
      margin: 0;
      padding: 0;
    }

    .product {
      display: flex;
      flex-direction: column;
      border-radius: 15px;
      background-color: var(--background);
      box-shadow: 0 0 10px var(--button-base);

      & img {
        width: 100%;
        border-radius: 15px 15px 0 0;
      }

      & .content {
        display: flex;
        flex-direction: column;
        padding: .5em 1em;
        gap: .5em;
        height: 100%;
      }
    }

    .buttons {
      display: flex;
      flex-direction: row;
      gap: 0.5em;
      margin: 0;
      margin-top: auto;
      align-items: center;
      justify-content: center;
    }

    a {
      background-color: var(--button-base);
      color: var(--text-main);
      padding: .5em 1em;
      border-radius: 15px;
      text-align: center;
    }

    a:hover {
      background-color: var(--button-hover);
    }

    .categoria {
      font-weight: bold;
    }

    .products {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 1em;
    }
  </style>
</head>

<body>
  <header>
    <h1>Lista de productos</h1>
  </header>
  <main>
    <section class="products">
      <?php
      //? Cargar productos
      foreach ($productos as $producto) {
        echo "<div class=\"product\">";
        echo "  <img src=\"" . $producto['Imagen'] . "\" alt=\"" . $producto['Nombre'] . "\">";
        echo "  <div class=\"content\">";
        echo "    <h3>" . $producto['Nombre'] . "</h3>";
        echo "    <p class=\"categoria\">" . $categorias[$producto['Categoría']]['Nombre'] . "</p>";
        echo "    <p class=\"precio\">" . $producto['Precio'] . "€</p>";
        echo "    <div class=\"buttons\">";
        echo "      <a href=\"edita_producto.php\"><span class=\"fa-solid fa-pen\"></span> Editar</a>";
        echo "      <a href=\"elimina_producto.php\"><span class=\"fa-solid fa-trash\"></span> Eliminar</a>";
        echo "    </div>";
        echo "  </div>";
        echo "</div>";
      }
      ?>
    </section>
  </main>
</body>

</html>
