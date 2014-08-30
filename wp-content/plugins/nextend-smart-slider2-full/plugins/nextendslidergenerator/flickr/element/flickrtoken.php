<?php

nextendimport('nextend.form.element.text');

class NextendElementFlickrToken extends NextendElementText {

    function fetchElement() {
        $js = NextendJavascript::getInstance();
        $js->addLibraryJsAssetsFile('dojo', 'element.js');
        $js->addLibraryJsFile('dojo', dirname(__FILE__).'/flickrtoken.js');
        $js->addLibraryJs('dojo', '
            new NextendElementFlickrToken({
              hidden: "' . $this->_id . '",
              link: "nextend-flickr-request-token",
              callback: "nextend-flickr-callback",
              folder: "'.NextendFilesystem::pathToRelativePath(realpath(dirname(__FILE__).'/..')).'/'.'"
            });
        ');
        $html = parent::fetchElement();

        $html.='<a href="#" id="nextend-flickr-request-token" style="line-height: 24px;">'.NextendText::_('Request_token').'</a>';

        $html.='<span id="nextend-flickr-callback" style="line-height: 24px;clear: both;float:left;"></span>';

        return $html;
    }
}
