
CREATE
    /*[ALGORITHM = {UNDEFINED | MERGE | TEMPTABLE}]
    [DEFINER = { user | CURRENT_USER }]
    [SQL SECURITY { DEFINER | INVOKER }]*/
    VIEW `simkesbaru`.`v_hasiltransaksiapotek` 
    AS
    


SELECT
    `transaksi`.`id_transaksi`
    , `transaksi`.`tgl_transaksi`
    , `transaksi`.`tgl_kunjungan`
    , `transaksi_apotek`.`no_surat`
    , `transaksi_apotek`.`no_bukti`
    , `master_buku_besar`.`buku_besar`
    , `transaksi_apotek`.`restitusi`
    , `master_karyawan`.`nip`
    , `master_karyawan`.`nama_karyawan`
    , `master_tertanggung`.`nama_tertanggung`
    , `master_rujukan`.`nama_rujukan`
    , `master_dokter`.`nama_dokter`
    , `master_provider`.`nama_provider`
    , `transaksi_apotek`.`no_dak`
    , `transaksi_diagnosa`.`id_transaksi_diagnosa`
    , GROUP_CONCAT(`master_diagnosa`.`nama_diagnosa` SEPARATOR ",") AS nama_diagnosa
    , `rayon_karyawan`.`id_rayon`
    , `wilayah_karyawan`.`id_wilayah`
    , `mitra_karyawan`.`id_mitra`
    , `item_transaksi_apotek`.`id_item_transaksi_apotek`
    , harga_item
    , hrg_satuan
    , jumlah
     , (COALESCE(`total`,hrg_satuan * jumlah)) AS total
 --   , sum(total) as oke
  --  , total	
    , (harga_item * jumlah) AS koreksi
     , ((COALESCE(`total`,hrg_satuan * jumlah))-(harga_item * jumlah)) AS selisih
FROM
    `simkesbaru`.`transaksi_apotek`
    INNER JOIN `simkesbaru`.`transaksi` 
        ON (`transaksi_apotek`.`id_transaksi` = `transaksi`.`id_transaksi`)
    INNER JOIN `simkesbaru`.`master_tertanggung` 
        ON (`transaksi`.`id_tertanggung` = `master_tertanggung`.`id_tertanggung`)
    INNER JOIN `simkesbaru`.`master_karyawan` 
        ON (`master_tertanggung`.`id_karyawan` = `master_karyawan`.`id_karyawan`)
    INNER JOIN `simkesbaru`.`rayon_karyawan` 
        ON (`master_karyawan`.`id_rayon` = `rayon_karyawan`.`id_rayon`)
    INNER JOIN `simkesbaru`.`wilayah_karyawan` 
        ON (`rayon_karyawan`.`id_wilayah` = `wilayah_karyawan`.`id_wilayah`)
    INNER JOIN `simkesbaru`.`mitra_karyawan` 
        ON (`wilayah_karyawan`.`id_mitra` = `mitra_karyawan`.`id_mitra`)
    LEFT JOIN `simkesbaru`.`master_rujukan` 
        ON (`transaksi_apotek`.`id_rujukan` = `master_rujukan`.`id_rujukan`)
    INNER JOIN `simkesbaru`.`master_provider` 
        ON (`transaksi_apotek`.`id_provider` = `master_provider`.`id_provider`)
    LEFT JOIN `simkesbaru`.`master_dokter` 
        ON (`transaksi_apotek`.`id_dokter` = `master_dokter`.`id_dokter`)
    LEFT JOIN `simkesbaru`.`transaksi_diagnosa` 
        ON (`transaksi_diagnosa`.`id_transaksi` = `transaksi`.`id_transaksi`)
    LEFT JOIN `simkesbaru`.`master_diagnosa`  
        ON (`transaksi_diagnosa`.`id_diagnosa` = `master_diagnosa`.`id_diagnosa`)
    INNER JOIN `simkesbaru`.`item_transaksi_apotek` 
        ON (`item_transaksi_apotek`.`id_transaksi` = `transaksi`.`id_transaksi`)
    LEFT JOIN `simkesbaru`.`master_item` 
        ON (`item_transaksi_apotek`.`id_item` = `master_item`.`id_item`)
    LEFT JOIN `simkesbaru`.`master_buku_besar`
        ON ( `transaksi`.`id_transaksi` = `master_buku_besar`.`id_transaksi`)
      -- GROUP BY `id_transaksi` -- , `master_diagnosa`.`id_diagnosa`
	 GROUP BY  id_item_transaksi_apotek
	  	;