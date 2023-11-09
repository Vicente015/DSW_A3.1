<?php

// TODO: Guardar imagen con el nombre del producto

/**
 * Sube los archivos a `directorio_destino` y renombra los archivos si ya existen
 */
function subir_archivos(string $directorio_destino)
{
  foreach ($_FILES as $clave => $valor) {
    $nombreArchivo = $_FILES[$clave]["name"];
    if (!$nombreArchivo) continue;
    $fichero_destino = $directorio_destino . basename($nombreArchivo);

    $contador = 1;
    // Mientras el archivo esté repetido, añadirle un _CONTADOR al nombre
    while (file_exists($fichero_destino) === true) {
      // Separa el nombre y la extension ej: "file1.png" => ["file", "png"]
      [$nombre, $extension] = explode(".", basename($nombreArchivo));
      $fichero_destino = $directorio_destino . $nombre . "_" . $contador . "." . $extension;
      $contador++;
    }

    // TODO: Adaptar a execepciones? https://www.w3schools.com/php/php_exceptions.asp
    if (move_uploaded_file($_FILES[$clave]["tmp_name"], $fichero_destino)) {
      return $fichero_destino;
    } else {
      return false;
    }
  }
}
