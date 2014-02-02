<?php

/**
 * 
 *
 * @author Animi
 */
class Drawer {
   static private $_instance;
   private $_white;
   private $_black;
   
   private function __construct() {
       $img = imagecreate(CANVAS_WIDTH, CANVAS_HEIGHT);
       $this->_white = imagecolorallocate($img, 255, 255, 255);
       $this->_black = imagecolorallocate($img, 0, 0, 0);
   }
   
   private function __clone() {
       ;
   }
   
   static public function getInstance() {
       if (is_null(self::$_instance)) {
           self::$_instance = new Drawer();
       } 
       return self::$_instance;
   }
   public function drawDot(&$canvas, array $coordinates){
       imagefilledrectangle($canvas, $coordinates['$x'], $coordinates['$y'], $coordinates['$x'] + 1, $coordinates['$y'] + 1, imagecolorallocate($canvas, 0, 0, 0));
   }

}

?>
