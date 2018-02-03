<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Products_model extends CI_Model {
    private $_sub_cat = '';
    private $_family = '';
    private $_category = '';
    
    function get_category() {
        return $this->_category;
    }

    function set_category($_category) {
        $this->_category = $_category;
    }

    function get_family() {
        return $this->_family;
    }

    function set_family($_family) {
        $this->_family = $_family;
    }
    
    function get_sub_cat() {
        return $this->_sub_cat;
    }

    function set_sub_cat($_sub_cat) {
        $this->_sub_cat = $_sub_cat;
    }

        
    public function getAllProducts(){
        $this->db->select('items.*,item_familly.name as family, category.name as cat_name');
        $this->db->join('item_familly','item_familly.id=items.item_familly','left');
        $this->db->join('category','category.category_id=items.sub_category_ids','left');
        if($this->input->post('is_main') == 'yes'){
            if($this->input->post('rare_products') == 'yes'){
                $this->db->where('items.limited !=',0);
                
                if($this->get_family() != ''){
                    $this->db->where('item_familly',$this->get_family());
                }
            }else if($this->input->post('all_products') == 'no'){
                if($this->input->post('cat_id') != ''){
                    $this->db->where('items.category_id',$this->input->post('cat_id'));
                }
                if($this->get_family() != ''){
                    $this->db->where('item_familly',$this->get_family());
                }
            }
            $this->db->order_by('items.sub_category_ids');
            $query  =   $this->db->get('items');
            //echo $this->db->last_query();
            return $query->result();
        }else if($this->input->post('by_mood') == 'yes'){
            if($this->input->post('by_mood_id') != ''){
                $where  = "(FIND_IN_SET( '".$this->input->post('by_mood_id')."' , moods) or FIND_IN_SET( '".$this->input->post('by_mood_id')."' , medicals))";
                $this->db->where($where);
            }
            if($this->get_family() != ''){
                $this->db->where('item_familly',$this->get_family());
            }
            $query  =   $this->db->get('items');
            //echo $this->db->last_query();
            return $query->result();
        }else{
            if($this->get_sub_cat() != ''){
                $this->db->where("FIND_IN_SET( '".$this->get_sub_cat()."' , sub_category_ids) ");
            }
            if($this->input->post('cat_id') != ''){
                $this->db->where('items.category_id',$this->input->post('cat_id'));
            }
            if($this->get_family() != ''){
                $this->db->where('item_familly',$this->get_family());
            }
            //$this->db->order_by('category.category_id');
            $query  =   $this->db->get('items');
            //echo $this->db->last_query();
            return $query->result();
        }
    }
    
    public function getProductDetail($id){
        $this->db->select('items.*,item_familly.name as family,category.name as category_name');
        $this->db->join('item_familly','item_familly.id=items.item_familly','left');
        $this->db->join('category','category.category_id=items.category_id','left');
        $this->db->where('items.item_id',$id);
        $query  =   $this->db->get('items');
        return $query->row();
    }
    
    public function productAddToCart($data){
        $success    =   false;
        $this->db->select('*');
        $this->db->from('cart');
        $this->db->where('item_id',$data['item_id']);
        $this->db->where('user_id',$data['user_id']);
        $this->db->where('type',$data['type']);
        $query  =   $this->db->get()->row();
        
        if($query){
           $updateData = ($query->quantity)+$data['quantity'];
           $this->db->where('item_id',$data['item_id']);
           $this->db->where('user_id',$data['user_id']);
           $this->db->where('type',$data['type']);
           $this->db->update('cart',array('quantity'=>$updateData));
           if($this->db->affected_rows() > 0){
               $success =    true;
           }
        }else{
            $this->db->insert('cart', $data);
            if($this->db->insert_id() > 0){
                $success =    true;
            }
        }
        return $success;
    }
    
    public function checkAddToCartProductQuantity(){
        $this->db->select('sum(quantity) as total');
        $this->db->from('cart');
        $this->db->where('user_id',$this->session->userdata('CUSTOMER-ID'));
        $query  =   $this->db->get()->row();
        return $query->total;
    }
    
    public function AddToCart(){
   
        $this->db->select('i.*,c.id as cart_id, c.item_id,c.quantity,c.type as saved_type,category.name as category_name,item_familly.name as family');
        $this->db->from('cart as c');
        $this->db->join('items as i','i.item_id = c.item_id','left');
        $this->db->join('category','category.category_id=i.category_id','left');
        $this->db->join('item_familly','item_familly.id=i.item_familly','left');
        $this->db->where('c.user_id',$this->session->userdata('CUSTOMER-ID'));
        $result  =   $this->db->get()->result();
        return $result;
    }
    
    public function removeItemFromCart(){
        $this->db->where('id',$this->input->post('cart_item_id'));
        $this->db->delete('cart');
    }
    
    public function emptyCart(){
        $this->db->empty_table('cart');
    }
    
    public function getAllParentCategory(){
        $this->db->select('name,category_id');
        $this->db->where('status','1');
        $this->db->where('parent_id','0');
        $query  =   $this->db->get('category');
        return $query->result();
    }
    
    public function getAllCategoriesByParent(){
        $this->db->select('name,category_id');
        $this->db->where('status','1');
        $this->db->where('parent_id',$this->input->post('cat_id'));
        $this->db->or_where('category_id',$this->input->post('cat_id'));
        $query  =   $this->db->get('category');
        return $query->result();
    }
    
    public function getItemFamilies(){
        $this->db->select('id as family_id,name as family_name');
        $this->db->where('status','1');
        $query  =   $this->db->get('item_familly');
        return $query->result(); 
    }

    public function checkIfFirstOrder()
    {
        $firstOrder = false;

        $customerID = $this->session->userdata('CUSTOMER-ID');

        if ( !empty($customerID) && !is_bool($customerID) )
        {
            $countOrders = $this->db->where('user_id', $customerID)->count_all_results('orders');

            $firstOrder = ($countOrders == 0);
        }

        return $firstOrder;
    }

    public function getMinimumDeliveryAmount()
    {
        return $this->db->where('active', "1")->get('minimum_delivery_prices')->first_row();
    }

    public function createOrder(){
        // check if the order amount does respect the minimum condition
        $minOrderAmount = $this->getMinimumDeliveryAmount();

        if ( is_object($minOrderAmount) && isset($minOrderAmount->fare) && $minOrderAmount->fare > $this->input->post('total_amount') )
        {
            throw new \Exception("The minimum delivery amount is {$minOrderAmount->fare}.");
        }

        $this->db->set('user_id',$this->session->userdata('CUSTOMER-ID'));
        $this->db->set('order_type','1');
        $this->db->set('pay_status','0');
        $this->db->set('order_status','0');
        $this->db->set('first_time', $this->checkIfFirstOrder());
        $this->db->set('amount',$this->input->post('total_amount'));
        $this->db->insert('orders');

        $lastInsertedId =   $this->db->insert_id();
        
        if($lastInsertedId != ''){
            $this->session->set_userdata('order_id',$lastInsertedId);
            $cartItems  =   $this->AddToCart();
            foreach($cartItems as $item){
                $this->db->set('order_id',$lastInsertedId);
                $this->db->set('item_id',$item->item_id);
                $this->db->set('order_qty',$item->quantity);
                $this->db->insert('order_items');
            }
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
