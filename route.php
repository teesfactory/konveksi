<?php
require_once('libraries/dompdf/autoload.inc.php');

include('controller/pelanggan_controller.php');
include('controller/karyawan_controller.php');
include('controller/penjualan_controller.php');
include('controller/pengeluaran_controller.php');
include('controller/jurnal_controller.php');
include('controller/tracking_controller.php');
include('controller/bagi_hasil_controller.php');




// Menu Pelanggan
function konveksi_master() {
	$user = wp_get_current_user();
	$roles = ( array ) $user->roles;

	add_menu_page('Konveksi','Konveksi','edit_pages','konveksi','function_konveksi_master','dashicons-category');
	add_submenu_page('konveksi','Pelanggan','Manage Pelanggan','edit_pages','konveksi-pelanggan','function_konveksi_pelanggan');

	if ( $roles[0] == 'administrator' ) {

	add_submenu_page('konveksi','Karyawan','Manage Karyawan','edit_pages','konveksi-karyawan','function_konveksi_karyawan');
	add_submenu_page('konveksi','Pengeluaran','Pengeluaran','edit_pages','konveksi-pengeluaran','function_konveksi_pengeluaran');
	//add_submenu_page('konveksi','Jurnal','Jurnal','edit_pages','konveksi-jurnal','function_konveksi_jurnal');
	//add_submenu_page('konveksi','Konfigurasi','Konfigurasi','edit_pages','konveksi-konfigurasi','function_konveksi_konfigurasi');
	
	}
	
	add_submenu_page('konveksi','Penjualan','Penjualan','edit_pages','konveksi-penjualan','function_konveksi_penjualan');
	add_submenu_page('konveksi','Bagi Hasil','Bagi Hasil','edit_pages','konveksi-bagi-hasil','function_konveksi_bagi_hasil');
	add_submenu_page('konveksi','Tracking Progress','Tracking Progress','edit_pages','konveksi-tracking-progress','function_konveksi_tracking_progress');

}
add_action('admin_menu','konveksi_master');


function konveksi_form_simulasi_harga(){
    return 'Follow us on <a rel="nofollow" href="https://www.facebook.com/ThemeXpert/">Facebook</a>';
}
add_shortcode('simulasi-harga', 'konveksi_form_simulasi_harga'); 


?>