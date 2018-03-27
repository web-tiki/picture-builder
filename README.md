# Picture builder for joomla!
This is a Joomla! plugin to generate thumbnails and output a picture element for responsive images.  
The function uses parameteres to set:
- the width of the thumbnails
- the heights of the thumbnails
- the breakpoints 
- the thumbnail compression quality.

It relies on the imagick or GD php image libraries.

## Responsive image plugin usage
The plugin can be called in template overrides. Here is an example:

```
echo plgContentPicturebuilder::picturebuilder($imageUrl, $altText, $params);
```
### Function parameters

`$imageUrl` is the original image all the thumbnails should be generated from.  
`$altText` is the alternative text for the image.  
`$params` is an array. It looks like this :


```
$params = array(
    'thumbWidths'  => array( 600, 750, 1200, 1480, 2001),
    'thumbHeights' => array( 600, 750, 1200, 1480, 2001),
    'breakPoints'  => array( 450, 650, 950, 1500),
    'quality'      => 70
);
```

This array defines the sizes of thumbnails, breakpoints and tumbnail compression. It is either an array of sizes as shown above, either an id or string that refers to parameters set in the plugin options in backend.

At this point, the thumb widths and heights must have 5 values and there must be 4 breakpoints. The plugin generates 10 thumbnails :
- 5 thumbnails with the specified sizes
- 5 thumbnails with these sizes multiplied by 1.5 for HD images (to be displayed on screens with a higher pixel ratio)

The thumbHeights can be `null` if you only need to specify the width of the thumbnails and keep the aspect ratio of the original image.

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

## Requirements and warning
- Joomla! >= 3.2
- Imagick must be installed on your server (A fallback to the GD library has been implemented but see "help need" section to make it better)
- This isn't a plug and play plugin yet. You need to know about template overrides to use it and call the apropriate function to build the responsive picture element.
- The plugin generates thumbnails but it can't delete them
- only tested on `.png` and `.jpeg` images but it should work on many more extensions (imagick supports a lot)


## Issues end help needed to:
- Make a fallback to the GD library (This is done but the compression isn't good, files are huge adn no compression for png files yet)
- Redesign the plugin to let the user specify the number of thumbnails and breakpoints
- Find a solution to update the thumbnails if original image changes but keeps the same size (width and height)
- Delete the thumbnails when the original image changes or is deleted
- Why does the parameters need to be nested in a second level of array when the event is called?
- Joomla 4 will imprement the [event package](https://github.com/joomla-framework/event/tree/2.0-dev). Event call should be changed then.
- Errors when there are a lot of images to generate at the same time
-------------

Created by [web-tiki](https://web-tiki.com)

