<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of upload
 *
 * @author aditiya
 */
class Profil extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('date'));
        $this->menu = array('dashboard', 'profil', 'pesan', 'log out');
        $this->link = array('manager/dashboard', 'manager/profil', 'manager/pesan', 'logout');
        $this->icon = array('icon-dashboard', 'icon-user', 'icon-envelope', 'icon-off');
        $this->stat = array('inactive', 'active', 'inactive', 'inactive');
        $this->id_user = $this->session->userdata('user_id');
        $this->load->library('tampil');
    }

    public function index() {
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 1) {
            $data['menu'] = $this->menu;
            $data['link'] = $this->link;
            $data['icon'] = $this->icon;
            $data['stat'] = $this->stat;
            $data['profil'] = $this->tampil->profil($this->id_user);
            $data['content'] = 'manager/profil';
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }

    public function add_profil() {
        $this->load->model(array('model_pesan', 'model_profil'));
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $nama = $this->input->post('nama');
        $password = $this->input->post('password');
        $respon = $this->tampil->update_profil($username, $email, $nama, $password, $this->id_user);
        if ($respon == 1) {
            $hasil = "Gagal kirim pesan";
            $image = "'" . base_url() . "media/img/alert.png'";
        } else {
            $this->model_profil->edit($username, $email, $nama, $password, $$this->id_user);
            $hasil = "Berhasil edit profil";
            $image = "'" . base_url() . "media/img/alert.png'";
        }
        echo '{ "message": "<img src=' . $image . '/> &nbsp; ' . $hasil . '"}';
    }

}

?>
