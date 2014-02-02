<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once 'law/scale/ScaleFormula.php';
        $scale = new ScaleFormula('$x');
        $scale->add(2, array('$x' => 100));
        $scale->add(3, array('$x' => 200));
        echo $scale->getMultiplier(2, array('$x' => 200));
        $scale->add(4, array('$x' => 300));
        echo $scale->getMultiplier(2, array('$x' => 200));
        $scale->add(4, array('$x' => 250));
        echo $scale->getMultiplier(2, array('$x' => 200));
        $scale->add(3, array('$x' => 240));
        echo $scale->getMultiplier(2, array('$x' => 200));
        $scale->add(3, array('$x' => 230));
        echo $scale->getMultiplier(2, array('$x' => 200));
        $scale->add(3, array('$x' => 220));
        echo $scale->getMultiplier(2, array('$x' => 200));
        ?>
    </body>
</html>
