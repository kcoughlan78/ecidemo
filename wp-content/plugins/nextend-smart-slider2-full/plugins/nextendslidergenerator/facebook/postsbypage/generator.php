<?php

nextendimportsmartslider2('nextend.smartslider.generator_abstract');

class NextendGeneratorFacebook_Postsbypage extends NextendGeneratorAbstract {

    function NextendGeneratorFacebook_Postsbypage($data) {
        parent::__construct($data);
        $this->_variables = array(
            'link' => NextendText::_('Url_of_post'),
            'description' => NextendText::_('Description_of_the_post'),
            'picture' => NextendText::_('Picture_of_the_post'),
            'story' => NextendText::_('Story_of_the_post_only_for_status_type')
        );
    }

    function getData($number) {
        $data = array();

        $api = getNextendFacebook();
        if (!$api) return $data;

        $facebookpostbypage = (array)explode('||', $this->_data->get('facebookpostbypage', 'photo'));

        try {
            $result = $api->api($this->_data->get('facebookpostbypagepage', 'nextendweb').'/posts');
            $i = 0;
            foreach ($result['data'] AS $post) {
                if (!in_array($post['type'], $facebookpostbypage)) continue;
                $data[$i]['link'] = isset($post['link']) ? $post['link'] : '';
                $data[$i]['description'] = isset($post['message']) ? str_replace("\n", "<br/>", $this->makeClickableLinks($post['message'])) : '';
                $data[$i]['message'] = $data[$i]['description'];
                $data[$i]['story'] = isset($post['story']) ? $this->makeClickableLinks($post['story']) : '';
                $data[$i]['type'] = $post['type'];
                $data[$i]['picture'] = isset($post['picture']) ? $post['picture'] : '';
                $i++;
            }
        } catch (Exception $e) {

        }
        return $data;
    }

    function makeClickableLinks($s) {
        return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
    }
}