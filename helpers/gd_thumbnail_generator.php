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

foreach ($thumbWidths as $i => $thumbWidth) {

    echo 'GD will be triggered here';
    $gdimage = new Image();

/*

    $imagick = new imagick($imageUrl);
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

*/
}
