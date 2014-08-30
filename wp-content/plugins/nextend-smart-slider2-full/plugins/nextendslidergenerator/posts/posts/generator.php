<?php

nextendimportsmartslider2('nextend.smartslider.generator_abstract');

class NextendGeneratorPosts_Posts extends NextendGeneratorAbstract {

    function NextendGeneratorPosts_Posts($data) {
        parent::__construct($data);
        $this->_variables = array(
            'title' => 'Title of the post',
            'image' => 'Featured image of the post',
            'thumbnail' => 'Featured image of the post',
            'description' => 'Content of the post',
            'url' => 'Link to the post',
            'author_name' => 'Name of the author',
            'author_url' => 'Url of the author',
            
            'id' => 'ID of the post',
            'category_name' => 'Post\'s category name',
            'category_link' => 'Post\'s category link'
        );
        
        if(class_exists('acf')){
            $acfs = get_posts( array(
                'posts_per_page' => 1000,
                'post_type' => 'acf'
            ));
            if(count($acfs)){
                foreach($acfs AS $p){
                    $fields = get_post_custom($p->ID);
                    foreach($fields AS $k => $f){
                        if(substr($k, 0, 6) == 'field_'){
                            $field = unserialize($f[0]);
                            if(isset($field['title'])) $this->_variables[$field['name']] = $field['title'];
                        }
                    }
                }
            }
        }
    }

    function getData($number) {
        global $post;
        $tmpPost = $post;
        
        $data = array();
        
        $postscategory = (array)NextendParse::parse($this->_data->get('postscategory'));
        
        $cat = '';
        if(!in_array(0, $postscategory)){
            $cat = implode(',',$postscategory);
        }
        
        $order = NextendParse::parse($this->_data->get('postscategoryorder', 'post_date|*|desc'));
        $args = array(
            'posts_per_page'   => $number,
            'offset'           => 0,
            'category'         => $cat,
            'orderby'          => $order[0],
            'order'            => $order[1],
            'include'          => '',
            'exclude'          => '',
            'meta_key'         => '',
            'meta_value'       => '',
            'post_type'        => 'post',
            'post_mime_type'   => '',
            'post_parent'      => '',
            'post_status'      => 'publish',
            'suppress_filters' => false
        );
  
        $posts_array = get_posts( $args );
        $i = 0;
        foreach ( $posts_array as $mypost ){
            $post = $mypost;
            setup_postdata( $mypost );
            $data[$i] = array();
            
            $data[$i]['id'] = $mypost->ID;
            
            
            $data[$i]['url'] = get_permalink();
            $data[$i]['title'] = apply_filters('the_title', get_the_title());
            $data[$i]['description'] = $data[$i]['content'] = apply_filters('the_content', get_the_content());
            $data[$i]['author_name'] = $data[$i]['author'] = get_the_author();
            $data[$i]['author_url'] = get_the_author_meta('url');
            
            $cat = get_the_category($mypost->ID);
            if(isset($cat[0])){
                $data[$i]['category_name'] = $cat[0]->name;
                $data[$i]['category_link'] = get_category_link( $cat[0]->cat_ID );
            }else{
                $data[$i]['category_name'] = '';
                $data[$i]['category_link'] = '';
            }
            
            $data[$i]['featured_image'] = wp_get_attachment_url( get_post_thumbnail_id($mypost->ID) );
            if(!$data[$i]['featured_image']) $data[$i]['featured_image'] = '';
            
            $data[$i]['thumbnail'] = $data[$i]['image'] = $data[$i]['featured_image'];
            $data[$i]['url_label'] = 'View post';
            
            if(class_exists('acf')){
                $fields = get_fields($mypost->ID);
                if(count($fields)){
                    foreach($fields AS $k => $v){
                        $data[$i][$k] = $v;
                    }
                }
            }
            
            $i++;
        }
        wp_reset_postdata();
        $post = $tmpPost;
        if($post) setup_postdata( $post );
        return $data;
    }
}