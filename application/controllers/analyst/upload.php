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
class Upload extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('model_transaksi'));
    }

    public function index() {
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 2) {
            $data['menu'] = array('home', 'profil', 'pesan', 'transaksi', 'upload file', 'log out');
            $data['link'] = array('analyst/home', 'analyst/profil', 'analyst/pesan', 'analyst/transaksi', 'analyst/upload', 'logout');
            $data['icon'] = array('icon-home', 'icon-user', 'icon-envelope', 'icon-file', 'icon-upload', 'icon-off');
            $data['stat'] = array('inactive', 'inactive', 'inactive', 'inactive', 'active', 'inactive');
            $data['content'] = 'analyst/upload';
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }

    public function do_upload() {
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 2) {
            $this->load->library('Excel_Reader');

            $file = $_FILES['userfile']['tmp_name'];
            $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
            if ($ext == "xls") {
                $this->excel_reader->setOutputEncoding('CP1251');
                $this->excel_reader->read($file);

                error_reporting(E_ALL ^ E_NOTICE);
                // Sheet 1
                $data = $this->excel_reader->sheets[0];

                for ($i = 2; $i <= $data['numRows']; $i++) {
                    $account = $data['cells'][$i][1];
                    $nama = $data['cells'][$i][2];
                    $perusahaan = $data['cells'][$i][3];
                    $alamat = $data['cells'][$i][4];
                    $kode_kota = $data['cells'][$i][5];
                    $kode_pos = $data['cells'][$i][6];
                    $telepon = $data['cells'][$i][7];
                    $email = $data['cells'][$i][8];
                    $cs = $this->model_transaksi->cari_sender($account);
                    if ((count($cs) < 1) AND (!empty($kode_kota))) {
                        $this->model_transaksi->input_sender($account, $nama, $perusahaan, $alamat, $kode_kota, $kode_pos, $telepon, $email);
                    }
                }

                $data = $this->excel_reader->sheets[1];

                for ($i = 2; $i <= $data['numRows']; $i++) {
                    //  for ($j = 1; $j <= $data['numCols']; $j++) {
                    //      echo $data['cells'][$i][$j];
                    //  }
                    //  echo "<br/>";
                    $r_nama = $data['cells'][$i][1];
                    $r_perusahaan = $data['cells'][$i][2];
                    $r_alamat = $data['cells'][$i][3];
                    $r_kode_kota = $data['cells'][$i][4];
                    if (($data['cells'][$i][5]) == "_") {
                        $r_kode_pos = "";
                    } else {
                        $r_kode_pos = $data['cells'][$i][5];
                    }
                    $r_telepon = $data['cells'][$i][6];
                    if (($data['cells'][$i][7]) == "_") {
                        $r_email = "";
                    } else {
                        $r_email = $data['cells'][$i][7];
                    }
                    $cs = $this->model_transaksi->cari_receiver($r_nama, $r_alamat, $r_telpon, $r_perusahaan);
                    if ((count($cs) < 1) AND (!empty($r_kode_kota))) {
                        $this->model_transaksi->input_receiver($r_nama, $r_perusahaan, $r_alamat, $r_kode_kota, $r_kode_pos, $r_telepon, $r_email);
                    }
                }
                $data = $this->excel_reader->sheets[2];
                $bulan = $data['cells'][1][2];
                $tahun = $data['cells'][2][2];

                for ($i = 4; $i <= $data['numRows']; $i++) {
                    $hari = $data['cells'][$i][1];

                    $tanggal = $tahun . '-' . $bulan . '-' . $hari;

                    $awb = $data['cells'][$i][2];
                    $no_acc = $data['cells'][$i][3];
                    $no_tel = $data['cells'][$i][4];
                    $kode_layanan = $data['cells'][$i][5];
                    $kode_tambahan = $data['cells'][$i][6];
                    $kode_perlakuan = $data['cells'][$i][7];
                    $pembayaran = $data['cells'][$i][8];

                    //barang
                    $nilai_barang = $data['cells'][$i][9];
                    $deskripsi = $data['cells'][$i][10];
                    $berat = $data['cells'][$i][11];
                    $dimensi = $data['cells'][$i][12];
                    $kemasan = $data['cells'][$i][13];

                    $biaya = $data['cells'][$i][14];
                    if ((empty($kode_layanan)) OR (empty($kode_tambahan)) OR (empty($kode_perlakuan)) OR (empty($pembayaran)) OR (empty($kemasan))) {
                        
                    } else {
                        $cs = $this->model_transaksi->cari_sender($no_acc);
                        $cr = $this->model_transaksi->cari_receiver2($no_tel);
                        if ((count($cs) > 0) AND (count($cr) > 0)) {
                            $this->model_transaksi->input_transaksi($tanggal, $awb, $no_acc, $no_tel, $kode_layanan, $kode_tambahan, $kode_perlakuan, $pembayaran, $nilai_barang, $deskripsi, $berat, $dimensi, $kemasan, $biaya);
                        }
                    }
                }
            } else {
                echo "format salah";
            }
            redirect('analyst/upload');
        } else {
            redirect('login');
        }
    }

}

?>
