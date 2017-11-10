<?
//  Create source image and dimensions
$src_img = imagecreatefromjpeg($_GET['image']);
$srcsize = getimagesize($_GET['image']);
//original size was 60. Resized to get a better fit on list_members.php 08/23/08
$dest_x = 70;
$dest_y = (70 / $srcsize[0]) * $srcsize[1];
$dst_img = imagecreatetruecolor($dest_x, $dest_y);
 
//  Resize image
imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dest_x, $dest_y, $srcsize[0], $srcsize[1]);
 
//  Output image
header("content-type: image/jpeg");
imagejpeg($dst_img);
 
//  Destroy images
imagedestroy($src_img);
imagedestroy($dst_img);
?>