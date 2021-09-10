<?php



function function_konveksi_karyawan() {

	global $wpdb;
	$table_name   		= $wpdb->prefix . 'konveksi_apps_karyawan';
	$table_kasbon 		= $wpdb->prefix . 'konveksi_apps_kasbon';
	$table_masterjurnal = $wpdb->prefix . 'konveksi_acct_masterjurnal';
	$table_config 		= $wpdb->prefix . 'konveksi_config_genericmaster';

	$data['list-jabatan'] 	= $wpdb->get_results( "SELECT * FROM ". $table_config . " WHERE nama_generic_master='JABATAN_LIST'");

	$user = wp_get_current_user();
	$roles = ( array ) $user->roles;

	echo "<link rel='stylesheet' href='".plugin_dir_url( dirname( __FILE__ ) ) . "assets/css/bootstrap.css' media='all' />";
	echo "<link rel='stylesheet' href='".plugin_dir_url( dirname( __FILE__ ) ) . "assets/css/select2.min.css' media='all' />";

	echo "<script src='https://code.jquery.com/jquery-3.5.1.slim.min.js' integrity='sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj' crossorigin='anonymous'></script>";
    echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx' crossorigin='anonymous'></script>";
    echo "<script src='".plugin_dir_url( dirname( __FILE__ ) ) . "assets/js/select2.min.js'></script>";

	  if (isset($_POST['newsubmit'])) {
	  	$total_query = "SELECT COUNT(1)+1 FROM $table_name";
		$total = $wpdb->get_var( $total_query );

	  	$ls = $wpdb->get_var( "SELECT value_generic_master FROM ". $table_config . " WHERE jenis_generic_master='PREFIX_CODE_KARYAWAN'");
	  	$data['kode-karyawan'] =  $total < 100 ? $ls .'00'. $total  : $ls . $total;
	

	  	$kode_karyawan 		= $data['kode-karyawan'];
	  	$nama_karyawan 		= strtoupper($_POST['nama_karyawan']);
	  	$no_handphone    	= $_POST['no_handphone'];
	  	$email   			= strtolower($_POST['email']);
	  	$alamat 			= $_POST['alamat'];
	  	$gaji_bulanan		= $_POST['gaji_bulanan'];
	  	$limit_kasbon   	= $_POST['limit_kasbon'];
	  	$total_kasbon   	= 0;
	  	$jabatan			= $_POST['jabatan'];
	  	$status         	= '1';
	  	$created_by 		= $user->ID;
	  	$created_at			= date('Y-m-d H:i:s');

	  	$query ="
	  				INSERT INTO $table_name 
	  				(kode_karyawan, nama_karyawan,no_handphone, email, alamat, gaji_bulanan, limit_kasbon, total_kasbon, jabatan, status, created_by, created_at)
	  				VALUES
	  				('$kode_karyawan', '$nama_karyawan', '$no_handphone', '$email', '$alamat', '$gaji_bulanan', '$limit_kasbon', '$total_kasbon', '$jabatan', '$status', '$created_by', '$created_at')
	  			";

	    $wpdb->query($query);
	    echo "<script>location.replace('admin.php?page=konveksi-karyawan');</script>";

	  }

	  else if (isset($_POST['uptsubmit'])) {

	  	$id_pelanggan 		= $_POST['id_pelanggan'];
	  	$nama 				= strtoupper($_POST['nama']);
	  	$gender 			= $_POST['gender'];
	  	$no_telp_1 			= $_POST['no_handphone_1'];
	  	$no_telp_2 			= $_POST['no_handphone_2'];
	  	$email_1 			= strtolower($_POST['email_1']);
	  	$email_2 			= strtolower($_POST['email_2']);
	  	$alamat 			= $_POST['alamat'];
	  	$kota 				= $_POST['kota'];
	  	$kode_pos 			= $_POST['kode_pos'];
	  	$channel 			= $_POST['channel'];
	  	$updated_by 		= $user->ID;
	  	$updated_at			= date('Y-m-d H:i:s');	  	

	  	$query = "
	  				UPDATE $table_name 
	  				SET
	  					nama 		= '$nama',
	  					gender 		= '$gender',
	  					no_telp_1 	= '$no_telp_1',
	  					no_telp_2 	= '$no_telp_2',
	  					email_1 	= '$email_1',
	  					email_2 	= '$email_2',
	  					alamat 		= '$alamat',
	  					kota 		= '$kota',
	  					channel 	= '$channel',
	  					updated_by  = '$updated_by',
	  					updated_at  = '$updated_at'
	  				WHERE id_pelanggan = $id_pelanggan
	  			 ";
	  			 
	    $wpdb->query($query);
	    echo "<script>location.replace('admin.php?page=konveksi-pelanggan');</script>";

	  }
	  else if (isset($_POST['del'])) {

	  	$id 				= $_POST['id'];
	  	$updated_by 		= $user->ID;
	  	$updated_at			= date('Y-m-d H:i:s');	 

	    $del_id = $_GET['del'];
	    $wpdb->query("
	    				UPDATE $table_name 
	    				SET 
	    					status_pelanggan=2, 
	    					updated_by = '$updated_by',
	    					updated_at = '$updated_at'	
	    				WHERE id_pelanggan='$id'
	    			");

	    echo "<script>location.replace('admin.php?page=konveksi-pelanggan');</script>";

	  }
	  else if (isset($_GET['edit'])) {

	  	$id 				= $_GET['edit'];
	  	$data['pelanggan'] 	= $wpdb->get_results( "SELECT * FROM ". $table_name . " WHERE id_pelanggan='$id' LIMIT 1");

	    require_once(ABSPATH . 'wp-content/plugins/konveksi/view/pelanggan/edit.php');

	  }
	  else if (isset($_POST['search-submit'])) {

	  	$id 				= $_GET['edit'];
	  	$data['pelanggan'] 	= $wpdb->get_results( "SELECT * FROM ". $table_name . " WHERE id_pelanggan='$id' LIMIT 1");

	    require_once(ABSPATH . 'wp-content/plugins/konveksi/view/pelanggan/edit.php');

	  }
	  else if (isset($_GET['kas-bon'])) {

	  	$id 					= $_GET['kas-bon'];
	  	$data['karyawan'] 		= $wpdb->get_results( "SELECT * FROM ". $table_name . " WHERE kode_karyawan='$id' LIMIT 1");
	  	$data['kasbon'] 		= $wpdb->get_results( "SELECT A.*, B.nama_masterjurnal FROM ". $table_kasbon . " A LEFT JOIN ". $table_masterjurnal ." B ON A.tipe_akun = B.kode_masterjurnal WHERE kode_karyawan='$id' ORDER BY tanggal DESC");
	  	$data['masterjurnal'] 	= $wpdb->get_results( "SELECT * FROM ". $table_masterjurnal . " WHERE status=1");

	    require_once(ABSPATH . 'wp-content/plugins/konveksi/view/karyawan/kasbon.php');

	  }
	  else if (isset($_POST['kasbon-pembayaran'])) {

	  	$kode_karyawan 		= $_POST['kode_karyawan'];
	  	$tipe_akun   		= $_POST['akun'];
	  	$tanggal 			= $_POST['tanggal'];
	  	$nominal_kasbon  	= $_POST['nominal'];
	  	$pembayaran_kasbon	= $_POST['cicilan'];
	  	$keterangan			= $_POST['keterangan'];
	  	$updated_by 		= $user->ID;
	  	$updated_at			= date('Y-m-d H:i:s');	 

		$totaljum 			= $wpdb->get_var( " SELECT COUNT(1)+1 FROM $table_kasbon WHERE kode_karyawan='$kode_karyawan'" );
		$totalkasbon 		= $wpdb->get_var( " SELECT SUM(nominal_kasbon-pembayaran_kasbon) FROM $table_kasbon WHERE kode_karyawan='$kode_karyawan'" );
		$poscode			='1320';
		$saldo_kasbon		= $totalkasbon + $nominal_kasbon - $pembayaran_kasbon;
	  	$no_transaksi =  $total < 100 ? $kode_karyawan .'/'. $poscode . '/' .'00'. $totaljum  : $kode_karyawan .'/'. $poscode . '/' . $total;

	    $wpdb->query(" UPDATE $table_name SET total_kasbon = '$saldo_kasbon' WHERE kode_karyawan = '$kode_karyawan' ");
	  	$query ="
	  				INSERT INTO $table_kasbon 
	  				(no_transaksi, kode_karyawan,tanggal, nominal_kasbon, pembayaran_kasbon, keterangan, tipe_akun, created_by, created_at)
	  				VALUES
	  				('$no_transaksi', '$kode_karyawan', '$tanggal', '$nominal_kasbon', '$pembayaran_kasbon', '$keterangan', '$tipe_akun', '$created_by', '$created_at')
	  			";

	    $wpdb->query($query);

	    echo "<script>location.replace('admin.php?page=konveksi-karyawan&kas-bon=$kode_karyawan');</script>";

	  }
	  else {

		$items_per_page = 15;
		$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$offset = ( $page * $items_per_page ) - $items_per_page;

		$query = "
					SELECT *
					FROM $table_name
					WHERE status=1
				 ";

		$total_query = "SELECT COUNT(1)+1 FROM (${query}) AS combined_table";
		$total = $wpdb->get_var( $total_query );

		$results = $wpdb->get_results( $query.' ORDER BY kode_karyawan ASC LIMIT '. $offset.', '. $items_per_page, OBJECT );

	  	 require_once(ABSPATH . 'wp-content/plugins/konveksi/view/karyawan/index.php');
	  }	

	
}

?>