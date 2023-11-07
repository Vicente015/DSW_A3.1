<?php

$errores = [];

function validarCampos($nombre, $precio, $categoria) {
  if (empty($nombre) || empty($precio) || empty($categoria)) {
    array_push($errores, "Todos los campos son requeridos. Por favor, complete el formulario.");
  }

  // TODO: Categoría obtenida de la DB
  // Validación del precio y la categoría como números mayores que 0
  if (!is_numeric($precio) || !is_numeric($categoria) || $precio <= 0 || $categoria <= 0) {
    array_push($errores, "El precio y la categoría deben ser números mayores que 0.");
  }
}

// TODO: Devolver errores

function validarImagen() {
  $imagen = $_FILES["imagen"];
  $imagenNombre = $imagen["name"];
  $imagenTipo = strtolower(pathinfo($imagenNombre, PATHINFO_EXTENSION));

  // Verifica que el archivo sea una imagen
  $permitidos = array("jpg", "jpeg", "png", "pdf");
  if (!in_array($imagenTipo, $permitidos)) {
    $mensajeError = "El archivo no es válido. Debe ser un archivo en formato JPG, JPEG, PNG, PDF.";
  }
}
