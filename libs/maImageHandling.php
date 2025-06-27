<?php
include_once("libs/modele.php");

function uploadImage($idObjet)
{
    $currentDir = getcwd();
    $uploadDirectory = '/uploads/tmp/';

    if (!empty($_FILES['fileAjax'] ?? null)) {
        $fileName = $_FILES['fileAjax']['name'];
        $fileTmpName = $_FILES['fileAjax']['tmp_name'];
        $uploadOk = 1;

        $uploadPath = $currentDir . $uploadDirectory . basename($fileName);

        $imageFileType = strtolower(pathinfo($uploadPath, PATHINFO_EXTENSION));

        if (count(getImagesByObjet($idObjet)) > 3) {
            echo "Limite de 4 images atteinte.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($uploadPath)) {
            echo "L'image existe déjà (contacter le respo web)."; // c'est pas normal ça
            $uploadOk = 0;
        }

        // Check file size (not larger than 20mB)
        if ($_FILES["fileAjax"]["size"] > 20000000) {
            echo "L'image est trop large (limite de 20Mo).";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Désolé, uniquement les JPEG, PNG et GIF sont autorisés.";
            $uploadOk = 0;
        }

        if (isset($fileName) && $uploadOk == 1) {
            $didUpload = convertImage($fileTmpName, $uploadPath, 85);

            if ($didUpload) {

                $hash = hash_file('md5', $uploadPath);
                rename($uploadPath, $currentDir . "/uploads/imagesObjets/".$hash.".jpg");

                $idImage = creerImage($idObjet, $hash);

                echo "L'image a été téléversé";
                echo ",".$hash.",".$idImage;
            } else {
                echo 'An error occurred while uploading. Try again.';
            }
        }
    }

    
}

/**
*   Auxiliar function to convert images to JPG
*/
function convertImage($originalImage, $outputImage, $quality) {

    switch (exif_imagetype($originalImage)) {
        case IMAGETYPE_PNG:
            $imageTmp=imagecreatefrompng($originalImage);
            break;
        case IMAGETYPE_JPEG:
            $imageTmp=imagecreatefromjpeg($originalImage);
            break;
        case IMAGETYPE_GIF:
            $imageTmp=imagecreatefromgif($originalImage);
            break;
        case IMAGETYPE_BMP:
            $imageTmp=imagecreatefrombmp($originalImage);
            break;
        // Defaults to JPG
        default:
            $imageTmp=imagecreatefromjpeg($originalImage);
            break;
    }

    // quality is a value from 0 (worst) to 100 (best)
    imagejpeg($imageTmp, $outputImage, $quality);
    imagedestroy($imageTmp);

    return 1;
}