<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dashboard
 *
 * @author aditiya
 */
class Home extends CI_Controller {

    public function index() {
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 2) {
            $data['menu'] = array('home', 'profil', 'pesan', 'transaksi', 'upload file', 'log out');
            $data['link'] = array('analyst/home', 'analyst/profil', 'analyst/pesan', 'analyst/transaksi', 'analyst/upload', 'logout');
            $data['icon'] = array('icon-home', 'icon-user', 'icon-envelope', 'icon-file', 'icon-upload', 'icon-off');
            $data['stat'] = array('active', 'inactive', 'inactive', 'inactive', 'inactive', 'inactive');
            $data['content'] = 'analyst/home';
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }

}

?>
