# Picture builder for joomla!
This is a Joomla! plugin to generate thumbnails and output a picture element for responsive images.  
The function uses parameteres to set the widths and heights of the thumbnails, the breakpoins and the compression quality.
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
The thumbHeight can be `null` if you only need to specify the width of the thumbnails and keep the aspect ratio of the originla image.

