<?php

nextendimport('nextend.form.element.text');

class NextendElementYoutubeToken extends NextendElementText {

    function fetchElement() {
        $js = NextendJavascript::getInstance();
        $js->addLibraryJsAssetsFile('dojo', 'element.js');
        $js->addLibraryJsFile('dojo', dirname(__FILE__).'/youtubetoken.js');
        $js->addLibraryJs('dojo', '
            new NextendElementYoutubeToken({
              hidden: "' . $this->_id . '",
              link: "nextend-youtube-request-token",
              callback: "nextend-youtube-callback",
              folder: "'.NextendFilesystem::pathToRelativePath(realpath(dirname(__FILE__).'/..')).'/'.'"
            });
        ');
        $html = parent::fetchElement();

        $html.='<a href="#" id="nextend-youtube-request-token" style="line-height: 24px;">'.NextendText::_('Request_token').'</a>';

        $html.='<span id="nextend-youtube-callback" style="line-height: 24px;clear: both;float:left;"></span>';

        return $html;
    }
}
