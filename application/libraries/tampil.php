<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tampil
 *
 * @author aditiya
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tampil extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('model_pesan', 'model_profil'));
        $this->load->library('form_validation');
    }

    public function tampil() {
        $pesan = $this->model_pesan->tampil();
        return $pesan;
    }

    public function profil($id_user) {
        $profil = $this->model_profil->tampil($id_user);
        return $profil;
    }

    public function update_profil($username, $email, $nama, $password) {
        if (($username == '') OR ($email == '') OR ($nama == '') OR ($password == '')) {
            $respon = 1;
        } else {
            $respon = 2;
        }
        return $respon;
    }

}

?>
