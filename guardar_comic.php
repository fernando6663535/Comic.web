<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["comic"])) {
    $target_directory = "comics/"; // Directorio donde se guardarán los cómics
    $target_file = $target_directory . basename($_FILES["comic"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Verificar si el archivo es una imagen
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["comic"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "El archivo no es una imagen.";
            $uploadOk = 0;
        }
    }

    // Verificar si el archivo ya existe
    if (file_exists($target_file)) {
        echo "El archivo ya existe.";
        $uploadOk = 0;
    }

    // Verificar tamaño del archivo
    if ($_FILES["comic"]["size"] > 5000000) {
        echo "El archivo es demasiado grande.";
        $uploadOk = 0;
    }

    // Permitir solo ciertos formatos de archivo
    if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
        echo "Solo se permiten archivos JPG, JPEG, PNG.";
        $uploadOk = 0;
    }

    // Verificar si $uploadOk es igual a 0
    if ($uploadOk == 0) {
        echo "Lo siento, tu archivo no fue subido.";
    } else {
        // Intentar subir el archivo
        if (move_uploaded_file($_FILES["comic"]["tmp_name"], $target_file)) {
            echo "El cómic ". htmlspecialchars( basename( $_FILES["comic"]["name"])). " ha sido subido.";
        } else {
            echo "Lo siento, hubo un error al subir tu archivo.";
        }
    }
}
?>