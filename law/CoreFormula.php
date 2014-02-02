<?php

/**
 * Генерит формулы
 *
 * @author Animi
 */
class CoreFormula {
    private $_core_assoc = array(
        'F' => '_functions',
        'L' => '_labels',
        'O' => '_operators',
        'E' => '_expressions',
        'C' => '_constants'
    );
    
    static public $_count_e = 0;
    
    private $_labels = array('$x');
    private $_operators = array('*', '+', '-');
    private $_functions = array('sin', 'sqrt', 'log10', 'tan');
    private $_expressions = array('E', '');
    private $_constants = array(M_PI, 6.67, 300, 66.2, 16.0, 138, 7.29);
    
    private $_empty_labels = array('E');
    private $_empty_operators = array();
    private $_empty_functions = array('L', 'O', 'F', 'E', 'C');
    private $_empty_expressions = array();
    private $_after_empty = array('O');
    
    private $_labels_len = 0;
    private $_operators_len = 0;
    private $_functions_len = 0;
    private $_expressions_len = 0;
    private $_constants_len = 0;
            
    private $_basic_expression = 'F(LOC)OF(L)OCOL';
    private $_current_formula = '';
    private $_label_exists = array();
    
    public function __construct() {
        if (self::$_count_e > 10) {
            $this->_expressions = array('');
        }
        $this->_labels_len = count($this->_labels);
        $this->_operators_len = count($this->_operators);
        $this->_functions_len = count($this->_functions);
        $this->_expressions_len = count($this->_expressions);
        $this->_constants_len = count($this->_constants);
        
        $this->_current_template = $this->_basic_expression;
    }
    public function generateFormula() {
        $res_expression = '';
        $next_available_syms = array_keys($this->_core_assoc);
        foreach(str_split($this->_basic_expression) as $sym){
            $str = $this->getRndBySym($sym);
            if ($str == '') {
                $empty_name = '_empty' . $this->_core_assoc[$sym];
                $next_available_syms = $this->{$empty_name};
            } else {
                if (in_array($sym, $next_available_syms)) {
                    $res_expression .= $str;
                    $next_available_syms = array_keys($this->_core_assoc);
                    
                    if ($str == 'E') {                       
                        CoreFormula::$_count_e++;
                    }
                    
                    if ($sym == 'L') {
                        $this->addLabelExists($str);
                    }
                } elseif (!in_array($sym, array_keys($this->_core_assoc))) {
                    $res_expression .= $sym;
                }
            }

        }
        //echo $res_expression . '<br/>';
        return $this->checkAfterGenerate($res_expression);
    }
    private function addLabelExists($label) {
        // добавляем новый label в _label_exists        
        if (!in_array($label, $this->_label_exists)) {
            $this->_label_exists [] = $label;
        }
    }
    /**
     * Return rand f, o, l or e by $sym. If not such in $_core_assoc, return $sym
     * 
     * @param string $sym
     * @return string
     */
    private function getRndBySym($sym) {
        if (array_key_exists($sym, $this->_core_assoc)) {
            $_array_len_name = $this->_core_assoc[$sym] . '_len';
            return $this->{$this->_core_assoc[$sym]}[rand(0, $this->{$_array_len_name} - 1)];
        }
        return $sym;
    }
    
    private function checkAfterGenerate($expression){
        // убираем лишние скобки
        /*for($i = 0; $i < strlen($expression) - 1; $i++) {
            if (in_array($expression[$i], $this->_operators ) && $expression[$i + 1] == '(') {                
                for($j = $i + 1; $j < strlen($expression); $j++) {
                    if ($expression[$j] == ')') {
                        $expression[$j] == '';
                        break;
                    }
                }
                $expression[$i + 1] = '';                
            }
        }*/
        
        $expression = $this->recursiveRemove($expression, '()', '');
        //$expression = $this->recursiveRemove($expression, '((', '(');
        //$expression = $this->recursiveRemove($expression, '))', ')');        
        
        foreach ($this->_functions as $func) {
            if ($func == '') continue;
            $pos = strpos($expression, $func);
            if ($pos && $expression[$pos + strlen($func)] != '(' || strlen($expression) == strlen($func)) {
                $expression = str_replace($func, '', $expression);
            }
        }
        // убираем ошибочный оператор
        for($i = 0; $i < strlen($expression) - 1; $i++) {
            if (in_array($expression[$i], $this->_operators ) && $expression[$i + 1] == ')') {                
                $expression[$i] = '';
            }
        }
        // убираем скобки, если функция пустая
        if (substr($expression, 0, 1) == '(') {
            $expression = str_replace(array('(', ')'), '', $expression);
        }
        // последний символ не должен быть оператором
        if (in_array(substr($expression, -1),$this->_operators )) {
            $expression = substr($expression, 0, strlen($expression) - 1);
        }
        // убираем функцию, если аргумент пуст
        //if (!strpos($expression))
        return $expression;
    }
    
    private function recursiveRemove($expression, $from, $to) {
        $count = 1;
        while ($count > 0) {
            $temp = str_replace($from, $to, $expression, $count);
            if (strcmp($temp, $expression) == 0)
                $count = 0;
            $expression = $temp;
        }
        return $expression;
    }
    
    public function setCurrentFormula($formula) {
        $this->_current_formula = $formula;
    }
    
    public function getLabelExists() {
        return $this->_label_exists;
    }

}

?>

