<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormulaFabric
 *
 * @author Animi
 */
require_once 'Formula.php';
class FormulaFabric {
    /**
     * @return Formula
     */
    public function createFormula() {
        $formula = new Formula;
        $coreFormula = new CoreFormula();
        CoreFormula::$_count_e = 0;
        $formula->setExpression($coreFormula->generateFormula());
        $formula->setLabelExists($coreFormula->getLabelExists());
        $formula->preapareExpression();
        return $formula;
    }
}

?>
