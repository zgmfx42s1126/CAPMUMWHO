<?php
// Set the content type to PNG
header("Content-type: image/png");

// Create a blank image
$image = imagecreatetruecolor(200, 100);

// Allocate a red color
$bg = imagecolorallocate($image, 255, 0, 0);
imagefilledrectangle($image, 0, 0, 200, 100, $bg);

// Output the image
imagepng($image);

// Free up memory
imagedestroy($image);
?>
