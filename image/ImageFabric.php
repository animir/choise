<?php

/**
 * Description of ImageFabric
 *
 * @author Animi
 */
require_once 'Image.php';
class ImageFabric {

   public function __construct() {        
       
   }
   
   public static function createImage(Coordinates $coordinates) {
        $image = new Image;
        $image->setImg(imagecreate($coordinates->getWidth(), $coordinates->getHeight()));
        $image->setCoordinates($coordinates);
        return $image;
   }
}

?>
