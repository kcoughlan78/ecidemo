<?php

nextendimport('nextend.form.element.text');

class NextendElementInstagramToken extends NextendElementText {

    function fetchElement() {
        $js = NextendJavascript::getInstance();
        $js->addLibraryJsAssetsFile('dojo', 'element.js');
        $js->addLibraryJsFile('dojo', dirname(__FILE__).'/instagramtoken.js');
        $js->addLibraryJs('dojo', '
            new NextendElementInstagramToken({
              hidden: "' . $this->_id . '",
              link: "nextend-instagram-request-token",
              callback: "nextend-instagram-callback",
              folder: "'.NextendFilesystem::pathToRelativePath(realpath(dirname(__FILE__).'/..')).'/'.'"
            });
        ');
        $html = parent::fetchElement();

        $html.='<a href="#" id="nextend-instagram-request-token" style="line-height: 24px;">'.NextendText::_('Request_token').'</a>';

        $html.='<span id="nextend-instagram-callback" style="line-height: 24px;clear: both;float:left;"></span>';

        return $html;
    }
}
