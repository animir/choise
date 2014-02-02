<?php

/**
 * Description of Choise
 *
 * @author Animi
 */
require_once 'law/FinalFormula.php';
require_once 'law/FormulaFabric.php';
require_once 'image/Canvas.php';
require_once 'private/config.php';
class Choise {
    private $_final_formula;
    
    private $_canvas;
    
    public function __construct() {
        $this->_canvas = new Canvas();
    }
    
    public function regenerateFormula() {
        $formulaFabric = new FormulaFabric;        
        $formula = $formulaFabric->createFormula();
        $finalFormula = new FinalFormula($formula);        
        $this->_final_formula = $finalFormula;
    }
    
    public function getFormula() {
        return $this->_final_formula->get();
    }    
    public function getLabelExists(){
        return $this->_final_formula->getLabelExists();
    }
    
    public function doChoise($formulaCount = 2) {
        $this->_canvas->createImagesSet($formulaCount);        
        //$this->img = imagerotate($this->img, rand(0, 3) * 90, $this->white );
        $noiseDots = 2000;
        //$_avarage_y = 1;
        //echo $this->getFormula() . '<br/>';

        for ($i = 0; $i < $noiseDots; $i++) {
            $x = rand(0,CANVAS_WIDTH - 1);
            
            $this->_canvas->draw(array('$x' => $x));                                                
            //$x = rand($x1Area,$x2Area - $xLength);
            //$y = rand($y1Area,$y2Area - $yLength);
            //$y = $choise->evalFormula(array('$x' => $x));
            //if (is_null($y)) continue;
        }
        $this->_canvas->printCanvas();
    }
    
   
}

?>
