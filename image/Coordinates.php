<?php
/**
 * Обработка координат для канвы
 *
 * @author Animi
 */
class Coordinates {
    private $_coordinates = array('x1' => 0,
                                  'y1' => 0,
                                  'x2' => 0,
                                  'y2' => 0);
    private $_height = null;
    private $_width = null;
    
    public function __construct($width, $height) {
        $this->x2 = (int)$width;
        $this->y2 = (int)$height;
    }
    
    public function __get($name) {
        return $this->_coordinates[strtolower($name)];
    }    
    public function __set($name, $value) {
        return $this->_coordinates[strtolower($name)] = $value;
    } 
    
    public function getHeight(){
        if (is_null($this->_height)) {
            $this->_height = $this->_coordinates['y2'] - $this->_coordinates['y1'];
        }
        return $this->_height;
    }    
    
    public function getWidth(){
        if (is_null($this->_width)) {
            $this->_width = $this->_coordinates['x2'] - $this->_coordinates['x1'];
        }
        return $this->_width;
    } 
    // сейчас только для двумерной системы координат
    public static function getCanvasCoordinates($res, array $values) {
        return array('$x' => array_pop($values), '$y' => $res);
    }
    
}

?>
