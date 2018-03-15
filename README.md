# picture-builder
Joomla! plugin to generate thumbnails and output a picture element for responsive images.
The function uses parameteres to set the widths and heights of the thumbnails, the breakpoins and the compression quality.
It relies on the imagick php image library.

## Function usage

    pictureBuilder($imgUrl, $alt, $params);

$imgUrl is the main image all the thumbnails should be generated from
