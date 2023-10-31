<?php
$mensajeError = "";
$nombre = $_POST["nombre"];
$precio = $_POST["precio"];
$categoria = $_POST["categoria"];

var_dump($_FILES);

if (empty($nombre) || empty($precio) || empty($categoria)) {
  $mensajeError = "Todos los campos son requeridos. Por favor, complete el formulario.";
} else {
  // Validación del precio y la categoría como números mayores que 0
  if (!is_numeric($precio) || !is_numeric($categoria) || $precio <= 0 || $categoria <= 0) {
    $mensajeError = "El precio y la categoría deben ser números mayores que 0.";
  } else {
    // Validación de la imagen como archivo de imagen
    $imagen = $_FILES["imagen"];
    echo $imagen;
    $imagenNombre = $imagen["name"];
    $imagenTipo = $imagen["type"];

    // Verifica que el archivo sea una imagen
    $permitidos = array("image/jpg", "image/jpeg", "image/png", "image/gif");
    if (!in_array($imagenTipo, $permitidos)) {
      $mensajeError = "El archivo de imagen no es válido. Debe ser una imagen en formato JPG, JPEG, PNG o GIF.";
    }
  }
}

// Comprueba si hay algún mensaje de error
if (!empty($mensajeError)) {
  echo $mensajeError; // Muestra el mensaje de error
} else {
  // Procesa el formulario, ya que todos los campos han sido validados
  // Aquí puedes realizar las acciones necesarias, como subir la imagen a un servidor o guardar los datos en una base de datos.
  echo "Formulario válido. Puedes procesar los datos ahora.";
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
      <form action="crear_producto.php" method="post">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" required>
        <label for="precio">Precio: </label>
        <input type="number" name="precio" id="precio" min="0" required>
        <label for="imagen">Imagen: </label>
        <input type="file" name="imagen" id="imagen" required>
        <label for="categoria">Categoria: </label>
        <input type="number" name="categoria" id="categoria" min="0" required>
        <button type="reset">Reset</button>
        <button type="submit">Enviar</button>
      </form>
    </main>
  </body>

</html>
