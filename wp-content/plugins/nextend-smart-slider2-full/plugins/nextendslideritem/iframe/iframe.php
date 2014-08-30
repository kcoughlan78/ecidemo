<?php

nextendimportsmartslider2('nextend.smartslider.plugin.slideritem');

class plgNextendSliderItemiframe extends plgNextendSliderItemAbstract {
    
    var $_identifier = 'iframe';
    
    var $_title = 'iframe';
    
    function getTemplate(){
        return '<iframe frameborder="0" width="{width}" height="{height}" src="{url}" scrolling="{scroll}"></iframe>';
    }
    
    function _render($data, $id, $sliderid, $items){
    
        $size = (array)NextendParse::parse($data->get('size', ''));
        if(!isset($size[0])) $size[0] = '100%';
        if(!isset($size[1])) $size[1] = '100%';
        
        return '<iframe frameborder="0" width="'.$size[0].'" height="'.$size[0].'" src="'.$data->get('url', '').'" scrolling="'.$data->get('scroll', '').'"></iframe>';
    }
    
    function _renderAdmin($data, $id, $sliderid, $items){
        return $this->_render($data, $id, $sliderid, $items);
    }
    
    function getValues(){
        return array(
            'url' => 'about:blank',
            'size' => '100%|*|100%',
            'scroll' => 'yes'
        );
    }
    
    function getPath(){
        return dirname(__FILE__).DIRECTORY_SEPARATOR.$this->_identifier.DIRECTORY_SEPARATOR;
    } 
}

NextendPlugin::addPlugin('nextendslideritem', 'plgNextendSliderItemiframe');