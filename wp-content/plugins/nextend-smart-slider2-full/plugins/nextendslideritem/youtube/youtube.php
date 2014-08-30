<?php

nextendimportsmartslider2('nextend.smartslider.plugin.slideritem');

class plgNextendSliderItemYoutube extends plgNextendSliderItemAbstract {
    
    var $_identifier = 'youtube';
    
    var $_title = 'YouTube';
    
    function getTemplate(){
    
        return '<img alt="" src="//img.youtube.com/vi/{code}/{defaultimage}.jpg" style="width: 100%; height: 100%;" />';
    }
    
    function _render($data, $id, $sliderid, $items){
    
        $youtubeurl = $this->parseYoutubeUrl($data->get('youtubeurl', ''));
        
        $js = NextendJavascript::getInstance();
        $js->addLibraryJsFile('jquery', dirname(__FILE__) . '/youtube/youtube.js');   
            
        return '<div id="'.$id.'" data-youtubecode="'.$youtubeurl.'" data-autoplay="'.$data->get('autoplay').'" data-related="'.$data->get('related').'" data-vq="'.$data->get('vq').'" data-theme="'.$data->get('theme').'" style="position: absolute; top:0; left: 0; display: none; width: 100%; height: 100%;"></div>
    <script type="text/javascript">
        njQuery(document).ready(function () {
            ssCreateYouTubePlayer("'.$id.'", "'.$sliderid.'");
        });
    </script>';
    }
    
    function _renderAdmin($data, $id, $sliderid, $items){
        $youtubeurl = $this->parseYoutubeUrl($data->get('youtubeurl', ''));
        return '<img alt="" src="//img.youtube.com/vi/'.$youtubeurl.'/'.$data->get('defaultimage').'.jpg" style="width: 100%; height: 100%;" />';
    }
    
    function parseYoutubeUrl($youtubeurl){
        preg_match('/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/', $youtubeurl, $matches);
        if ($matches && isset($matches[7]) && strlen($matches[7]) == 11){ 
            return $matches[7];
        }
        return $youtubeurl;
    }
    
    function getValues(){
        return array(
            'code' => 'qesNtYIBDfs',
            'youtubeurl' => 'http://www.youtube.com/watch?v=qesNtYIBDfs',
            'autoplay' => 0,
            'defaultimage' => 'maxresdefault',
            'related' => '1',
            'vq' => 'default'
        );
    }
    
    function getPath(){
        return dirname(__FILE__).DIRECTORY_SEPARATOR.$this->_identifier.DIRECTORY_SEPARATOR;
    } 
    
    function onNextendSliderRender(&$slider, $id){
        preg_match_all('/<!\-\-smartslideryoutubeitem,([a-zA-Z0-9\-]*?),([a-zA-Z0-9\-_]*?)\-\->/', $slider, $out, PREG_SET_ORDER);
        if(count($out)){
            $js = NextendJavascript::getInstance();
            $js->addLibraryJsFile('jquery', dirname(__FILE__) . '/youtube/youtube.js');            
            
            foreach($out AS $o){
                $slider .="<script type='text/javascript'>
                          njQuery(document).ready(function () {
                              ssCreateYouTubePlayer('".$o[1].$o[2]."', '".$id."');
                          });
                      </script>";
            }
        }
    }
}

NextendPlugin::addPlugin('nextendslideritem', 'plgNextendSliderItemYoutube');