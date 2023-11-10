<?php
function file_force_download($file) {
    $file = __DIR__ . '\\' . $file;
    // Получаем расширение файла
    $file_extension = pathinfo($file, PATHINFO_EXTENSION);

    // Список запрещенных расширений (например, ".php")
    $disallowed_extensions = array("php");

    if (file_exists($file) && !in_array($file_extension, $disallowed_extensions)) {
        if (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    } else {
        echo 'File not found or disallowed for download!';
    }
}


  if (isset($_GET['file'])) {
    file_force_download($_GET['file']);
  }else {
    echo('Hmmm');
  }