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
class Transaksi extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('model_transaksi'));
        $this->load->helper(array('date'));
        $this->load->library('form_validation');
        $this->menu = array('home', 'profil', 'pesan', 'transaksi', 'upload file', 'log out');
        $this->link = array('analyst/home', 'analyst/profil', 'analyst/pesan', 'analyst/transaksi', 'analyst/upload', 'logout');
        $this->icon = array('icon-home', 'icon-user', 'icon-envelope', 'icon-file', 'icon-upload', 'icon-off');
        $this->stat = array('inactive', 'inactive', 'inactive', 'active', 'inactive', 'inactive');
    }

    public function index() {
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 2) {
            $data['menu'] = $this->menu;
            $data['link'] = $this->link;
            $data['icon'] = $this->icon;
            $data['stat'] = $this->stat;
            $data['transaksi'] = $this->model_transaksi->tampil_transaksi();
            $data['sender'] = $this->model_transaksi->tampil_sender();
            $data['receiver'] = $this->model_transaksi->tampil_receiver();
            $data['layanan'] = $this->model_transaksi->tampil_layanan();
            $data['tambahan'] = $this->model_transaksi->tampil_tambahan();
            $data['perlakuan'] = $this->model_transaksi->tampil_perlakuan();
            $data['pembayaran'] = $this->model_transaksi->tampil_pembayaran();
            $data['kemasan'] = $this->model_transaksi->tampil_kemasan();
            $data['content'] = 'analyst/transaksi';
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }

    public function hapus($id) {
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 2) {
            $this->model_transaksi->hapus_transaksi($id);
            redirect('analyst/transaksi');
        } else {
            redirect('login');
        }
    }

    public function do_add() {
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 2) {
            $rules = array(
                array(
                    'field' => 'awb',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'sender',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'receiver',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'layanan',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'tambahan',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'perlakuan',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'pembayaran',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'deskripsi',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'nilai',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'berat',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'kemasan',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'biaya',
                    'rules' => 'required'
                ),
            );
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'error');
                redirect('analyst/transaksi');
            } else {
                $awb = $this->input->post('awb');
                $sender = substr(($this->input->post('sender')), 0, 9);
                $receiver = $this->input->post('receiver');
                $kode_layanan = $this->input->post('layanan');
                $kode_tambahan = $this->input->post('tambahan');
                $kode_perlakuan = $this->input->post('perlakuan');
                $pembayaran = $this->input->post('pembayaran');
                $deskripsi = $this->input->post('deskripsi');
                $nilai_barang = $this->input->post('nilai');
                $berat = $this->input->post('berat');
                $kemasan = $this->input->post('kemasan');
                $biaya = $this->input->post('biaya');
                $dimensi = $this->input->post('dimensi');
                $datestring = "%Y-%m-%d";
                $time = time();
                $tanggal = mdate($datestring, $time);
                
                $this->session->set_flashdata('error', 'berhasil');
                
                $this->model_transaksi->add_transaksi($awb, $sender, $receiver, $kode_layanan, $kode_tambahan, $kode_perlakuan, $pembayaran, $deskripsi, $nilai_barang, $berat, $kemasan, $biaya, $tanggal, $dimensi);
                redirect('analyst/transaksi');
            }
        } else {
            redirect('login');
        }
    }
    
    public function detil($id){
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 2) {
            $data['menu'] = $this->menu;
            $data['link'] = $this->link;
            $data['icon'] = $this->icon;
            $data['stat'] = $this->stat;
            $data['detil'] = $this->model_transaksi->detil_transaksi($id);
            $data['content'] = 'analyst/transaksi_detil';
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }
    
    public function edit($id){
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 2) {
            $data['menu'] = $this->menu;
            $data['link'] = $this->link;
            $data['icon'] = $this->icon;
            $data['stat'] = $this->stat;
            $data['detil'] = $this->model_transaksi->detil_transaksi($id);
            $data['content'] = 'analyst/transaksi_edit';
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }
    
    public function update(){
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 2) {
            $rules = array(
                array(
                    'field' => 'awb',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'deskripsi',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'nilai_barang',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'berat',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'dimensi',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'biaya',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'id',
                    'rules' => 'required'
                ),
            );
            $id = $this->input->post('id');
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'error');
                $url = "analyst/transaksi/edit/$id";
                redirect($url);
            } else {
                $awb = $this->input->post('awb');
                $deskripsi = $this->input->post('deskripsi');
                $nilai = $this->input->post('nilai_barang');
                $berat = $this->input->post('berat');
                $dimensi = $this->input->post('dimensi');
                $biaya = $this->input->post('biaya');
                $id_barang = $this->input->post('id_barang');
                $this->model_transaksi->update_transaksi($id, $awb, $deskripsi, $nilai, $berat, $dimensi, $biaya, $id_barang);
                $this->session->set_flashdata('error', 'berhasil');
                $url = "analyst/transaksi/edit/$id";
                redirect($url);
            }
        } else {
            redirect('login');
        }
    }

}

?>
