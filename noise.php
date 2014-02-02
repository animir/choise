<?php
	//require_once('fb.php');

	define('IMAGE_WIDTH',500);
	define('IMAGE_HEIGHT',500);

class mngImage
{
	private $img;
	private $black;
        private $white;

	function printImage()
	{
            imagepng($this->img, 'test.png');
	}

    function __construct() {
	    $this->img = imagecreate(IMAGE_WIDTH, IMAGE_HEIGHT);
	    $this->white = imagecolorallocate($this->img, 255, 255, 255);
	    imagecolortransparent($this->img, $this->white);
	    $this->black = imagecolorallocate($this->img, 0,0,0);
    }
	function fillSolidAreas($numAreas, $maxWidthRect)
	{
		for ($i=0; $i < $numAreas; $i++){
			$x1 = rand(0, IMAGE_WIDTH - 1 - $maxWidthRect);
			$x2 = $maxWidthRect + rand($x1 + 1, $x1 + $maxWidthRect);
         	$y1 = rand(0, IMAGE_HEIGHT - 1 - $maxWidthRect);
			$y2 = $maxWidthRect + rand($y1 + 1, $y1 + $maxWidthRect);
            imagefilledrectangle($this->img, $x1, $y1, $x2, $y2, $this->black);
		}

	}

    function fillAreas($numAreas, $per, $maxWidthRect)
	{
		for ($i=0; $i < $numAreas; $i++){
			$x1 = rand(0, IMAGE_WIDTH - 1 - $maxWidthRect);
			$x2 = $maxWidthRect + rand($x1 + 1, IMAGE_WIDTH - $maxWidthRect);
			$y1 = rand(0, IMAGE_HEIGHT - 1 - $maxWidthRect);
			$y2 = $maxWidthRect + rand($y1 + 1, IMAGE_HEIGHT - $maxWidthRect);
			$this->noise($per, $maxWidthRect, $x1, $y1, $x2, $y2);
		}

	}

    function randomLines($numLines = 100, $maxLength = 20)
    {
	    $halfMaxLength = $maxLength / 2;
        for ($i = 0; $i < $numLines; $i++) {
            $x1 = rand($halfMaxLength, IMAGE_WIDTH - $halfMaxLength);
            $y1 = rand($halfMaxLength, IMAGE_HEIGHT - $halfMaxLength);
            $x2 = rand($x1 - $halfMaxLength, $x1 + $halfMaxLength);
            $y2 = rand($y1 - $halfMaxLength, $y1 + $halfMaxLength);

            /*fb(pow(4, 2), 'Square' );
            fb($x1, 'x1');
            fb($x2, 'x2');*/

            /*if ($len = sqrt(pow($x1 - $x2, 2) + pow($y1 - $y2, 2)) > (float)$maxLength) {
                 fb(array($x1, $x2));
                 if ($y1 - $y2 == 0) {
                     $x2 = $x1 + $maxLength;
                 } else {
                     $ratio = abs(($x1 - $x2)/($y1 - $y2));

                     $x2 = $x1 + $maxLength * $ratio;
                     $y2 = $y1 + $maxLength * (1 - $ratio);
                 }

            } */
            imageline ($this->img , $x1, $y1, $x2, $y2, $this->black );
        }
    }
    function noise($per, $maxWidthRect = 1, $x1Area = 0, $y1Area = 0, $x2Area = IMAGE_WIDTH, $y2Area = IMAGE_HEIGHT) {
        $this->img = imagerotate($this->img, rand(0, 3) * 90, $this->white );
        $noise_dots = round(($x2Area - $x1Area) * ($y2Area - $y1Area) * $per / 100);
        require_once 'Choise.php';
        $choise = new Choise();
        //$_avarage_y = 1;
        echo $choise->getFormula() . '<br/>';
        for ($i = 0; $i < $noise_dots; $i++) {
        	$xLength = rand(0, $maxWidthRect);
        	$yLength = rand(0, $maxWidthRect);
            $x = rand($x1Area,$x2Area - $xLength);
            //$y = rand($y1Area,$y2Area - $yLength);
            $y = $choise->evalFormula(array('$x' => $x));
            if (is_null($y)) continue;
            //echo $x . ' ' . $y . ' ' . ($x + $xLength) . ' ' . ($y + $yLength) . '<br/>';
            $y = $y % ($y2Area - $yLength);
            //$_new_avarage_y = ($_avarage_y + $y) / 2;
            //if ($_new_avarage_y)
            echo $x . ' ' . $y . ' ' . ($x + $xLength) . ' ' . ($y + $yLength) . '<br/>';
            //echo $y . ' | ';         
          imagefilledrectangle($this->img, $x, $y, $x + $xLength, $y + $yLength, $this->black);
	   //   imagesetpixel($this->img, $x, $y, $black);

        }
         //$return = imagefilledrectangle($this->img, 399, 19, 400, 19, $this->black);
          //imagefilledrectangle($this->img, $x, $y, $x + $xLength, $y + $yLength, $this->black);
           //imagefilledrectangle($this->img, $x, $y, $x + $xLength, $y + $yLength, $this->black);
            //imagefilledrectangle($this->img, $x, $y, $x + $xLength, $y + $yLength, $this->black);
        /* 
           399 19 400 19
           181 13 181 13
           130 11 130 12
           61 7 62 7 
         */
    }

    function randomContour($num = 5, $maxPoints = 5)
    {

      for ($i = 0; $i < $num; $i++) {

          $numPoints = rand(0, $maxPoints);
          $points = array();
          for ($j = 0; $j < $numPoints; $j++) {
            $points[] = rand(0, IMAGE_WIDTH);
            $points[] = rand(0, IMAGE_HEIGHT);
            //$points[2] = rand(0, IMAGE_WIDTH);
            //$points[3] = rand(0, IMAGE_HEIGHT);
          }


          $this->img = imagepolygon($this->img, $points, $numPoints, $this->black);
      }


    }
//    static function rectNoise()
}

    //error_reporting(0);
    //header("Content-type: image/png");
   require_once 'Choise.php';
   $choise = new Choise;
   $choise->doChoise(20);
?>

