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
      <form action="/" method="post">
        <button type="submit" value="crear" name="accion"><span class="fa-solid fa-plus-circle"></span> Crear
          producto</button>
        <button type="submit" value="consultar" name="accion"><span class="fa-solid fa-repeat"></span> Consultar
          listado</button>
        <button type="submit" value="modificar" name="accion"><span class="fa-solid fa-pen-to-square"></span>
          Modificar producto</button>
        <button type="submit" value="eliminar" name="accion"><span class="fa-solid fa-trash"></span> Eliminar
          producto</button>
      </form>
    </main>
  </body>

</html>
