<?php

/**
 * Description of Canvas
 *
 * @author Animi
 */
require_once 'ImageFabric.php';
require_once 'Coordinates.php';
require_once 'Drawer.php';
class Canvas {
    private $_images = array();    
    private $_canvas;
    private $_coordinates;
    private $_drawer;
    public function __construct() {
        $this->_canvas = imagecreate(CANVAS_WIDTH, CANVAS_HEIGHT);
        $white = imagecolorallocate($this->_canvas, 255, 255, 255);
	imagecolortransparent($this->_canvas, $white);
        $this->_coordinates = new Coordinates(CANVAS_WIDTH, CANVAS_HEIGHT);
        $this->_drawer = Drawer::getInstance();
    }
    
    public function draw($values){
        /*@var $image Image */
        /*@var $imageCoords Coordinates */
        foreach($this->_images as $image) {
            $res = $image->evalFormula($values);
            $this->_drawer->drawDot($this->_canvas, Coordinates::getCanvasCoordinates($res, $values));
            //$imageCoords = $image->getCoordinates();
            //imagecopy($this->_canvas , $image->getImg() ,  , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h )
        }
    }
    /**
     * Добавляет новый Image на канву. По-умолчанию размером канвы.
     * @param Image $image
     */
    public function addImage(Image $image = null){
        if (is_null($image)) {
            $this->_images[count($this->_images) + 1] = ImageFabric::createImage($this->_coordinates);
        } else {
            $this->_images[count($this->_images) + 1] = $image;
        }
    }
    
    public function createImagesSet($count = 10) {
        for($i = 0; $i < $count; $i++) {
            $this->addImage();
        }
    }
    
    public function removeImage($key){
        unset($this->_images[$key]);
    }
    
    public function printCanvas() {
        imagepng($this->_canvas, 'test.png');
    }
    
    public function printFormulas() {
        foreach ($this->_images as $image) {
            echo $image->getFormula()->get() . '<br/>';
        }
    }
    
}

?>
