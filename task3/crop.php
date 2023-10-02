<?php

$image = imagecreatefromjpeg('img.jpg');
$filename = 'cropped_img.jpg';

$thumb_width = 200;
$thumb_height = 100;

$width = imagesx($image);
$height = imagesy($image);

$original_aspect = $width / $height;
$thumb_aspect = $thumb_width / $thumb_height;

if ( $original_aspect >= $thumb_aspect )
{
    $new_height = $thumb_height;
    $new_width = $width / ($height / $thumb_height);
}
else
{
    $new_width = $thumb_width;
    $new_height = $height / ($width / $thumb_width);
}

$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

imagecopyresampled($thumb,
    $image,
    0 - ($new_width - $thumb_width) / 2,
    0 - ($new_height - $thumb_height) / 2,
    0, 0,
    $new_width, $new_height,
    $width, $height);
imagejpeg($thumb, $filename);

?>

<img src="cropped_img.jpg" alt="Баннер">
