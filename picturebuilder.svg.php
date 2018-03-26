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
    $imageInfo = pathinfo($imageUrl);
    $imageName = $imageInfo['filename'];
    $imageExtension = '.' . $imageInfo['extension'];
    $thumbDir = 'image_thumbs/' . $imageInfo['dirname'];
    $upscale_HD_images = 1.5;
    $thumbQuality = $thumbParams['quality'];
    $breakPoints = $thumbParams['breakPoints'];

    // Build the Thumb width array
    $paramWidths = $PicturebuilderParams['thumbWidths'];
    $thumbWidths = array();
    foreach ($paramWidths as $i => $paramWidth) {
      array_push($thumbWidths, $paramWidth);
      array_push($thumbWidths, floor($paramWidth * $upscale_HD_images));
    }
















    // Call the plugin layout to return the picture element
    $path = JPluginHelper::getLayoutPath($this->_type, $this->_name);

 }

  


















  public static function picturebuilder($imgUrl, $imageAlt, $customParameters) {
    
    

    

   
 
    // Build the thumb height array
    $paramHeights = $PicturebuilderParams['thumbHeight'];
    $thumbHeights = array();
    list($XLwidth, $XLheight) = getimagesize($imgUrl);
    if ($paramHeights) {
      $crop = true;
      // If height is specified get the width and height of image from params
      foreach ($paramHeights as $paramHeight) {
        array_push($thumbHeights, $paramHeight);
        array_push($thumbHeights, floor($paramHeight * $upscale_HD_images));
      }
    } else {
      $crop = false;
      // If no height is specified get the width and height of image form original file
      foreach ($thumbWidths as $thumbWidth) {
        $thumbHeight = floor($thumbWidth*$XLheight/$XLwidth);
        array_push($thumbHeights, $thumbHeight);
      }
    }
    // Create the thumb paths array
    $thumbPaths = array();
    foreach ($thumbWidths as $i => $thumbWidth) {
      $thumbHeight = $thumbHeights[$i];
      $thumbPath = $thumbDir . '/' . $imgName . '-' . $i . '-' . $thumbWidth . 'x' . $thumbHeight . 'q' . $thumbQuality . $imgExtension;
      array_push($thumbPaths,$thumbPath);
    }
    // Generate thumbnails if the number 8 doesn't exist
    if(!file_exists($thumbPaths[8])){
      // Create folders if they don't exixt
      if (!file_exists($thumbDir)) {
        mkdir($thumbDir, 0777, true);
      }
      // Check if imagick is installed
      if (extension_loaded('imagick')) {
        foreach ($thumbWidths as $i => $thumbWidth) {
          $imagick = new imagick($imgUrl);
          $thumbHeight = $thumbHeights[$i];
          if($crop) {
            $imagick->cropThumbnailImage($thumbWidth,$thumbHeight);
          } else {
            $imagick->resizeImage($thumbWidth,$thumbHeight,imagick::FILTER_LANCZOS, 1, true);
          }
          $imagick->setImageCompressionQuality($thumbQuality);
          $imagick->writeImage($thumbPaths[$i]);
          $imagick->clear();
          $imagick->destroy();
        }
      } else {
        // TODO : if imagick isn't installed, use GD library to resize and crop thumbnails
        echo 'No imagick here';
      }
    }
    ?>
    <picture>
      <source  srcset="<?php echo $thumbPaths[9] . ' 2x,' . $thumbPaths[8]; ?>"  media="(min-width: <?php echo $breakPoints[3]; ?>px)"/>
      <source  srcset="<?php echo $thumbPaths[7] . ' 2x,' . $thumbPaths[6]; ?>"  media="(min-width: <?php echo $breakPoints[2]; ?>px) and (max-width: <?php echo $breakPoints[3] - 1; ?>px)"/>
      <source  srcset="<?php echo $thumbPaths[5] . ' 2x,' . $thumbPaths[4]; ?>"  media="(min-width: <?php echo $breakPoints[1]; ?>px) and (max-width: <?php echo $breakPoints[2] - 1; ?>px)"/>
      <source  srcset="<?php echo $thumbPaths[3] . ' 2x,' . $thumbPaths[2]; ?>"  media="(min-width: <?php echo $breakPoints[0]; ?>px) and (max-width: <?php echo $breakPoints[1] - 1; ?>px)"/>
      <source  srcset="<?php echo $thumbPaths[1] . ' 2x,' . $thumbPaths[0]; ?>"  media="(max-width: <?php echo $breakPoints[0] - 1; ?>px)"/>
      <img src="<?php echo $thumbPaths[8]; ?>"
        srcset="<?php echo $thumbPaths[9] . ' 2x,' . $thumbPaths[8]; ?>"
        alt="<?php echo $imageAlt; ?>"
        width="<?php echo $thumbWidths[8]; ?>"
        height="<?php echo $thumbHeights[8]; ?>"
      />
    </picture>
    <?php
  }
}
?>


















<?php

 

public static function picturebuilder($imgUrl, $imageAlt, $customParameters) {
    
    

    

   
  // Build the Thumb width array
  $paramWidths = $PicturebuilderParams['thumbWidth'];
  $thumbWidths = array();
  foreach ($paramWidths as $i => $paramWidth) {
    array_push($thumbWidths, $paramWidth);
    array_push($thumbWidths, floor($paramWidth * $upscale_HD_images));
  }
  // Build the thumb height array
  $paramHeights = $PicturebuilderParams['thumbHeight'];
  $thumbHeights = array();
  list($XLwidth, $XLheight) = getimagesize($imgUrl);
  if ($paramHeights) {
    $crop = true;
    // If height is specified get the width and height of image from params
    foreach ($paramHeights as $paramHeight) {
      array_push($thumbHeights, $paramHeight);
      array_push($thumbHeights, floor($paramHeight * $upscale_HD_images));
    }
  } else {
    $crop = false;
    // If no height is specified get the width and height of image form original file
    foreach ($thumbWidths as $thumbWidth) {
      $thumbHeight = floor($thumbWidth*$XLheight/$XLwidth);
      array_push($thumbHeights, $thumbHeight);
    }
  }
  // Create the thumb paths array
  $thumbPaths = array();
  foreach ($thumbWidths as $i => $thumbWidth) {
    $thumbHeight = $thumbHeights[$i];
    $thumbPath = $thumbDir . '/' . $imgName . '-' . $i . '-' . $thumbWidth . 'x' . $thumbHeight . 'q' . $thumbQuality . $imgExtension;
    array_push($thumbPaths,$thumbPath);
  }
  // Generate thumbnails if the number 8 doesn't exist
  if(!file_exists($thumbPaths[8])){
    // Create folders if they don't exixt
    if (!file_exists($thumbDir)) {
      mkdir($thumbDir, 0777, true);
    }
    // Check if imagick is installed
    if (extension_loaded('imagick')) {
      foreach ($thumbWidths as $i => $thumbWidth) {
        $imagick = new imagick($imgUrl);
        $thumbHeight = $thumbHeights[$i];
        if($crop) {
          $imagick->cropThumbnailImage($thumbWidth,$thumbHeight);
        } else {
          $imagick->resizeImage($thumbWidth,$thumbHeight,imagick::FILTER_LANCZOS, 1, true);
        }
        $imagick->setImageCompressionQuality($thumbQuality);
        $imagick->writeImage($thumbPaths[$i]);
        $imagick->clear();
        $imagick->destroy();
      }
    } else {
      // TODO : if imagick isn't installed, use GD library to resize and crop thumbnails
      echo 'No imagick here';
    }
  }
  ?>
  <picture>
    <source  srcset="<?php echo $thumbPaths[9] . ' 2x,' . $thumbPaths[8]; ?>"  media="(min-width: <?php echo $breakPoints[3]; ?>px)"/>
    <source  srcset="<?php echo $thumbPaths[7] . ' 2x,' . $thumbPaths[6]; ?>"  media="(min-width: <?php echo $breakPoints[2]; ?>px) and (max-width: <?php echo $breakPoints[3] - 1; ?>px)"/>
    <source  srcset="<?php echo $thumbPaths[5] . ' 2x,' . $thumbPaths[4]; ?>"  media="(min-width: <?php echo $breakPoints[1]; ?>px) and (max-width: <?php echo $breakPoints[2] - 1; ?>px)"/>
    <source  srcset="<?php echo $thumbPaths[3] . ' 2x,' . $thumbPaths[2]; ?>"  media="(min-width: <?php echo $breakPoints[0]; ?>px) and (max-width: <?php echo $breakPoints[1] - 1; ?>px)"/>
    <source  srcset="<?php echo $thumbPaths[1] . ' 2x,' . $thumbPaths[0]; ?>"  media="(max-width: <?php echo $breakPoints[0] - 1; ?>px)"/>
    <img src="<?php echo $thumbPaths[8]; ?>"
      srcset="<?php echo $thumbPaths[9] . ' 2x,' . $thumbPaths[8]; ?>"
      alt="<?php echo $imageAlt; ?>"
      width="<?php echo $thumbWidths[8]; ?>"
      height="<?php echo $thumbHeights[8]; ?>"
    />
  </picture>
  <?php
}
}
?>
