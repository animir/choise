<?php

/*
 * Подставляет значение переменных и возвращает результат выполнения
 */

/**
 * Description of FinalFormula
 *
 * @author Animi
 */
require_once 'law/scale/ScaleFormula.php';
class FinalFormula {
    private $_final_formula = '';
    private $_label_exists = array();
    private $_formula;
    private $_scale;
    
    public function __construct(Formula $formula) {
        echo $formula->getFinalFormula() . '</br>';
        $this->_final_formula = $formula->getFinalFormula();
        $this->_label_exists = $formula->getLabelExists();
        $this->_scale = new ScaleFormula($this->_label_exists);
        $this->_formula = $formula;
        $this->_label_exists = array_combine(range(0, count($this->_label_exists) - 1), $this->_label_exists);
    }
    public function get() {
        return $this->_final_formula;
    }
    public function getLabelExists() {
        return $this->_label_exists;
    }
    public function calcValue($values) {
        try {
            $result = abs($this->_formula->calcFormula($values));
        } catch(Exception $e) {
            return null;
        }
        $this->_scale->add($result, $values);
        //echo 'mult = ' . $this->_scale->getMultiplier($result, $values) . ' | ';
                //echo 'res = ' . $result . ' | ';
        return $result * $this->_scale->getMultiplier($result, $values);
    }
    
}

?>
