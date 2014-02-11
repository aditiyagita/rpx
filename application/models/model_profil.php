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
class model_profil extends CI_Model{
    function tampil($id_user){
        $query = $this->db->query("SELECT user.username, user.password, user.email, user.nama, user.tgl_lahir FROM user WHERE id_user= '$id_user'");
        return $query->result();
    }
    
    function edit($username, $email, $nama, $password, $id_user){
        $this->db->query("UPDATE `rpx`.`user` SET `username` = '$username', `password` = MD5( '$password' ) , `nama` = '$nama', `email` = '$email' WHERE `user`.`id_user` ='$id_user'");
    }
}

?>
