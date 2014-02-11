<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_login
 *
 * @author aditiya
 */
class model_login extends CI_Model{
    function login($username, $password){
        $query = $this->db->query("SELECT * FROM user WHERE username='$username' AND password=MD5('$password')");
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
    }
}

?>
