<?php

/**
 * Генерит набор точек для просчета по всем формулам одновременно
 *
 * @author Animi
 */
class Values {
    private $_x;
    private $_y;
    private $_values;
    private $_vars = array(
        '$x',
        //'$y'
    );
    private $_images = array();
        
 
    
    public function __construct($countVars = 0) {
        if ((bool)$countVars) {
            $this->_values = $this->generateValues($countVars);
        }
    }
    
    public function getFormulaValues() {
        foreach($this->_values as $value) {
            
        }
    }
    
    public function generateValues($countVars = 1) {
        for($i = 0; $i < $countVars; $i++) {
            $value = array();
            foreach($this->_vars as $var) {
                $value[$var] = rand(0, CANVAS_WIDTH);
            }
        }
    }
    
}

?>
