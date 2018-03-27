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


// Build the array to use the plugin parameters set in backend the parameters to use are defined by the parameter class set in the plugin backend
$pluginParamsTemp1 = json_decode($pluginParams['thumb_params']);

$pluginParamsTemp = [];
foreach ($pluginParamsTemp1->id as $i => $i) {
  $pluginParamsTemp[$pluginParamsTemp1->id[$i]] =  array(
    'thumbWidths'  => explode(',',$pluginParamsTemp1->widths[$i]),
    'thumbHeights' => explode(',',$pluginParamsTemp1->heights[$i]),
    'breakPoints'  => explode(',',$pluginParamsTemp1->breakpoints[$i]),
    'quality'      => $pluginParamsTemp1->quality[$i]
  );
}

if(isset($pluginParamsTemp[$thumbParams])) {
  $thumbParams = $pluginParamsTemp[$thumbParams];
  $IDerror = false;
}


