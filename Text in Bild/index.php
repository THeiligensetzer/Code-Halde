<?php
file_put_contents('GD.log','Programm Start'."\n".PHP_EOL, FILE_APPEND);

$text = filter_input(INPUT_GET,'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$strings = explode(' ', $text);
$imagePre = imagecreatefrompng("Proto.png");
$image = imagescale($imagePre, 512, 512);
imagedestroy($imagePre);

file_put_contents('GD.log', 'Strings: '.count($strings).PHP_EOL, FILE_APPEND);

$s = 0;
$array = [$strings[0]];
$array2 = $array;
while(count($strings) > $s){
	$ts = implode(' ', $array2);
	if (strlen($ts) > 30){
		if (isset($strings[$s])){
			$strings[$s] = "\n" . $strings[$s]; 
		}
		else{
			$strings[$s -1] .= "\n";
		}
		//break;
		if (!isset($strings[$s])){
			break;
		}
		$array = [$strings[$s]];
		$array2 = $array;
	}
	else {
		$s += 1;
		$array = $array2;
		if (!isset($strings[$s])){
			break;
		}
		array_push($array2, $strings[$s]);
		file_put_contents('GD.log', 'Umbruch: '.$s.' ('.$strings[$s].') '.$ts.PHP_EOL, FILE_APPEND);
	}
}
$text = implode(' ', $strings);
file_put_contents('GD.log', 'Text: '.$text.PHP_EOL, FILE_APPEND);

$color = imagecolorallocate($image, 255, 220, 20);
$font = 'arial.ttf';
$size = 24;
$angle = 0;
$x = 40;
$y = 60;
$linewidth = imagettfbbox($size, $angle, $font, $text);
imagefttext($image, $size, $angle, $x, $y, $color, $font, $text);

file_put_contents('GD.log','B-T: Bild: '.imagesx($image).' Text: '.strlen($text)."\n".PHP_EOL, FILE_APPEND);

header("Content-Type: image/png");
imagepng($image);
imagedestroy($image);