<?php



	function function_konveksi_jurnal() {

		global $wpdb;
		$table_jurnal   			= $wpdb->prefix . 'konveksi_acct_jurnal';
		$table_masterjurnal 		= $wpdb->prefix . 'konveksi_acct_masterjurnal';
		$table_config 				= $wpdb->prefix . 'konveksi_config_genericmaster';
		$table_pelanggan			= $wpdb->prefix . 'konveksi_apps_pelanggan';
		$user 						= wp_get_current_user();

		$data['list-kota'] 			= $wpdb->get_results( "SELECT jenis_generic_master AS id, value_generic_master AS name FROM ". $table_config . " WHERE nama_generic_master='KOTA_LIST' ORDER BY jenis_generic_master");
		$data['list-channel'] 		= $wpdb->get_results( "SELECT jenis_generic_master AS id, value_generic_master AS name FROM ". $table_config . " WHERE nama_generic_master='CHANNEL_LIST' ORDER BY jenis_generic_master");
		$data['list-segmen'] 		= $wpdb->get_results( "SELECT jenis_generic_master AS id, value_generic_master AS name FROM ". $table_config . " WHERE nama_generic_master='SEGMENT_LIST' ORDER BY jenis_generic_master");
		$data['list-jurnal']		= $wpdb->get_results( "SELECT kode_masterjurnal AS id, nama_masterjurnal AS name FROM " . $table_masterjurnal ." ORDER BY kode_masterjurnal" );
		
		echo "<link rel='stylesheet' href='".plugin_dir_url( dirname( __FILE__ ) ) . "assets/css/bootstrap.css' media='all' />";
		echo "<link rel='stylesheet' href='".plugin_dir_url( dirname( __FILE__ ) ) . "assets/css/select2.min.css' media='all' />";

		echo "<script src='https://code.jquery.com/jquery-3.5.1.slim.min.js' integrity='sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj' crossorigin='anonymous'></script>";
	    echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx' crossorigin='anonymous'></script>";
	    echo "<script src='".plugin_dir_url( dirname( __FILE__ ) ) . "assets/js/select2.min.js'></script>";

    
		if (isset($_GET['create'])) {

			require_once(ABSPATH . 'wp-content/plugins/konveksi/view/jurnal/create.php');	

		} 
		else if (isset($_POST['newsubmit'])) {

			require_once(ABSPATH . 'wp-content/plugins/konveksi/view/jurnal/create.php');	

		}else {

			$items_per_page = 15;
			$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
			$offset = ( $page * $items_per_page ) - $items_per_page;

			$query = "
						SELECT *
						FROM $table_name
					 ";

			$total_query = "SELECT COUNT(1)+1 FROM (${query}) AS combined_table";
			$total = $wpdb->get_var( $total_query );

			$results = $wpdb->get_results( $query.' ORDER BY id_jurnal ASC LIMIT '. $offset.', '. $items_per_page, OBJECT );

		  	 require_once(ABSPATH . 'wp-content/plugins/konveksi/view/jurnal/index.php');			

		}

	}

?>