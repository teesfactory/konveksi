<?php

	function function_konveksi_tracking_progress() {

		$user = wp_get_current_user();

		echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">';
		echo "<link rel='stylesheet' href='".plugin_dir_url( dirname( __FILE__ ) ) . "assets/css/select2.min.css' media='all' />";
	
		echo "<script src='https://code.jquery.com/jquery-3.5.1.slim.min.js' integrity='sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj' crossorigin='anonymous'></script>";
		echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx' crossorigin='anonymous'></script>";
		echo "<script src='".plugin_dir_url( dirname( __FILE__ ) ) . "assets/js/select2.min.js'></script>";

		$items_per_page = 15;
		$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$offset = ( $page * $items_per_page ) - $items_per_page;

		$query = "
					SELECT
						a.pengambilan as dateline,
						a.no_transaksi,
						c.display_name as marketing,
						d.nama as cust,
						b.nama_order,
						b.work_order,
						b.film,
						b.jahit,
						b.sablon,
						b.packing,
						b.finish
					FROM wp_konveksi_apps_transaksi_header a
					LEFT JOIN wp_konveksi_apps_transaksi_addinfo b ON a.no_transaksi = b.no_transaksi
					LEFT JOIN wp_users c on a.created_by = c.ID
					LEFT JOIN wp_konveksi_apps_pelanggan d on a.no_pelanggan = d.no_pelanggan
					WHERE pos_code IN ('001','002')
				 ";

		$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
		$total = $wpdb->get_var( $total_query );

		$results = $wpdb->get_results( $query.' ORDER BY pengambilan DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );

	  	 require_once(ABSPATH . 'wp-content/plugins/konveksi/view/tracking/index.php');

	}

?>