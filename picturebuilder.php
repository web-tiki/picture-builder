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

class plgContentPicturebuilder extends JPlugin {

  public static function picturebuilder($imgUrl, $imageAlt, $customParameters) {
    // check if the original image exists
    if (!file_exists($imgUrl)) {
      echo "<script>console.log( 'Cannot find : " . htmlspecialchars($imgUrl) . "' );</script>";
      return false; hgsdh
    }

    // if new paramters are passed in the function use those. Otherwise use the ones defined in the backend (see plugin picturebuilder options).
    if ($customParameters) {
      // Set the thumb sizes
      if ($customParameters == 1) {
        $PicturebuilderParams = array(
          'thumbWidth'  => array( 600,    750,     1200,    1480,    2001),
          'thumbHeight' => null,
          'breakPoints' => array(     450,     650,    950,    1500),
          'quality'     => 70
        );
      } elseif ($customParameters == 2) {
        $PicturebuilderParams = array(
          'thumbWidth'  => array( 600,    750,     200,    400,    500),
          'thumbHeight' => array(  160,    250,    400,     800,     1000),
          'breakPoints' => array(     500,    750,    1000,     1630),
          'quality'     => 70
        );
      }
    } else {
      // Get the parameters from the plugin picturebuilder (see backend).
      $plgPicturebuilder = JPluginHelper::getPlugin('content', 'picturebuilder');
      $PicturebuilderParams = new JRegistry($plgPicturebuilder->params);
      // build the array to use the plugin parameters
      $PicturebuilderParams = array(
        'thumbWidth'  => array(
          $PicturebuilderParams['thumb_XS'],
          $PicturebuilderParams['thumb_S'],
          $PicturebuilderParams['thumb_M'],
          $PicturebuilderParams['thumb_L'],
          $PicturebuilderParams['thumb_XL']
        ),
        'thumbHeight' => null,
        'breakPoints' => array(
          $PicturebuilderParams['breakpont_1'],
          $PicturebuilderParams['breakpont_2'],
          $PicturebuilderParams['breakpont_3'],
          $PicturebuilderParams['breakpont_4']
        ),
        'quality' => $PicturebuilderParams['quality']
      );
    }


    // Get the original image info and define ratio for HD images
    $imgInfo = pathinfo($imgUrl);
    $imgName = $imgInfo['filename'];
    $imgExtension = '.' . $imgInfo['extension'];
    $thumbDir = 'image_thumbs/' . $imgInfo['dirname'];
    $upscale_HD_images = 1.5;
    $thumbQuality = $PicturebuilderParams['quality'];
    $breakPoints = $PicturebuilderParams['breakPoints'];
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
