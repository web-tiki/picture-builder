<?php

/**
 * picture-builder plugin
 * @author		web-tiki
 * @copyright	Copyright (C) 2018 web-tiki
 * @license		Apache License Version 2.0, January 2004 http://www.apache.org/licenses/
 * Website		https://web-tiki.com
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class PlgContentPictureBuilder extends JPlugin {
  
  public function buildPicture($imageParams) {

    // Get the original image parameters
    $imageUrl = $imageParams['url'];
    if (!file_exists($imageUrl)) {
      echo "<script>console.log( 'Cannot find : " . htmlspecialchars($imageUrl) . "' );</script>";
      return false;
    }

    $imageAlt = $imageParams['alt'];
    $thumbParams = $imageParams['thumbParams'];

    // if the parameters aren't set in the event call, 
    // include the parameter helper to generate them from the plugin (backend) parameters
    if(!is_array($thumbParams)) {
      include 'helpers/params.php';
    }

    // Get the original image info and define ratio for HD images
    // TODO maybe better to use the imagick library to get the original image info + size    
    $imageInfo = pathinfo($imageUrl);
    $imageName = $imageInfo['filename'];
    $imageExtension = '.' . $imageInfo['extension'];
    $thumbDir = 'image_thumbs/' . $imageInfo['dirname'];
    $upscaleHDthumbs = 1.5;
    list($imageWidth, $imageHeight) = getimagesize($imageUrl);
    $thumbQuality = $thumbParams['quality'];
    $breakPoints = $thumbParams['breakPoints'];

    // Build the Thumb width array
    $paramWidths = $thumbParams['thumbWidths'];
    $thumbWidths = array();
    foreach ($paramWidths as $paramWidth) {
      array_push($thumbWidths, $paramWidth);
      array_push($thumbWidths, floor($paramWidth * $upscaleHDthumbs));
    }

    // Build the thumb height array
    $paramHeights = $thumbParams['thumbHeights'];
    $thumbHeights = array();
    if ($paramHeights[0]) {
      $crop = true;
      // If thumb heights are specified get the width and height of image from params
      foreach ($paramHeights as $paramHeight) {
        array_push($thumbHeights, $paramHeight);
        array_push($thumbHeights, floor($paramHeight * $upscaleHDthumbs));
      }
    } else {
      $crop = false;
      // If no heights are specified get the width and height of thumbnails from original image aspect ratio
      $imageAspectRatio = $imageHeight/$imageWidth;
      foreach ($thumbWidths as $thumbWidth) {
        $thumbHeight = floor($thumbWidth*$imageAspectRatio);
        array_push($thumbHeights, $thumbHeight);
      }
    }

    // Create the thumb paths array
    $thumbPaths = array();
    foreach ($thumbWidths as $i => $thumbWidth) {      
      $thumbPath = $thumbDir . '/' . $imageName . '-' . $i . '-' . $thumbWidth . 'x' . $thumbHeights[$i] . 'q' . $thumbQuality . $imageExtension;
      array_push($thumbPaths,$thumbPath);
    }
    
    
    // Generate thumbnails if the number 8 doesn't exist
    if(!file_exists($thumbPaths[8])){      
      // Create folders if they don't exixt
      if (!file_exists($thumbDir)) { mkdir($thumbDir, 0777, true); }
      // Check if imagick is installed
      if (extension_loaded('imagick')) {
        include 'helpers/imagick_thumbnail_generator.php';
      } else {
        // TODO : if imagick isn't installed, use GD library to resize and crop thumbnails
        echo 'No imagick here';
        return false;
      }
    }

    // Call the plugin layout to return the picture element
    $path = JPluginHelper::getLayoutPath($this->_type, $this->_name);
    include $path;

 }
}
?>