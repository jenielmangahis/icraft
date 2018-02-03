<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function returnOrderStatusMenu($selectedItem = '') {
   
    $satus = array(0 => 'Unassigned', 1 => 'Assigned', 2 => 'in-transit/Start', 3 => 'Hold', 4 => 'Reached', 5 => 'Return', 6 => 'Delivered', 7 => 'Delayed');
    $html = "<select name=\"orderSatus\" id=\"orderSatus\" class=\"form-control\">";
    $html .= "<option value=\"-1\">select</option>";
    foreach ($satus as $key => $value) {
        $html .= "<option value=\"$key\" ";
        if ($selectedItem >= 0 && $selectedItem == $key) {
            $html .= "selected= \"selected\" ";
        }
        $html .= ">$value</option>";
    }
    return $html;
}
