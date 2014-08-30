<?php

nextendimportsmartslider2('nextend.smartslider.plugin.widget');

class plgNextendSliderWidgetHTMLHTML extends plgNextendSliderWidgetAbstract {

    var $_name = 'html';

    function onNextendhtmlList(&$list) {
        $list[$this->_name] = $this->getPath();
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR;
    }

    static function render($slider, $id, $params) {

        $html = '';
        
        $displayclass = self::getDisplayClass($params->get('widgethtmldisplay', '0|*|always|*|0|*|0'), true);
    
        list($style, $data) = self::getPosition($params->get('htmlposition', ''));
        
        $style.= 'z-index: 10;';

        $html.= '<div class="nextend-widget-html ' . $displayclass.'" style="'.$style.'" '.$data.'>'.$params->get('widgethtmlcontent', '').'</div>';

        return $html;
    }
}

NextendPlugin::addPlugin('nextendsliderwidgethtml', 'plgNextendSliderWidgetHTMLHTML');