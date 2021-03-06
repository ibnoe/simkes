
CREATE
    /*[ALGORITHM = {UNDEFINED | MERGE | TEMPTABLE}]
    [DEFINER = { user | CURRENT_USER }]
    [SQL SECURITY { DEFINER | INVOKER }]*/
    VIEW `simkesbaru`.`v_hasiltransaksidak` 
    AS
SELECT
    `transaksi`.`id_transaksi`
    , `transaksi`.`tgl_transaksi`
    , `transaksi`.`tgl_kunjungan`
    , `jenis_kunjungan`.`idjenis_kunjungan`
    , `jenis_kunjungan`.`nama_kunjungan`
    , `transaksi_dak`.`no_bukti`
    , `master_karyawan`.`nip`
    , `master_karyawan`.`nama_karyawan`
    , `master_tertanggung`.`nama_tertanggung`
    , `master_rujukan`.`id_rujukan`
    , `master_rujukan`.`nama_rujukan`
    , `master_dokter`.`nama_dokter`
    , `periksa_dak`.`anamnesis`
    , `periksa_dak`.`kondisi`
    , `periksa_dak`.`kesadaran`
    , `periksa_dak`.`suhu`
    , `periksa_dak`.`berat`
    , `periksa_dak`.`tinggi`
    , `periksa_dak`.`nadi`
    , `periksa_dak`.`sistole`
    , `periksa_dak`.`diastole`
    , `periksa_dak`.`pernafasan`
    , `periksa_dak`.`riwayat_alergi`
    , GROUP_CONCAT(`master_diagnosa`.`nama_diagnosa` SEPARATOR ",") AS nama_diagnosa,
  `rayon_karyawan`.`id_rayon`             AS `id_rayon`,
  `wilayah_karyawan`.`id_wilayah`         AS `id_wilayah`,
  `mitra_karyawan`.`id_mitra`             AS `id_mitra`
FROM
    `simkesbaru`.`transaksi_dak`
    INNER JOIN `simkesbaru`.`transaksi` 
        ON (`transaksi_dak`.`id_transaksi` = `transaksi`.`id_transaksi`)
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
        ON (`transaksi_dak`.`id_rujukan` = `master_rujukan`.`id_rujukan`)
    LEFT JOIN `simkesbaru`.`master_dokter` 
        ON (`transaksi_dak`.`id_dokter` = `master_dokter`.`id_dokter`)
    LEFT JOIN `simkesbaru`.`periksa_dak` 
        ON (`periksa_dak`.`id_transaksi` = `transaksi`.`id_transaksi`)
    LEFT JOIN `simkesbaru`.`jenis_kunjungan` 
        ON (`periksa_dak`.`idjenis_kunjungan` = `jenis_kunjungan`.`idjenis_kunjungan`)
    LEFT JOIN `simkesbaru`.`transaksi_diagnosa` 
        ON (`transaksi_diagnosa`.`id_transaksi` = `transaksi`.`id_transaksi`)
    LEFT JOIN `simkesbaru`.`master_diagnosa` 
        ON (`transaksi_diagnosa`.`id_diagnosa` = `master_diagnosa`.`id_diagnosa`)
    GROUP BY `id_transaksi`        
        ;