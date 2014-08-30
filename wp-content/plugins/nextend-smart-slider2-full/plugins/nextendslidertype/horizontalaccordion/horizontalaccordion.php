<?php

class plgNextendSliderTypeHorizontalAccordion extends NextendPluginBase{
    
    var $_name = 'horizontalaccordion';
    
    function onNextendSliderTypeList(&$list){
        $list[$this->_name] = $this->getPath();
    }
    
    static function getPath(){
        return dirname(__FILE__).DIRECTORY_SEPARATOR.'horizontalaccordion'.DIRECTORY_SEPARATOR;
    }
}

NextendPlugin::addPlugin('nextendslidertype', 'plgNextendSliderTypeHorizontalAccordion');