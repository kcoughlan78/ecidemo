<?php

nextendimportsmartslider2('nextend.smartslider.plugin.widget');
nextendimport('nextend.image.color');

class plgNextendSliderWidgetBarColored extends plgNextendSliderWidgetAbstract {

    var $_name = 'colored';

    function onNextendBarList(&$list) {
        $list[$this->_name] = $this->getPath();
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'colored' . DIRECTORY_SEPARATOR;
    }

    static function render($slider, $id, $params) {

        $html = '';
        
        $barcolored = $params->get('barcolored', false);
        if($barcolored && $barcolored != -1){

            $displayclass = self::getDisplayClass($params->get('widgetbardisplay', '0|*|always|*|0|*|0'), true);
        
            list($colorhex, $rgbacss) = NextendColor::colorToCss($params->get('barbackground', '00000080'));

            $css = NextendCss::getInstance();
            $css->enableLess();
            $cssfile = NextendFilesystem::translateToMediaPath(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'colored' . DIRECTORY_SEPARATOR . 'style.less');
            $css->addCssFile(array(
                $cssfile,
                $cssfile,
                array('id' => '~"#' . $id . '"')
            ), $id);

            list($style, $data) = self::getPosition($params->get('barcoloredposition', ''));

            $style.= 'background-color:'.$rgbacss.';';
            
            $width = NextendParse::parse($params->get('barcoloredwidth', '20'));
            if(is_numeric($width)){
                $style.= 'width:'.$width.'%;';
            }else{
                $data.= 'data-sswidth="'.$width.'" ';
            }
            
            /*$height = NextendParse::parse($params->get('barcoloredheight', '100'));
            if(is_numeric($height)){
                $style.= 'height:'.$height.'px;';
            }else{
                $data.= 'data-ssheight="'.$height.'" ';
            }
            
            $style .= 'font-size: '.intval($slider->_sliderParams->get('globalfontsize', '12')).'px;';
	    */
	    
	    $style .= 'padding: '.NextendParse::parse($params->get('barcoloredpadding', '0')).'% 0;';
	    
	    $borderradius = NextendParse::parse($params->get('barcoloredborderradius', '0|*|0|*|0|*|0'));
	    
	    $style .= '-webkit-border-radius: '.$borderradius[0].'px '.$borderradius[1].'px '.$borderradius[2].'px '.$borderradius[3].'px;';
	    $style .= '-moz-border-radius: '.$borderradius[0].'px '.$borderradius[1].'px '.$borderradius[2].'px '.$borderradius[3].'px;';
	    $style .= 'border-radius: '.$borderradius[0].'px '.$borderradius[1].'px '.$borderradius[2].'px '.$borderradius[3].'px;';
	   
	    
            $info = pathinfo($barcolored);
            $class = 'nextend-bar nextend-bar-c nextend-bar-c-'.basename($barcolored, '.'.$info['extension']);
            $html.= '<div class="'.$displayclass.$class.'" style="'.$style.'" '.$data.'>';

            for ($i = 0; $i < count($slider->_slides); $i++) {
                $html.= '<div class="nextend-bar-slide '.($slider->_slides[$i]['first'] ? ' active' : '').'">';
                $html.= '<h6 class="'.$params->get('barcoloredtitlefont','').'">'.$slider->_slides[$i]['title'].'</h6>';
                if($slider->_slides[$i]['description']){
                  $html.= '<p class="'.$params->get('barcoloreddescriptionfont','').'">'.$slider->_slides[$i]['description'].'</p>';
                }
                $html.= '<div style="clear: both;"></div></div>';
            }

            $html.= '</div>';
        }

        return $html;
    }

}
NextendPlugin::addPlugin('nextendsliderwidgetbar', 'plgNextendSliderWidgetBarcolored');