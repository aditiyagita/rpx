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
class model_transaksi extends CI_Model {

    function input_sender($account, $nama, $perusahaan, $alamat, $kode_kota, $kode_pos, $telepon, $email) {
        $query = $this->db->query("
                                    INSERT INTO rpx.customer (nama, perusahaan, alamat, telpon, kode_pos, email, id_kota) 
                                    VALUES ('$nama', '$perusahaan', '$alamat', '$telepon', '$kode_pos', '$email', 
                                        (SELECT id_kota FROM kota WHERE kode_kota='$kode_kota' LIMIT 0,1))
                                  ");
        $sender = $this->db->query("
                                    INSERT INTO rpx.pengirim (no_account, customer_id_customer)
                                    VALUES ('$account', 
                                        (SELECT MAX(id_customer) FROM rpx.customer LIMIT 0,1))
                                   ");
    }

    function input_receiver($r_nama, $r_perusahaan, $r_alamat, $r_kode_kota, $r_kode_pos, $r_telepon, $r_email) {
        $query = $this->db->query("
                                    INSERT INTO rpx.customer (nama, perusahaan, alamat, telpon, kode_pos, email, id_kota) 
                                    VALUES ('$r_nama', '$r_perusahaan', '$r_alamat', '$r_telepon', '$r_kode_pos', '$r_email', 
                                        (SELECT id_kota FROM kota WHERE kode_kota='$r_kode_kota' LIMIT 0,1))
                                  ");
        $receiver = $this->db->query("
                                    INSERT INTO rpx.penerima (id_customer)
                                    VALUES ((SELECT MAX(id_customer) FROM rpx.customer LIMIT 0,1))
                                    ");
    }

    function input_transaksi($tanggal, $awb, $no_acc, $no_tel, $kode_layanan, $kode_tambahan, $kode_perlakuan, $pembayaran, $nilai_barang, $deskripsi, $berat, $dimensi, $kemasan, $biaya) {
        $barang = $this->db->query("INSERT INTO rpx.barang (deskripsi, nilai_barang) VALUES ('$deskripsi', '$nilai_barang')");
        $package = $this->db->query("
                                        INSERT INTO rpx.package (actual_weight, dimention, id_barang, id_kemasan) 
                                        VALUES ('$berat', '$dimensi', (SELECT max(id_barang) FROM barang),
                                        (SELECT id_kemasan FROM kemasan WHERE kemasan='$kemasan' LIMIT 0,1))
                                     ");
        $transaksi = $this->db->query("
                                    INSERT INTO rpx.transaksi (awb, tanggal, biaya,
                                    id_pembayaran, id_barang, id_pengirim, id_penerima, kode_layanan, kode_perlakuan, kode_tambahan) 
                                    VALUES ('$awb', '$tanggal', '$biaya', 
                                        (SELECT id_pembayaran FROM pembayaran WHERE pembayaran LIKE '%$pembayaran%' LIMIT 0,1),
                                        (SELECT max(id_barang) FROM barang), 
                                        (SELECT id_pengirim FROM pengirim WHERE no_account='$no_acc' LIMIT 0,1), 
                                        (SELECT penerima.id_penerima FROM penerima,customer 
                                                WHERE penerima.id_customer=customer.id_customer 
                                                AND customer.telpon='$no_tel' LIMIT 0,1),
                                    '$kode_layanan', '$kode_perlakuan', '$kode_tambahan')");
    }
    
    function cari_sender($no_acc){
        $query = $this->db->query("SELECT id_pengirim FROM pengirim WHERE no_account='$no_acc'");
        return $query->result();
    }
    
    function cari_receiver($r_nama, $r_alamat, $r_telpon, $r_perusahaan){
        $query = $this->db->query("
                                    SELECT penerima.id_penerima 
                                    FROM customer, penerima 
                                    WHERE penerima.id_customer = customer.id_customer
                                    AND customer.nama = '$r_nama'
                                    AND customer.alamat = '$r_alamat'
                                    AND customer.telpon = '$r_telpon'
                                    AND customer.perusahaan = '$r_perusahaan'
                                   ");
    }
    
    function cari_receiver2($no_tel){
        $query = $this->db->query("SELECT id_penerima FROM customer, penerima
                                   WHERE customer.id_customer = penerima.id_customer AND customer.telpon = '$no_tel'");
        return $query->result();
    }

    function add_transaksi($awb, $sender, $receiver, $kode_layanan, $kode_tambahan, $kode_perlakuan, $pembayaran, $deskripsi, $nilai_barang, $berat, $kemasan, $biaya, $tanggal, $dimensi) {
        $barang = $this->db->query("INSERT INTO rpx.barang (deskripsi, nilai_barang) VALUES ('$deskripsi', '$nilai_barang')");
        $package = $this->db->query("INSERT INTO rpx.package (actual_weight, dimention, id_barang, id_kemasan) 
                   VALUES ('$berat', '$dimensi', (SELECT max(id_barang) FROM barang), '$kemasan')");
        $transaksi = $this->db->query("
                                    INSERT INTO rpx.transaksi (awb, tanggal, biaya, id_pembayaran, id_barang, 
                                    id_pengirim, id_penerima, kode_layanan, kode_perlakuan, kode_tambahan) 
                                    VALUES ('$awb', '$tanggal', '$biaya', '$pembayaran',
                                    (SELECT max(id_barang) FROM barang), 
                                    (SELECT id_pengirim FROM pengirim WHERE no_account='$sender' LIMIT 0,1), 
                                    (SELECT penerima.id_penerima FROM penerima,customer 
                                        WHERE penerima.id_customer=customer.id_customer 
                                        AND customer.nama='$receiver'
                                       LIMIT 0,1),
                                    '$kode_layanan', '$kode_perlakuan', '$kode_tambahan')");
    }

    function tampil_transaksi() {
        $query = $this->db->query("SELECT transaksi.id_transaksi, transaksi.awb, transaksi.tanggal, transaksi.id_penerima as receiver, transaksi.id_pengirim as sender FROM transaksi");
        return $query->result();
    }

    function tampil_sender() {
        $query = $this->db->query("SELECT customer.nama as nama, pengirim.no_account FROM pengirim, customer WHERE pengirim.customer_id_customer = customer.id_customer");
        return $query->result();
    }

    function tampil_receiver() {
        $query = $this->db->query("SELECT customer.nama as nama, customer.telpon as telpon FROM penerima, customer WHERE penerima.id_customer = customer.id_customer");
        return $query->result();
    }

    function tampil_layanan() {
        $query = $this->db->query("SELECT kode_layanan, layanan FROM layanan");
        return $query->result();
    }

    function tampil_tambahan() {
        $query = $this->db->query("SELECT * FROM layanantambahan");
        return $query->result();
    }

    function tampil_perlakuan() {
        $query = $this->db->query("SELECT * FROM perlakuan");
        return $query->result();
    }

    function tampil_pembayaran() {
        $query = $this->db->query("SELECT * FROM pembayaran");
        return $query->result();
    }

    function tampil_kemasan() {
        $query = $this->db->query("SELECT * FROM kemasan");
        return $query->result();
    }
    
    function detil_transaksi($id){
        $query = $this->db->query("SELECT transaksi.awb, transaksi.tanggal, transaksi.biaya, transaksi.id_pengirim, transaksi.id_penerima, transaksi.id_transaksi,
                 layanan.layanan, layanantambahan.tambahan,perlakuan.perlakuan, pembayaran.pembayaran, barang.deskripsi, barang.nilai_barang, barang.id_barang
                FROM transaksi, layanan, layanantambahan, perlakuan, pembayaran, barang
                WHERE id_transaksi='$id' AND transaksi.kode_layanan = layanan.kode_layanan AND transaksi.kode_tambahan = layanantambahan.kode_tambahan
                AND transaksi.kode_perlakuan = perlakuan.kode_perlakuan AND transaksi.id_pembayaran = pembayaran.id_pembayaran
                AND transaksi.id_barang = barang.id_barang");
        return $query->result();
    }
    
    function update_transaksi($id, $awb, $deskripsi, $nilai, $berat, $dimensi, $biaya, $id_barang){
        $transaksi = $this->db->query("UPDATE rpx.transaksi SET `awb` = '$awb', `biaya` = '$biaya' WHERE id_transaksi = '$id'");
        $barang = $this->db->query("UPDATE rpx.barang SET `deskripsi` = '$deskripsi', `nilai_barang` = '$nilai' WHERE id_barang = '$id_barang'");
        $package = $this->db->query("UPDATE rpx.package SET `actual_weight` = '$berat', `dimention` = '$dimensi' WHERE id_barang = '$id_barang'");
    }

    function hapus_transaksi($id) {
        $query = $this->db->query("DELETE barang, transaksi FROM transaksi LEFT JOIN barang USING (id_barang) WHERE transaksi.id_transaksi = '$id'");
    }

}

?>
