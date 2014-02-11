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
class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('model_dashboard'));
        $this->menu = array('dashboard', 'profil', 'pesan', 'log out');
        $this->link = array('manager/dashboard', 'manager/profil', 'manager/pesan', 'logout');
        $this->icon = array('icon-dashboard', 'icon-user', 'icon-envelope', 'icon-off');
        $this->stat = array('active', 'inactive', 'inactive', 'inactive');
        $this->tahun = $this->session->userdata('tahun');
    }

    public function index() {
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 1) {
            $data['menu'] = $this->menu;
            $data['link'] = $this->link;
            $data['icon'] = $this->icon;
            $data['stat'] = $this->stat;
            $data['kategor'] = array('Sumatera', 'Jawa', 'Bali-NusaTenggara', 'Kalimantan', 'Sulawesi-Maluku-Papua');
            $st = array('1', '11', '17', '20', '25');
            $fn = array('10', '16', '19', '24', '34');
            for ($i = 0; $i < (count($st)); $i++) {
                $hs[$i] = $this->model_dashboard->pulau($st[$i], $fn[$i], $this->tahun);
                foreach ($hs[$i] as $h[$i]) {
                    $zz[$i] = $h[$i]->biaya;
                }
            }
            $data['nilai'] = $zz;
            $data['url'] = "manager/dashboard/pulau/";
            $data['tahun'] = $this->tahun;
            $data['kondisi'] = "awal";
            $data['wilayah'] = "Indonesia";
            $data['pie'] = $this->model_dashboard->indo_pie($this->tahun);
            $data['content'] = 'manager/dashboard';
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }

    public function tahun($tahun) {
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 1) {
            $this->session->set_userdata('tahun', $tahun);
            redirect('welcome');
        } else {
            redirect('login');
        }
    }

    public function pulau($pulau) {
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 1) {
            $data['menu'] = $this->menu;
            $data['link'] = $this->link;
            $data['icon'] = $this->icon;
            $data['stat'] = $this->stat;
            $data['tahun'] = $this->tahun;
            $data['kondisi'] = "prov";
            $data['url'] = "manager/dashboard/provinsi/";
            $data['content'] = 'manager/dashboard';
            $data['wilayah'] = $pulau;
            switch ($pulau) {
                case "Sumatera":
                    $st = 1;
                    $fn = 10;
                    break;
                case "Jawa":
                    $st = 11;
                    $fn = 16;
                    break;
                case "Bali-NusaTenggara":
                    $st = 17;
                    $fn = 19;
                    break;
                case "Kalimantan":
                    $st = 20;
                    $fn = 24;
                    break;
                case "Sulawesi-Maluku-Papua":
                    $st = 25;
                    $fn = 34;
                    break;
                default:
                    break;
            }
            $hs = $this->model_dashboard->region($st, $fn, $this->tahun);
            $data['between'] = "$st AND $fn";
            $data['pie'] = $this->model_dashboard->pulau_pie($st, $fn, $this->tahun);
            // $dt_row = $this->row($hs);
            $i = 0;
            if (count($hs) > 0) {
                foreach ($hs as $h) {
                    $zz[$i] = $h->biaya;
                    $xx[$i] = $h->kat;
                    $i++;
                }
            } else {
                $zz = array();
                $xx = array();
            }
            $data['nilai'] = $zz;
            $data['kategor'] = $xx;
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }

    public function provinsi($kt) {
        if ($this->session->userdata('is_login') == TRUE && $this->session->userdata('hak_akses') == 1) {
            $data['menu'] = $this->menu;
            $data['link'] = $this->link;
            $data['icon'] = $this->icon;
            $data['stat'] = $this->stat;
            $data['tahun'] = $this->tahun;
            $data['kondisi'] = "kota";
            $data['url'] = "manager/dashboard/";
            $data['content'] = 'manager/dashboard';
            $kota = str_replace('%20', ' ', $kt);
            $data['wilayah'] = $kota;
            $hs = $this->model_dashboard->kota($kota, $this->tahun);
            $i = 0;
            if (count($hs) > 0) {
                foreach ($hs as $h) {
                    $zz[$i] = $h->biaya;
                    $xx[$i] = $h->kat;
                    $i++;
                }
            } else {
                $zz = array();
                $xx = array();
            }
            $data['nilai'] = $zz;
            $data['kategor'] = $xx;
            $data['pie'] = $this->model_dashboard->prov_pie($kota, $this->tahun);
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }
}

?>
