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