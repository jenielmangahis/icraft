<?php

function create_unique_slug_for_common($app_title, $table) {

    $CI = & get_instance();
    $CI->load->library('session');

    $slug = url_title($app_title);
    $slug = strtolower($slug);
    $i = 0;
    $params = array();
    $params['slug'] = $slug;
    while ($CI->db->where($params)->get($table)->num_rows()) {
        if (!preg_match('/-{1}[0-9]+$/', $slug)) {
            $slug .= '-' . ++$i;
        } else {
            $slug = preg_replace('/[0-9]+$/', ++$i, $slug);
        }
        $params ['slug'] = $slug;
    }
    $app_title = $slug;
    return $app_title;
}

function checkMemberLogin() {
    $CI = & get_instance();
    if ($CI->session->userdata('CUSTOMER-ID') == '' || $CI->session->userdata('CUSTOMER-SL') == '') {
        $CI->session->set_userdata('REDIRECT_URL', current_url());
        $CI->session->set_userdata('PAGE_ERROR_MESSAGE', "Please login to access this page");
        redirect('cus-login');
    }
}

function checkCartQuantity() {
    $CI = & get_instance();
    if ($CI->session->userdata('CUSTOMER-ID') != '' && $CI->session->userdata('CUSTOMER-SL') != '') {
        //$CI->db->select('sum(quantity) as total');
        $CI->db->select('count(id) as total');
        $CI->db->from('cart');
        $CI->db->where('user_id',$CI->session->userdata('CUSTOMER-ID'));
        $totalQuantity  =   $CI->db->get()->row()->total;
        $CI->session->set_userdata('total_item',$totalQuantity);
    }
}
