<?php

require_once "../src/models/users/Users.php";

class ImageManager{

    public static function saveProfileImage($email, $image){
        if($image['error'] === UPLOAD_ERR_OK){
            $fileTmpPath = $image['tmp_name'];
            $fileName = $image['name'];
            $fileSize = $image['size'];
            $fileType = $image['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($fileExtension, $allowedfileExtensions)) {
                $user = Users::fromEmail($email);

                $dest_path = "assets/images/profilepictures/" . $user->getUsername() . "." . $fileExtension;

                move_uploaded_file($fileTmpPath, $dest_path);
                return true;
            }
        }

        return false;
    }

    public static function getUserImagePath($email){
        $user = Users::fromEmail($email);
        if($user->getImageExtension() != ""){
            return IMAGE_PATH . "profilepictures/" . $user->getUsername() . "." . $user->getImageExtension();
        }

        return IMAGE_PATH . "/icons/profilePic.png";
    }

    public static function getProductImagePath($id){
        require_once "../src/models/products/ProductsManager.php";

        $product = ProductsManager::fromId($id);
        if($product->getImg1() != ""){
            return IMAGE_PATH . "productimages/" . $id . "." . $product->getImg1();
        }

        return IMAGE_PATH . "/icons/profilePic.png";
    }
}