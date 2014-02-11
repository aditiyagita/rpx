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
        $this->load->helper('date');
        $this->load->model('model_pesan');
        $this->load->library('tampil');
    }

    public function index() {
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 2) {
            $data['menu'] = array('home', 'profil', 'pesan', 'transaksi', 'upload file', 'log out');
            $data['link'] = array('analyst/home', 'analyst/profil', 'analyst/pesan', 'analyst/transaksi', 'analyst/upload', 'logout');
            $data['icon'] = array('icon-home', 'icon-user', 'icon-envelope', 'icon-file', 'icon-upload', 'icon-off');
            $data['stat'] = array('inactive', 'inactive', 'active', 'inactive', 'inactive', 'inactive');
            $data['pesan'] = $this->tampil->tampil();
            $data['content'] = 'analyst/pesan';
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }

    public function do_pesan() {
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 2) {
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
