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

// if new paramters are passed in the function use those. Otherwise use the ones defined in the backend (see plugin picturebuilder options).
if ($customParameters) {
    // Set the thumb sizes
    if ($customParameters == 1) {
      // With adaptive height keeping the aspect original ratio of image
      $PicturebuilderParams = array(
        'thumbWidth'  => array( 600,    750,     1200,    1480,    2001),
        'thumbHeight' => null,
        'breakPoints' => array(     450,     650,    950,    1500),
        'quality'     => 70
      );
    } elseif ($customParameters == 2) {
      // crop image to the defined width and height
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
/*
  $plgPicturebuilder = JPluginHelper::getPlugin('content', 'picturebuilder');
  echo '<pre>'; print_r($plgPicturebuilder); echo '</pre>';
*/