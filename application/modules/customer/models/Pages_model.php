<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Pages_model extends CI_Model {

    public function getPageBySlug($slug) {
        $this->db->where('slug',$slug);
        $result    =   $this->db->get('tbl_pages')->row();
        return $result;
    }
}
