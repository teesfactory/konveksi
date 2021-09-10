<?php



function function_konveksi_pengeluaran() {

	global $wpdb;
	$table_name   		= $wpdb->prefix . 'konveksi_apps_pelanggan';
	$table_pelanggan	= $wpdb->prefix . 'konveksi_apps_pelanggan';
	$table_config 		= $wpdb->prefix . 'konveksi_config_genericmaster';
	$table_masterjurnal = $wpdb->prefix . 'konveksi_acct_masterjurnal';
	$table_barang 		= $wpdb->prefix . 'konveksi_apps_barang';
	$table_trx_detail   = $wpdb->prefix . 'konveksi_apps_transaksi_detail';
	$table_trx_header   = $wpdb->prefix . 'konveksi_apps_transaksi_header';
	$table_trx_addinfo  = $wpdb->prefix . 'konveksi_apps_transaksi_addinfo';


	$data['list-kota'] 			= $wpdb->get_results( "SELECT * FROM ". $table_config . " WHERE nama_generic_master='KOTA_LIST' ORDER BY jenis_generic_master");
	$data['list-channel'] 		= $wpdb->get_results( "SELECT * FROM ". $table_config . " WHERE nama_generic_master='CHANNEL_LIST' ORDER BY jenis_generic_master");
	$data['list-segmen'] 		= $wpdb->get_results( "SELECT * FROM ". $table_config . " WHERE nama_generic_master='SEGMENT_LIST' ORDER BY jenis_generic_master");
	$data['list-gender'] 		= $wpdb->get_results( "SELECT * FROM ". $table_config . " WHERE nama_generic_master='GENDER_LIST' ORDER BY jenis_generic_master");
	$data['list-pelanggan'] 	= $wpdb->get_results( "SELECT * FROM ". $table_pelanggan . " WHERE status_pelanggan='1' AND tipe_account='SP'");

	$user = wp_get_current_user();

	echo "<link rel='stylesheet' href='".plugin_dir_url( dirname( __FILE__ ) ) . "assets/css/bootstrap.css' media='all' />";
	echo "<link rel='stylesheet' href='".plugin_dir_url( dirname( __FILE__ ) ) . "assets/css/select2.min.css' media='all' />";

	echo "<script src='https://code.jquery.com/jquery-3.5.1.slim.min.js' integrity='sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj' crossorigin='anonymous'></script>";
    echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx' crossorigin='anonymous'></script>";
    echo "<script src='".plugin_dir_url( dirname( __FILE__ ) ) . "assets/js/select2.min.js'></script>";

	if (isset($_GET['pg']) AND $_GET['pg'] == 'daftar' ) {

		$items_per_page = 15;
		$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$offset = ( $page * $items_per_page ) - $items_per_page;

		$query = "
					SELECT
						A.id_transaksi,
						A.tanggal_transaksi,
						A.no_transaksi,
						B.nama_order,
						A.total_akhir,
						A.sisa_pembayaran
					FROM $table_trx_header A
					LEFT JOIN $table_trx_addinfo B ON A.no_transaksi = B.no_transaksi
					WHERE A.pos_code IN ('003','004')
				 ";

		$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
		$total = $wpdb->get_var( $total_query );

		$results = $wpdb->get_results( $query.' ORDER BY tanggal_transaksi DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );

	    require_once(ABSPATH . 'wp-content/plugins/konveksi/view/pengeluaran/daftar.php');

	}
	else if (isset($_GET['pg']) AND $_GET['pg'] <> 'daftar' ) {

		$page = $_GET['pg'];
		$data['active'] = 'class="current" aria-current="page"';

		if ($page == 'belanja-kaos'){

			$data['list-barang'] 	= $wpdb->get_results( "SELECT kode_barang AS id, nama_barang AS name FROM ". $table_barang . " WHERE pos_code IN ('3130','3141','3149') ORDER BY kode_barang");
			$data['judul'] = 'Belanja Kaos';
			$data['poscode'] = '003';
		}
		else if ($page == 'belanja-bahan'){

			$data['list-barang'] 	= $wpdb->get_results( "SELECT kode_barang AS id, nama_barang AS name FROM ". $table_barang . " WHERE pos_code IN ('1520') ORDER BY kode_barang");
			$data['judul'] = 'Belanja Bahan';
			$data['poscode'] = '004';

		}
		else if ($page == 'biaya-operasional-produksi'){

			$data['list-barang'] 	= $wpdb->get_results( "SELECT kode_barang AS id, nama_barang AS name FROM ". $table_barang . " WHERE pos_code IN ('4110','4120','4130','4210','4231','4232','4239') ORDER BY kode_barang");
			$data['judul'] = 'Biaya Produksi & Operasional';
			$data['poscode'] = '005';
		}
		else if ($page == 'transfer-kas'){

			$data['list-barang'] 	= $wpdb->get_results( "SELECT kode_barang AS id, nama_barang AS name FROM ". $table_barang . " WHERE pos_code IN ('1100') ORDER BY kode_barang");
			$data['judul'] = 'Transfer Kas';
			$data['poscode'] = '006';
		}

	  	$data['masterjurnal'] 	= $wpdb->get_results( "SELECT * FROM ". $table_masterjurnal . " WHERE status=1");

	  	require_once(ABSPATH . 'wp-content/plugins/konveksi/view/pengeluaran/index.php');

	}
	else {
		
		$items_per_page = 15;
		$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$offset = ( $page * $items_per_page ) - $items_per_page;

		$query = "
					SELECT
						A.id_transaksi,
						A.tanggal_transaksi,
						A.no_transaksi,
						B.nama_order,
						A.total_akhir,
						A.sisa_pembayaran
					FROM $table_trx_header A
					LEFT JOIN $table_trx_addinfo B ON A.no_transaksi = B.no_transaksi
					WHERE A.pos_code IN ('003','004','005','006')
				 ";

		$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
		$total = $wpdb->get_var( $total_query );

		$results = $wpdb->get_results( $query.' ORDER BY tanggal_transaksi DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );

	    require_once(ABSPATH . 'wp-content/plugins/konveksi/view/pengeluaran/daftar.php');

	}	
	
}

?>