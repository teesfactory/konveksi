<?php



function function_konveksi_pelanggan() {

	global $wpdb;
	$table_name   = $wpdb->prefix . 'konveksi_apps_pelanggan';
	$table_config = $wpdb->prefix . 'konveksi_config_genericmaster';


	$data['list-kota'] 		= $wpdb->get_results( "SELECT * FROM ". $table_config . " WHERE nama_generic_master='KOTA_LIST'");
	$data['list-channel'] 	= $wpdb->get_results( "SELECT * FROM ". $table_config . " WHERE nama_generic_master='CHANNEL_LIST'");
	$data['list-segmen'] 	= $wpdb->get_results( "SELECT * FROM ". $table_config . " WHERE nama_generic_master='SEGMENT_LIST'");
	$data['list-gender'] 	= $wpdb->get_results( "SELECT * FROM ". $table_config . " WHERE nama_generic_master='GENDER_LIST'");

	$user = wp_get_current_user();

	echo "<link rel='stylesheet' href='".plugin_dir_url( dirname( __FILE__ ) ) . "assets/css/bootstrap.css' media='all' />";
	echo "<link rel='stylesheet' href='".plugin_dir_url( dirname( __FILE__ ) ) . "assets/css/select2.min.css' media='all' />";

	echo "<script src='https://code.jquery.com/jquery-3.5.1.slim.min.js' integrity='sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj' crossorigin='anonymous'></script>";
    echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx' crossorigin='anonymous'></script>";
    echo "<script src='".plugin_dir_url( dirname( __FILE__ ) ) . "assets/js/select2.min.js'></script>";

	  if (isset($_POST['newsubmit'])) {

	  	$ls = $wpdb->get_var( "SELECT value_generic_master FROM ". $table_config . " WHERE jenis_generic_master='PREFIX_CODE_PELANGGAN'");
		$total = $wpdb->get_var( "SELECT COUNT(1)+1 AS jum FROM ". $table_name . " WHERE tipe_account='PL'");
	  	$data['kode-pelanggan'] =  $total < 1000 ? $ls .'0'. $total   : $ls . $total ;
	

	  	$no_pelanggan 		= $data['kode-pelanggan'];
	  	$nama 		 		= strtoupper($_POST['nama']);
	  	$gender 			= $_POST['gender'];
	  	$no_telp_1 			= $_POST['no_handphone_1'];
	  	$no_telp_2 			= $_POST['no_handphone_2'];
	  	$email_1 			= strtolower($_POST['email_1']);
	  	$email_2 			= strtolower($_POST['email_2']);
	  	$alamat 			= $_POST['alamat'];
	  	$kota 				= $_POST['kota'];
	  	$kode_pos 			= $_POST['kode_pos'];
	  	$channel 			= $_POST['channel'];
	  	$tipe_account		= 'PL';
	  	$status_pelanggan	= '1';
	  	$created_by 		= $user->ID;
	  	$created_at			= date('Y-m-d H:i:s');

	  	$query ="
	  				INSERT INTO $table_name 
	  				(no_pelanggan, nama,gender, no_telp_1, no_telp_2, email_1, email_2, alamat, kota, kode_pos, channel, tipe_account, status_pelanggan, created_by, created_at)
	  				VALUES
	  				('$no_pelanggan', '$nama', '$gender', '$no_telp_1', '$no_telp_2', '$email_1', '$email_2', '$alamat', '$kota', '$kode_pos', '$channel', '$tipe_account', '$status_pelanggan', '$created_by', '$created_at')
	  			";

	    $wpdb->query($query);
	    echo "<script>location.replace('admin.php?page=konveksi-pelanggan');</script>";

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
	  	//echo $query;
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
	  else {

		$items_per_page = 15;
		$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$offset = ( $page * $items_per_page ) - $items_per_page;

		$query = "
					SELECT A.*, B.value_generic_master AS kota_desc 
					FROM $table_name A 
					LEFT JOIN $table_config B ON A.kota = B.jenis_generic_master 
					WHERE tipe_account='PL' AND status_pelanggan=1
				 ";

		$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
		$total = $wpdb->get_var( $total_query );

		$results = $wpdb->get_results( $query.' ORDER BY id_pelanggan DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );

	  	 require_once(ABSPATH . 'wp-content/plugins/konveksi/view/pelanggan/index.php');
	  }	
	
}

?>