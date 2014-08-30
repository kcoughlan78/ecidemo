<?php

nextendimportsmartslider2('nextend.smartslider.generator_abstract');

class NextendGeneratorFlickr_Peoplephotostream extends NextendGeneratorAbstract {

    var $extraFields;

    function NextendGeneratorFlickr_Peoplephotostream($data) {
        parent::__construct($data);
        $this->_variables = array(
            'title' => NextendText::_('Title_of_the_photo'),
            'image' => NextendText::_('Image'),
            'thumbnail' => NextendText::_('Thumbnail'),
            'description' => NextendText::_('Description_of_the_photo'),
            'url' => NextendText::_('Photos_url_of_the_photo_s_owner'),
            'url_label' => NextendText::_('Label'),
            'author_name' => NextendText::_('Real_name_of_the_photo_s_owner'),
            'author_url' => NextendText::_('Profile_url_of_the_photo_s_owner')/*,
            'owner_username' => NextendText::_('Username_of_the_photo_s_owner'),
            'owner_realname' => NextendText::_('Real_name_of_the_photo_s_owner'),
            'owner_photosurl' => NextendText::_('Photos_url_of_the_photo_s_owner'),
            'owner_profileurl' => NextendText::_('Profile_url_of_the_photo_s_owner'),
            'url_sq' => NextendText::_('Small_square_image_75_75'),
            'url_t' => NextendText::_('Thumbnail_image_100_on_longest_side'),
            'url_s' => NextendText::_('Small_image_240_on_longest_side'),
            'url_q' => NextendText::_('Large_square_image_150_150'),
            'url_m' => NextendText::_('Medium_500_on_longest_side'),
            'url_n' => NextendText::_('Small_320_on_longest_side'),
            'url_z' => NextendText::_('Medium_640_on_longest_side'),
            'url_c' => NextendText::_('Medium_800_on_longest_side'),
            'url_l' => NextendText::_('Large_1024_on_longest_side'),
            'url_o' => NextendText::_('Original_image'),
            'id' => NextendText::_('ID_of_the_photo')*/
        );
    }

    function getData($number) {
        $data = array();

        $api = getNextendFlickr();
        if (!$api) return $data;
        $peoplephotostreamprivacy = intval($this->_data->get('peoplephotostreamprivacy', 1));

        $result = $api->people_getPhotos('me', array(
            'per_page' => $number,
            'privacy_filter' => $peoplephotostreamprivacy,
            'extras' => 'description, date_upload, date_taken, owner_name, geo, tags, o_dims, views, media, path_alias, url_sq, url_t, url_s, url_q, url_m, url_n, url_z, url_c, url_l, url_o'
        ));

        $people = array();

        foreach ($result['photos']['photo'] AS $photo) {
            if (!isset($people[$photo['owner']])) {
                $people[$photo['owner']] = $api->people_getInfo($photo['owner']);
            }
            $ow = $people[$photo['owner']];
            $photo['owner_username'] = $ow['username'];
            $photo['owner_realname'] = isset($ow['realname']) ? $ow['realname'] : $ow['username'];
            $photo['owner_photosurl'] = $ow['photosurl'];
            $photo['owner_profileurl'] = $ow['profileurl'];
            
            $photo['image'] = (isset($photo['url_o']) ? $photo['url_o']: $photo['url_l']) ;
            $photo['thumbnail'] = (isset($photo['url_m']) ? $photo['url_m']: $photo['url_l']) ;
            $photo['url'] = $photo['owner_photosurl'];
            $photo['url_label'] = 'More photos';
            $photo['author_name'] = $photo['owner_realname'];
            $photo['author_url'] = $photo['owner_profileurl'];
            
            $data[] = $photo;
        }

        return $data;
    }
}