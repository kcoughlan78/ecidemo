<?php
nextendimport('nextend.image.color');

$params = $this->_sliderParams;

$width = intval($context['width']);
$height = intval($context['height']);

$context['bgsize'] = NextendParse::parse($params->get('fullpagebackgroundimagesize', 'auto'));

$context['inner1height'] = $height . 'px';

$context['canvaswidth'] = $width . "px";
$context['canvasheight'] = $height . "px";

$context['margin'] = '0px 0px 0px 0px ';
