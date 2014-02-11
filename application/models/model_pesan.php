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
class model_pesan extends CI_Model{
    function tampil(){
        $query = $this->db->query("SELECT * FROM pesan, user WHERE pesan.sender= user.id_user ORDER BY id_pesan DESC");
        return $query->result();
    }
    
    function add($pesan, $sender, $waktu){
        $this->db->query("INSERT INTO rpx.pesan (waktu, pesan, sender)  VALUES ('$waktu', '$pesan', '$sender')");
    }
}

?>
