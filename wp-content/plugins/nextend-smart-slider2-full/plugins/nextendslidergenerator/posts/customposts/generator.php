<?php

nextendimportsmartslider2('nextend.smartslider.generator_abstract');

class NextendGeneratorPosts_Customposts extends NextendGeneratorAbstract {

    function NextendGeneratorPosts_Customposts($data) {
        parent::__construct($data);

        preg_match('/.*?__(.*?)$/', $data->get('source'), $out);
        $this->posttype = $out[1];

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

        if (class_exists('acf')) {
            $acfs = get_posts(array(
                'posts_per_page' => 1000,
                'post_type' => 'acf'
            ));
            if (count($acfs)) {
                foreach ($acfs AS $p) {
                    $fields = get_post_custom($p->ID);
                    foreach ($fields AS $k => $f) {
                        if (substr($k, 0, 6) == 'field_') {
                            $field = unserialize($f[0]);
                            if (isset($field['title']))
                                $this->_variables[$field['name']] = $field['title'];
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

        $order = NextendParse::parse($this->_data->get('postsorder', 'post_date|*|desc'));
        $args = array(
            'posts_per_page' => $number,
            'offset' => 0,
            'orderby' => $order[0],
            'order' => $order[1],
            'include' => '',
            'exclude' => '',
            'meta_key' => '',
            'meta_value' => '',
            'post_type' => $this->posttype,
            'post_mime_type' => '',
            'post_parent' => '',
            'post_status' => 'publish',
            'suppress_filters' => false
        );

        $posts_array = get_posts($args);
        $i = 0;
        foreach ($posts_array as $mypost) {
            $post = $mypost;
            setup_postdata($mypost);
            $data[$i] = array();

            $data[$i]['id'] = $mypost->ID;


            $data[$i]['url'] = get_permalink();
            $data[$i]['title'] = apply_filters('the_title', get_the_title());
            $data[$i]['description'] = $data[$i]['content'] = apply_filters('the_content', get_the_content());
            $data[$i]['author_name'] = $data[$i]['author'] = get_the_author();
            $data[$i]['author_url'] = get_the_author_meta('url');

            $data[$i]['featured_image'] = wp_get_attachment_url(get_post_thumbnail_id($mypost->ID));
            if (!$data[$i]['featured_image'])
                $data[$i]['featured_image'] = '';

            $data[$i]['thumbnail'] = $data[$i]['image'] = $data[$i]['featured_image'];
            $data[$i]['url_label'] = 'View';

            $customs = get_post_custom($mypost->ID);
            if ($customs && count($customs)) {
                foreach ($customs AS $k => $v) {
                    if (is_array($v)) {
                        if (isset($v[0]))
                            $v = $v[0];
                        else
                            continue;
                    }
                    $data[$i][$k] = $v;
                }
            }

            if (class_exists('acf')) {
                $fields = get_fields($mypost->ID);
                if (count($fields) && $fields) {
                    foreach ($fields AS $k => $v) {
                        $data[$i][$k] = $v;
                    }
                }
            }

            $i++;
        }
        wp_reset_postdata();
        $post = $tmpPost;
        if ($post)
            setup_postdata($post);

        return $data;
    }

}
