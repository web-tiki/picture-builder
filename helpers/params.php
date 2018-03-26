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
$pluginParams = json_decode($this->params['thumb_params']);
  
$pluginParamsTemp = [];
foreach ($pluginParams->id as $i => $i) {
  $pluginParamsTemp[$pluginParams->id[$i]] =  array(
    'thumbWidths'  => explode(',',$pluginParams->widths[$i]),
    'thumbHeights' => explode(',',$pluginParams->heights[$i]),
    'breakPoints'  => explode(',',$pluginParams->breakpoints[$i]),
    'quality'      => $pluginParams->quality[$i]
  );
}

if(isset($pluginParamsTemp[$thumbParams])) {
  $thumbParams = $pluginParamsTemp[$thumbParams];
  $IDerror = false;
}


