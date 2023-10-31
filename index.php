<?php

var_dump($_POST);

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividad 3.1</title>
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
      <h1>Lista de productos</h1>
    </header>
    <main>
      <a href="crear_producto.php"><span class="fa-solid fa-plus-circle"></span>Crear producto</a>
      <a href="listado_productos.php"><span class="fa-solid fa-repeat"></span>Consultar listado</a>
      <a href="edita_producto.php"><span class="fa-solid fa-pen-to-square"></span>Modificar producto</a>
      <a href=""><span class="fa-solid fa-trash"></span>Eliminar producto</a>
    </main>
  </body>

</html>
