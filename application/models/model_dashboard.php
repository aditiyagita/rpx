<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_dashboard
 *
 * @author aditiya
 */
class model_dashboard extends CI_Model {

    function indo_pie($tahun) {
        $query = $this->db->query("
                                    SELECT (
                                        SUM(biaya)/(SELECT sum(biaya) 
                                        FROM transaksi 
                                        WHERE YEAR(tanggal) =$tahun)*100
                                       ) as persen, kode_layanan 
                                    FROM transaksi 
                                    WHERE YEAR(tanggal) =$tahun 
                                    GROUP BY kode_layanan
                                   ");
        return $query->result();
    }

    function pulau_pie($st, $fn, $tahun) {
        $query = $this->db->query("
                                    SELECT (
                                    SUM( transaksi.biaya ) / (
                                    SELECT SUM( transaksi.biaya )
                                    FROM transaksi, customer, pengirim, kota, provinsi
                                    WHERE provinsi.id_provinsi = kota.provinsi_id_provinsi
                                    AND kota.id_kota = customer.id_kota
                                    AND customer.id_customer = pengirim.customer_id_customer
                                    AND pengirim.id_pengirim = transaksi.id_transaksi
                                    AND provinsi.id_provinsi
                                    BETWEEN $st
                                    AND $fn
                                    AND YEAR( transaksi.tanggal ) =$tahun ) *100
                                    ) AS persen, transaksi.kode_layanan
                                    FROM transaksi, customer, pengirim, kota, provinsi
                                    WHERE provinsi.id_provinsi = kota.provinsi_id_provinsi
                                    AND kota.id_kota = customer.id_kota
                                    AND customer.id_customer = pengirim.customer_id_customer
                                    AND pengirim.id_pengirim = transaksi.id_transaksi
                                    AND provinsi.id_provinsi
                                    BETWEEN $st
                                    AND $fn
                                    AND YEAR( transaksi.tanggal ) =$tahun
                                    GROUP BY transaksi.kode_layanan
                                  ");
        return $query->result();
    }
    
    function prov_pie($kota, $tahun){
        $query = $this->db->query("
                                    SELECT SUM( transaksi.biaya / (
                                    SELECT SUM( transaksi.biaya )
                                    FROM transaksi, pengirim, customer, kota, provinsi
                                    WHERE provinsi.id_provinsi = kota.provinsi_id_provinsi
                                    AND kota.id_kota = customer.id_kota
                                    AND customer.id_customer = pengirim.customer_id_customer
                                    AND pengirim.id_pengirim = transaksi.id_pengirim
                                    AND provinsi.id_provinsi = (
                                    SELECT id_provinsi
                                    FROM provinsi
                                    WHERE provinsi = '$kota' )
                                    AND YEAR( transaksi.tanggal ) =$tahun ) *100 ) AS persen, transaksi.kode_layanan
                                    FROM transaksi, pengirim, customer, kota, provinsi
                                    WHERE provinsi.id_provinsi = kota.provinsi_id_provinsi
                                    AND kota.id_kota = customer.id_kota
                                    AND customer.id_customer = pengirim.customer_id_customer
                                    AND pengirim.id_pengirim = transaksi.id_pengirim
                                    AND provinsi.id_provinsi = (
                                    SELECT id_provinsi
                                    FROM provinsi
                                    WHERE provinsi = '$kota' )
                                    AND YEAR( transaksi.tanggal ) =$tahun
                                    GROUP BY transaksi.kode_layanan
                                  ");
        return $query->result();
    }

    function pulau($st, $fn, $tahun) {
        $query = $this->db->query("
                                    SELECT SUM(transaksi.biaya) as biaya  
                                    FROM transaksi, pengirim, customer, kota, provinsi 
                                    WHERE YEAR(transaksi.tanggal) =$tahun 
                                    AND transaksi.id_pengirim = pengirim.id_pengirim 
                                    AND pengirim.customer_id_customer = customer.id_customer 
                                    AND customer.id_kota = kota.id_kota 
                                    AND kota.provinsi_id_provinsi = provinsi.id_provinsi 
                                    AND provinsi.id_provinsi BETWEEN $st AND $fn
                                   ");
        return $query->result();
    }

    function region($fr, $to, $tahun) {
        $query = $this->db->query("
                                    SELECT provinsi.provinsi AS kat, sum( transaksi.biaya ) AS biaya
                                    FROM provinsi
                                    LEFT JOIN kota ON kota.provinsi_id_provinsi = provinsi.id_provinsi
                                    LEFT JOIN customer ON customer.id_kota = kota.id_kota
                                    LEFT JOIN pengirim ON pengirim.customer_id_customer = customer.id_customer
                                    LEFT JOIN transaksi ON transaksi.id_pengirim = pengirim.id_pengirim 
                                    AND YEAR(transaksi.tanggal) = $tahun
                                    WHERE provinsi.id_provinsi
                                    BETWEEN $fr
                                    AND $to
                                    GROUP BY provinsi.id_provinsi            
                                    ");
        return $query->result();
    }
    
    function kota($kota, $tahun){
        $query = $this->db->query("
                                    SELECT SUM(transaksi.biaya) AS biaya, kota.kota AS kat
                                    FROM transaksi, customer, pengirim, kota, provinsi
                                    WHERE provinsi.id_provinsi = kota.provinsi_id_provinsi
                                    AND kota.id_kota = customer.id_kota
                                    AND customer.id_customer = pengirim.customer_id_customer
                                    AND pengirim.id_pengirim = transaksi.id_pengirim
                                    AND provinsi.provinsi = '$kota'
                                    AND YEAR(transaksi.tanggal) = $tahun
                                    GROUP BY kota.id_kota
                                  ");
        return $query->result();
    }

}

?>
