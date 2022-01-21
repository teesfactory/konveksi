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

					UNION ALL

					SELECT
						id_jurnal,
						tanggal,
						no_transaksi,
						CONCAT(keterangan_1, ' ~ ', nama_masterjurnal) as keterangan,
						nominal*-1 AS nominal,
						0 as sisa_pembayaran
					FROM wp_konveksi_acct_jurnal A
					LEFT JOIN wp_konveksi_acct_masterjurnal B ON A.kode_master_jurnal = B.kode_masterjurnal
					WHERE id_reference='006' AND sign='D'
				 ";

		$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
		$total = $wpdb->get_var( $total_query );

		$results = $wpdb->get_results( $query.' ORDER BY tanggal_transaksi DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );

	    require_once(ABSPATH . 'wp-content/plugins/konveksi/view/pengeluaran/daftar.php');

	}
	else if (isset($_GET['pg']) AND $_GET['pg'] <> 'daftar' ) {

		$page = $_GET['pg'];
		$data['active'] = 'class="current" aria-current="page"';
		$data['masterjurnal'] 	= $wpdb->get_results( "SELECT * FROM ". $table_masterjurnal . " WHERE status=1");

		if ($page == 'belanja-kaos'){

			$data['list-barang'] 	= $wpdb->get_results( "SELECT kode_barang AS id, nama_barang AS name FROM ". $table_barang . " WHERE pos_code IN ('3130','3141','3149','1511') ORDER BY kode_barang");
			$data['judul'] = 'Belanja Kaos';
			$data['poscode'] = '003';

			require_once(ABSPATH . 'wp-content/plugins/konveksi/view/pengeluaran/index.php');
		}
		else if ($page == 'belanja-bahan'){

			$data['list-barang'] 	= $wpdb->get_results( "SELECT kode_barang AS id, nama_barang AS name FROM ". $table_barang . " WHERE pos_code IN ('1520') ORDER BY kode_barang");
			$data['judul'] = 'Belanja Bahan';
			$data['poscode'] = '004';
			
			require_once(ABSPATH . 'wp-content/plugins/konveksi/view/pengeluaran/index.php');

		}
		else if ($page == 'biaya-operasional-produksi'){

			$data['list-barang'] 	= $wpdb->get_results( "SELECT kode_barang AS id, nama_barang AS name FROM ". $table_barang . " WHERE pos_code IN ('4110','4120','4130','4210','4231','4232','4239') ORDER BY kode_barang");
			$data['judul'] = 'Biaya Produksi & Operasional';
			$data['poscode'] = '005';
			
			require_once(ABSPATH . 'wp-content/plugins/konveksi/view/pengeluaran/index.php');
		}
		else if ($page == 'transfer-kas'){

			$data['list-barang'] 	= $wpdb->get_results( "SELECT kode_barang AS id, nama_barang AS name FROM ". $table_barang . " WHERE pos_code IN ('1100') ORDER BY kode_barang");
			$data['judul'] = 'Transfer Kas';
			$data['poscode'] = '006';
			
			require_once(ABSPATH . 'wp-content/plugins/konveksi/view/pengeluaran/transfer-kas.php');
		}	  	



	}
	else if (isset($_POST['submit-kas'])){
		
		$ls 				= $wpdb->get_var( "SELECT value_generic_master FROM ". $table_config . " WHERE jenis_generic_master='PREFIX_CODE_TRANSAKSI'");
		$users 				= $user->ID < 10 ? '0' . $user->ID : $user->ID ;

		$tanggal 			= $_POST['tanggal'];
		$dari 				= $_POST['dari'];
		$ke		 			= $_POST['ke'];
		$nominal			= $_POST['nominal'];
		$keterangan 		= $_POST['keterangan'];
		$poscode 			= $_POST['poscode'];
		$notrx 				= $ls . '/' .$_POST['poscode']. '/' . $users . '/' . date('Ymd',strtotime($_POST['tanggal'])) . '/' .rand(10,99);
		$created_by 		= $user->ID;
		$created_at			= date('Y-m-d H:i:s');		
		$query1		= "
						INSERT INTO wp_konveksi_acct_jurnal
							(tanggal, kode_master_jurnal, no_transaksi, id_reference, keterangan_1, keterangan_2, nominal, sign, created_by, created_at )
						VALUES ( 
									'". $tanggal ."', 
									'". $dari ."', 
									'". $notrx ."', 
									'". $poscode ."', 
									'SETOR KAS', 
									'". $keterangan ."',  
									'-". $nominal ."',
									'D', 
									'". $created_by ."',  
									'". $created_at ."'
						), 
						( 
									'". $tanggal ."', 
									'". $ke ."', 
									'". $notrx ."', 
									'". $poscode ."', 
									'SETOR KAS', 
									'". $keterangan ."',  
									'". $nominal ."',
									'K', 
									'". $created_by ."',  
									'". $created_at ."'
								)
					  ";
		//echo $query1 ;
		$wpdb->query($query1);

		echo "<script>location.replace('admin.php?page=konveksi-pengeluaran&pg=daftar');</script>";

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