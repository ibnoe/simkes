<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_view_hasildokter extends CI_Model {
	function __construct() 
	{
        parent::__construct();
        }

        function countDiagnosa($id_transaksi)
        {
            $this->db->where('id_transaksi',$id_transaksi);
            $jumlah= $this->db->get('v_hasiltransaksidokter');
            return $jumlah->num_rows();
        }

        function getDiagnosa($id_transaksi)
        {
            $this->db->select('id_transaksi_diagnosa,nama_diagnosa');
            $this->db->where('id_transaksi',$id_transaksi);
            return $this->db->get('v_diagnosa');
        }
        function countItem($id_transaksi)
        {
            $this->db->where('id_transaksi',$id_transaksi);
            $jumlah= $this->db->get('v_detail_item_transaksidokter');
            return $jumlah->num_rows();
        }

        function getItem($id_transaksi)
        {
            $this->db->where('id_transaksi',$id_transaksi);
            return $jumlah= $this->db->get('v_detail_item_transaksidokter');

        }
	
	
}