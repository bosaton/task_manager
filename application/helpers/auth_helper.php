<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function is_administrator() {
    $CI =& get_instance();
    $CI->load->library('session');
    $sessionUser= $CI->session->userdata("username");
    $sessionRole= $CI->session->userdata("role");
    if(!empty($sessionUser) && $sessionRole=="admin") {
        return true;
    } else {
        return false;
    }
}
   
function is_user() {
    $CI =& get_instance();
    $CI->load->library('session');
    $sessionUser= $CI->session->userdata("username");
    $sessionRole= $CI->session->userdata("role");
    //echo '<script> alert("auth_helper/is_user-'.$sessionRole.'-'.$sessionUser.'");</script>'; 
    if(!empty($sessionUser) && $sessionRole=="user") {    
        return true;
    } else {
        return false;
    }
}
?>