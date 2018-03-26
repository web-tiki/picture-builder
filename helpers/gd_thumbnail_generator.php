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

use Joomla\Image\Image;

foreach ($thumbWidths as $i => $thumbWidth) {
    
    $gdImage = new Image($imageUrl);
    $thumbHeight = $thumbHeights[$i];
    if($crop) {
        $gdImage->cropResize($thumbWidth,$thumbHeight);
    } else {
        $gdImage->resize($thumbWidth,$thumbHeight);
    }
    if ($imageExtension == '.jpg' || $imageExtension == '.jpeg') {
        echo 'compressed';
        $gdImage->tofile($thumbPaths[$i], IMAGETYPE_JPEG, array('options' => $thumbQuality));
    } else {
        echo 'Not compressed';
       $gdImage->tofile($thumbPaths[$i]);
    }
}
