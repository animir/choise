<?php

/*
 * собирается конечную формулу. eval по формуле
 */

/**
 * Description of Formula
 *
 * @author Animi
 */
require_once 'CoreFormula.php';
require_once 'FormulaFabric.php';

class Formula {
    private $_expression = '';
    private $_formulas = array();
    private $_label_exists = array();
    
    private $_min_float = MIN_FLOAT;
    private $_max_int = MAX_INT;        
    
    public function preapareExpression(){
        $formulaFabric = new FormulaFabric();
        foreach(str_split($this->_expression) as $k => $sym) {
            if ($sym == 'E') {
                $this->_formulas []= $formulaFabric->createFormula();
            }
        }
    }
    
    public function getFinalFormula() {
        $countE = 0;
        $finalFormula = '';
        foreach(str_split($this->_expression) as $k => $sym) {
            if ($sym == 'E') {
                $curFormula = $this->_formulas[$countE];
                $finalFormula .= $curFormula->getFinalFormula();
                $this->_label_exists = array_unique(array_merge($this->_label_exists, $curFormula->getLabelExists()));
                $countE++;
            } else {
                $finalFormula .= $sym;
            }
        }
        return $finalFormula;
    }
    
    public function getLabelExists() {
        return $this->_label_exists;
    }
    public function setLabelExists(array $label_exists) {
        $this->_label_exists = $label_exists;
    }
    public function setExpression($expression) {
        $this->_expression = $expression;
    }
    public function getExpression() {
        return $this->_expression;
    }
    public function getFormulas() {
        return $this->_formulas;
    }
    
    public function calcFormula($values){        
        $countE = 0;
        $finalValue = '';

        foreach($this->getLabelExists() as $label) {
            eval($label . ' = ' . $values[$label] . ';');
        }    
        
        foreach(str_split($this->_expression) as $k => $sym) {
            if ($sym == 'E') {
                $curFormula = $this->_formulas[$countE];
                $value = abs($curFormula->calcFormula($values));                
                
                if ($value < $this->_min_float) $value = $value * 100;
                if ($value > $this->_max_int) $value = $value / 100;
                $finalValue .= $value;                
                $countE++;
            } else {
                $finalValue .= $sym;
            }
        }        
        
        @eval('$result = ' . $finalValue . ';');
        if (is_nan($result) || is_infinite($result)) {
            throw new Exception('Result of ' . $this->_expression . ' on ' . print_r($values, true) . ' is not defined');
        }
        return $result;        
    }
}

?>
