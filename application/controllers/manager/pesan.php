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
class Pesan extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('date'));
        $this->load->model('model_pesan');
        $this->load->library(array('tampil'));
        $this->menu = array('dashboard', 'profil', 'pesan', 'log out');
        $this->link = array('manager/dashboard', 'manager/profil', 'manager/pesan', 'logout');
        $this->icon = array('icon-dashboard', 'icon-user', 'icon-envelope', 'icon-off');
        $this->stat = array('inactive', 'inactive', 'active', 'inactive');
    }

    public function index() {
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 1) {
            $data['menu'] = $this->menu;
            $data['link'] = $this->link;
            $data['icon'] = $this->icon;
            $data['stat'] = $this->stat;
            $data['pesan'] = $this->tampil->tampil();
            $data['content'] = 'manager/pesan';
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }

    public function do_pesan() {
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 1) {
            $pesan = $this->input->post('pesan');
            $sender = $this->session->userdata('user_id');
            $datestring = "%Y-%m-%d";
            $time = time();
            $waktu = mdate($datestring, $time);
            if (empty($pesan)) {
                $hasil = "Gagal kirim pesan";
                $image = "'" . base_url() . "media/img/alert.png'";
            } else {
                $this->model_pesan->add($pesan, $sender, $waktu);
                $hasil = "Berhasil kirim pesan";
                $image = "'" . base_url() . "media/img/info.png'";
            }
            echo '{ "message": "<img src=' . $image . '/> &nbsp; ' . $hasil . '"}';
        } else {
            redirect('login');
        }
    }

}

?>
