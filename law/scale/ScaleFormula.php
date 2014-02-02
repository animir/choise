<?php

/**
 * Description of ScaleFormula
 *
 * @author Animi
 */
class ScaleFormula {
    private $_labels = array();
    private $_avarage_relation = array();        
    private $_count_av_rels = 0;
    private $_result_relation = array();
    private $_min_avarage_rel = 1;
    private $_general_mult = 1;
    
    public function __construct($varNames) {
        if (!is_array($varNames)) $varNames = array($varNames);
        foreach ($varNames as $name) {
            $this->_avarage_relation[$this->_count_av_rels][$name] = 1;            
            $this->_result_relation[$name] = 1;
            $this->_labels []= $name;
        }            
        $this->_count_av_rels++;
    }
    
    public function add($fv, $vars) {
        $this->_count_av_rels++;
        if ($fv == 0) $fv = 1;
        foreach($vars as $name => $v) {
            if ($v == 0) $v = 1;
            $this->_avarage_relation[$this->_count_av_rels][$name] = $fv / $v;
            $this->_result_relation[$name] = ($this->_result_relation[$name] + $this->_avarage_relation[$this->_count_av_rels][$name]) / 2;
        }
        $this->calcGeneralScale();
        //echo $this->_general_mult . ' | ';
    }
    
    public function getMultiplier($fv, $vars) {
        $curRel = array();        
        if ($fv == 0) $fv = 1;
        foreach($vars as $name => $v) {
            if ($v == 0) $v = 1;
            $curRel[$name] = $fv / $v;
        }
        $workCurRel = $this->getAvarage($curRel);
        $resultRel = $this->getAvarage($this->_result_relation);        
        if ($resultRel == null)
            $resultRel = $fv;        
        return $workCurRel / $resultRel * $this->_general_mult;
    }
    
    private function getAvarage(array $array) {
        if (empty($array)) return null;
        /*$result = array_shift($array);
        foreach ($array as $name => $v) {
            $result = ($result + $v) / 2;
        }*/
        $result = array_sum($array) / count($array);
        return $result;
    }
    
    private function calcGeneralScale(){
        $avarageRelArray = array();
        foreach($this->_avarage_relation as $relation) {
            $avarageRelArray []= $this->getAvarage($relation);
        }
        if ($this->getAvarage($avarageRelArray) < $this->_min_avarage_rel) {
            $this->_general_mult *= 2;
            foreach ($this->_avarage_relation as $k => $relation) {
                foreach($relation as $label => $v) {
                    if ($this->_avarage_relation == 0) $this->_avarage_relation = 1;
                       $this->_avarage_relation[$k][$label] *= $this->_general_mult;
                }
            }
        } 
    }
    
    /*private function calcAvrgRelations() {
        foreach($this->_relations as $fv => $relations ) {
            foreach($relations as $name => $rv) {
                $this->_avarage_relation[$this->_count_av_rels][$name] = ($this->_avarage_relation[$name] + $rv) / 2;
            }            
            $this->_count_av_rels++;
        }
    }*/
    
}

?>
