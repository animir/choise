<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Каждое изображение содержит в себе формулу, по которой можно получить значение
 * для отрисовки на канве.
 *
 * @author Animi
 */



class Image {
    private $_img;
    private $_coordinates;
    private $_black;
    private $_white;
    
    private $_final_formula;
    
    public function __construct() {
        $formulaFabric = new FormulaFabric;
        $formula = $formulaFabric->createFormula();
        $finalFormula = new FinalFormula($formula);
        $this->_final_formula = $finalFormula;
    }
    
    public function getCoordinates(){
        return $this->_coordinates;
    }
    
    public function setCoordinates($coord){
        $this->_coordinates = $coord;
    }
    
    public function setImg($img) {
        $this->_img = $img;
        $this->_white = imagecolorallocate($this->_img, 255, 255, 255);
        imagecolortransparent($this->_img, $this->_white);
        $this->_black = imagecolorallocate($this->_img, 0, 0, 0);
    }
    public function getImg(){
        return $this->_img;
    }    
    
    public function getFormula(){
        return $this->_final_formula;
    }
    
    public function setFormula($formula){
        $this->_final_formula = $formula;
    }
    
    public function evalFormula($values) {
        //echo $this->_final_formula->get() . '</br>';
        try {
            return $this->_final_formula->calcValue($values);
        } catch (Exception $e) {
            echo $e->getMessage() . '<br/>';
            return null;
        }
    }
    
}

?>
