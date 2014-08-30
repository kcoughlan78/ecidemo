<?php

nextendimport('nextend.form.element.list');

class NextendElementNggalleries extends NextendElementList {

    function fetchElement() {
        global $wpdb;
        
        $galleries = $wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."ngg_gallery ORDER BY name");
        $value = 0; 
        foreach($galleries AS $gallery){
            if($this->_value == $gallery->gid) $value = $gallery->gid;
            $this->_xml->addChild('option', htmlspecialchars($gallery->name))->addAttribute('value', $gallery->gid);
        }
        if(!$value && isset($galleries[0])){
            $this->_form->set($this->_name, $galleries[0]->gid);
        }
        $this->_value = $this->_form->get($this->_name, $this->_default);

        $html = parent::fetchElement();
        return $html;
    }
}
