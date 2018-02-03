<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Products extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('customer/Products_model');
        $this->load->helper('common_helper');
        $this->load->helper('user_helper');
        $this->load->helper('url');
        $this->load->helper('download');
        $this->load->library('s3');
//        if ($this->session->userdata('CUSTOMER-SL') == '') {
//            redirect('cus-login');
//        }
        checkCartQuantity();
    }

    public function productListing() {
        $proObj = new Products_model();
        $output['title'] = 'Our Products';
        $output['pageName'] = 'Our Products';
        $output['header_class'] = 'icon-back-arrow,' . base_url() . 'cus-home';
        //$output['header_class'] = 'icon-menu,javascript:;';
        $output['header_class_right'][0] = 'icon-search,javascript:;';
        $output['header_class_right'][1] = 'icon-cart cart-badge,' . base_url() . 'cus-add-tocart';
        //$output['allProducts'] = $proObj->getAllProducts();
        $output['category'] = $proObj->getAllParentCategory();
        $output['families'] = $proObj->getItemFamilies();

        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/our_products');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }

    public function productDetail($id) {
        $proObj = new Products_model();
        $output['title'] = 'Product Details';
        $output['pageName'] = 'Product Details';
        $output['header_class'] = 'icon-back-arrow,' . base_url() . 'cus-our-products';

        $output['productDetail'] = $proObj->getProductDetail($id);

        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/product_detail');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }

    public function productAddToCart() {
        checkMemberLogin();
        $data = array();
        $proObj = new Products_model();
        $data['item_id'] = $this->input->post('item_id');
        $data['quantity'] = $this->input->post('quantity');
        $data['type'] = $this->input->post('type');
        $data['user_id'] = $this->session->userdata('CUSTOMER-ID');
        $res    =   $proObj->productAddToCart($data);
        $totalQuantity = $proObj->checkAddToCartProductQuantity();
        $this->session->set_userdata('total_item', $totalQuantity);
        checkCartQuantity();
        $data['quantity']       =   $this->session->userdata('total_item');
        $data['success']        =   $res;
        echo json_encode($data);die;
    }

    public function addToCart() {
        checkMemberLogin();
        $proObj = new Products_model();
        $output['title'] = 'My Cart';
        $output['pageName'] = 'My Cart';
        $output['header_class'] = 'icon-back-arrow,' . base_url() . 'cus-our-products';
        $output['header_class_right'][1] = 'icon-delete empty-cart,javascript:;';
        $output['firstOrder'] = $proObj->checkIfFirstOrder();
        $output['products'] = $proObj->AddToCart();

        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/my_cart');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }

    public function getSubCategoriesAndProducts() {
        $proObj = new Products_model();
        $data['subCats'] = $proObj->getAllCategoriesByParent();
        $proObj->set_sub_cat($data['subCats'][0]->category_id);
        $data['products'] = $proObj->getAllProducts();
        echo json_encode($data);
        die;
    }

    public function getProductsBySubCategory() {
        $proObj = new Products_model();
        $proObj->set_sub_cat($this->input->post('sub_cat_id'));
        $proObj->set_family($this->input->post('family_id'));
        $data['products'] = $proObj->getAllProducts();
        echo json_encode($data);
        die;
    }

    public function cartCheckout() {
        checkMemberLogin();
        $proObj = new Products_model();
        $data = array("status" => false, "delivery" => true);
        try
        {
            $result = $proObj->createOrder();
             if ($result) {
                $data['status'] = '1';
            } else {
                $data['status'] = '0';
            }
        }
        catch (\Exception $e)
        {
            $data['delivery'] = false;
            $data['status'] = '0';
        }
        echo json_encode($data);
        die;
    }

    public function removeItemFromCart() {
        checkMemberLogin();
        $proObj = new Products_model();
        $proObj->removeItemFromCart();
        $data = TRUE;
        echo json_encode($data);
        die;
    }

    public function emptyCart() {
        checkMemberLogin();
        $proObj = new Products_model();
        $proObj->emptyCart();
        $data = TRUE;
        echo json_encode($data);
        die;
    }

}
