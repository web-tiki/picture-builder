# Picture builder for joomla!
This is a Joomla! plugin to generate thumbnails and output a picture element for responsive images.  
The function uses parameteres to set:
- the width of the thumbnails
- the heights of the thumbnails
- the breakpoints 
- the thumbnail compression quality.
It relies on the imagick php image library.

## Function usage

```
pictureBuilder($imgUrl, $alt, $params);
```

`$imgUrl` is the main image all the thumbnails should be generated from  
`$alt` is the alternative texte for the image  
`$params` is an array of parameters that define the sizes of the thumbnails, the breakpoints and the compression quality of the images. It looks like this :

```
$params = array(
    'thumbWidth'  => array( 500, 750, 1000, 1600, 2000),
    'thumbHeight' => array( 250, 375, 500, 800, 1000),
    'breakPoints' => array( 500, 750, 1000, 1600),
    'quality'     => 60
);
```
The thumbHeight can be `null` if you only need to specify the width of the thumbnails and keep the aspect ratio of the original image.
Default parameters can be set in the backend.

## Picture element output
The plugin outputs a picture element for **responsive images**. 
This is an example HTML output :

```
<picture>
    <source srcset="image-9-3001x2002q70.jpg 2x,image-8-2001x1335q70.jpg" media="(min-width: 1500px)">
    <source srcset="image-7-2220x1481q70.jpg 2x,image-6-1480x987q70.jpg" media="(min-width: 950px) and (max-width: 1499px)">
    <source srcset="image-5-1800x1201q70.jpg 2x,image-4-1200x800q70.jpg" media="(min-width: 650px) and (max-width: 949px)">
    <source srcset="image-3-1125x750q70.jpg 2x,image-2-750x500q70.jpg" media="(min-width: 450px) and (max-width: 649px)">
    <source srcset="image-1-900x600q70.jpg 2x,image-0-600x400q70.jpg" media="(max-width: 449px)">
    <img src="image-8-2001x1335q70.jpg" srcset="image-9-3001x2002q70.jpg 2x,image-8-2001x1335q70.jpg" alt="This is a test image" width="2001" height="1335">
</picture>
```
-------------

Created by [web-tiki](https://web-tiki.com)

