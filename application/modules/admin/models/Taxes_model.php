<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Taxes_model
 *
 * @author vishal
 */
class Taxes_model extends CI_Model{
    //put your code here
    
    private $_id;
    private $_tax_name;
    private $_tax_type;
    private $_is_active;
    private $_amt_value;
    private $_created_on;
    private $_modified_on;
    
    public function getId() {
        return $this->_id;
    }

    public function getTax_name() {
        return $this->_tax_name;
    }

    public function getTax_type() {
        return $this->_tax_type;
    }

    public function getIs_active() {
        return $this->_is_active;
    }

    public function getCreated_on() {
        return $this->_created_on;
    }

    public function getModified_on() {
        return $this->_modified_on;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function setTax_name($tax_name) {
        $this->_tax_name = $tax_name;
    }

    public function setTax_type($tax_type) {
        $this->_tax_type = $tax_type;
    }

    public function setIs_active($is_active) {
        $this->_is_active = $is_active;
    }

    public function setCreated_on($created_on) {
        $this->_created_on = $created_on;
    }

    public function setModified_on($modified_on) {
        $this->_modified_on = $modified_on;
    }

    public function getAmt_value() {
        return $this->_amt_value;
    }

    public function setAmt_value($amt_value) {
        $this->_amt_value = $amt_value;
    }

    
    public function selectAllTaxex(){
        
        return $this->db->select("id, tax_name, tax_type, amt_value, is_active")->from("taxes")->order_by("tax_name", "asc")->get()->result_array();
        
    }
    
    public function selectTotalRecordCount(){
        $data = $this->db->select("count(id) as total_records")->from("taxes")->order_by("tax_name", "asc")->get()->row_array();
        return $data['total_records'] ;
        
    }
    public function addNewTax() {	
        $in_data=array(       
            'tax_name'        => $this->getTax_name(),
            'tax_type'      => $this->getTax_type(),
            'amt_value'     => $this->getAmt_value()
        );
       
        $res = $this->db->insert('taxes', $in_data);
        $data = $this->db->affected_rows();
        return $data; 
    }
    
    public function fetch_tax_details(){
            $taxId=$this->getId();
            $data = array();
            $query = $this->db->select('t.id,t.tax_name,t.tax_type,t.amt_value')->from('taxes as t')->where('id =', $taxId)->get();

            if($query->num_rows() > 0){
                $data = $query->row_array();
            }

            return $data; 
        
            
    }
    
    /*
     * MAnage Products : Admin Setting Section
     * author   : Niraj
     * function : Update Tax Details
     */
    public function updateTaxDetails() {
        $data = array();    	
        $update_data=array('tax_name' => $this->getTax_name(),'tax_type' => $this->getTax_type(),'amt_value' => $this->getAmt_value());
        $res = $this->db->where(array('id'=>$this->getId()))->update('taxes', $update_data);
        $data = $this->db->affected_rows();        
        return $data; 
    }
    
     /*
     * Function : Manage Taxes Seb-section 
     * author   : Niraj
     * Function : Acivate/ Inactivate Tax Status
     */
    public function changeTaxStatus(){
        
            $taxInfo = $this->chkTaxId();
            $newStatus  = $taxInfo['is_active'] == 1 ? '0' : '1' ; 

            $data = array();
            $this->db->where('id',$this->getId())->update('taxes',array('is_active'=>$newStatus));
            $data = $this->db->affected_rows();
            return $data;
    
    }
    
      /*
     * Function : Check user id existance 
     * author   : Niraj
     * Argument : tablename e.g; users 
     */
    public function chkTaxId() {
        
        $chkData = array('id' => $this->getId());
        $res    = $this->db->get_where('taxes', $chkData);
        if ($res->num_rows() > 0)
        {
            return $res->row_array();
        }else{
            return 0;           
        }
    }
    
     /*
     * Function : Manage Taxe Seb-section 
     * author   : Niraj
     * Function : Delete Tax
     */
    public function delete_tax(){  
        $this->db->where('id', $this->getId())->delete('taxes'); 
        $data = $this->db->affected_rows();
        return $data;
    }
    
}
