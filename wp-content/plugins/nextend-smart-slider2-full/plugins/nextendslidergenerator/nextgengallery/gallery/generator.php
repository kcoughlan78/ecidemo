<?php

nextendimportsmartslider2('nextend.smartslider.generator_abstract');

class NextendGeneratorNextgenGallery_Gallery extends NextendGeneratorAbstract {

    function NextendGeneratorNextgenGallery_Gallery($data) {
        parent::__construct($data);
        $this->_variables = array(
            'image' => 'Url to the image',
            'thumbnail' => 'Url to the thumbnail',
            'alt_text' => 'Alternative text to the image'
        );
    }

    function getData($number) {
        global $wpdb;

        $data = array();
        
        $pictures = $wpdb->get_results("SELECT a.*, b.path FROM ".$wpdb->base_prefix."ngg_pictures AS a LEFT JOIN ".$wpdb->base_prefix."ngg_gallery AS b ON a.galleryid = b.gid WHERE a.galleryid = '".intval($this->_data->get('nggsourcegallery', 0))."'");

        $i = 0;
        if(class_exists('nggGallery') && !class_exists('C_Component_Registry')){ // legacy
            
            foreach( $pictures as $p ) {
                $data[$i]['alt_text'] = $p->alttext;
                $data[$i]['image'] = nggGallery::get_image_url($p->pid, $p->path, $p->filename);
                $data[$i]['thumbnail'] = nggGallery::get_thumbnail_url($p->pid, $p->path, $p->filename);
                
                $i++;
            }
        }else{
        
            $storage = C_Component_Registry::get_instance()->get_utility('I_Gallery_Storage');
            
            foreach( $pictures as $p ) {
                $data[$i]['alt_text'] = $p->alttext;
                $data[$i]['image'] = $storage->get_image_url($p);
                $data[$i]['thumbnail'] = $storage->get_thumbnail_url($p);
                
                $i++;
            }
        }
        return $data;
    }
}