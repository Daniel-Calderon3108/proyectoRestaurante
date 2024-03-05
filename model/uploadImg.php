<?php

class UploadImg
{
    public function upload($file, $extension, $size, $temp, $path)
    {
        $message = "";

        if (!((strpos($extension, "gif") || strpos($extension, "jpeg") || strpos($extension, "jpg") || strpos($extension, "png")) && ($size < 2000000))) {
            $message = "Error. La extensión o el tamaño de los archivos no es correcta. - Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.";
        } else {
            if (move_uploaded_file($temp, '../views/img/' . $path . '/' . $file)) {
                chmod('../views/img/users/' . $file, 0777);
            } else {
                $message = "Ocurrió algún error al subir el fichero. No pudo guardarse.";
            }
        }
        return $message == "" ? true : $message;
    }
}
