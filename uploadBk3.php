<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si el archivo fue cargado sin errores
    if(isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0){
        $filename = $_FILES["fileToUpload"]["name"];
        $filetype = $_FILES["fileToUpload"]["type"];
        $filesize = $_FILES["fileToUpload"]["size"];
    
        // Verifica la extensión del archivo
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if($ext != "csv") {
            die("Por favor, sube solo archivos .csv.");
        }
    
        // Mueve el archivo a la carpeta de destino
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $filename);
    
        // Abre el archivo CSV
        $file = fopen($filename, 'r');

        // Imprime la tabla HTML
        echo "<table style='border-collapse: collapse; margin: auto; border: 1px solid black; table-layout: fixed; width: 100%;'>";
        
        // Imprime la cabecera de la tabla
        echo "<tr>";
        // Lee la cabecera del archivo CSV
        $cabecera = fgetcsv($file);
        foreach ($cabecera as $field) {
            echo "<td style='border: 1px solid black; padding: 5px; text-align: center;'><strong>{$field}</strong></td>";
        }
        echo "</tr>";

        // Lee las filas del archivo CSV
        while ($line = fgetcsv($file)) {
            // Imprime la fila de datos
            echo "<tr>";
            foreach ($line as $field) {
                echo "<td style='border: 1px solid black; padding: 5px; text-align: center'>{$field}</td>";
            }
            echo "</tr>";
        }

        echo "</table>";

        // Cierra el archivo CSV
        fclose($file);        
    } else {
        echo "Hubo un error al subir tu archivo.";
    }
} else {
    echo "Error: Método de solicitud incorrecto.";
}
?>
