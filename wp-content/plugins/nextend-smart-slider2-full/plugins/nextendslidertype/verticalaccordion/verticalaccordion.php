<?php

class plgNextendSliderTypeVerticalAccordion extends NextendPluginBase {
    
    var $_name = 'verticalaccordion';
    
    function onNextendSliderTypeList(&$list){
        $list[$this->_name] = $this->getPath();
    }
    
    static function getPath(){
        return dirname(__FILE__).DIRECTORY_SEPARATOR.'verticalaccordion'.DIRECTORY_SEPARATOR;
    }
}

NextendPlugin::addPlugin('nextendslidertype', 'plgNextendSliderTypeVerticalAccordion');