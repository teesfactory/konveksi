<?php

function function_konveksi_bagi_hasil() {

	global $wpdb;
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
                    -- pemasukan
                    SELECT
                        a.tanggal_transaksi,
                        c.nama_order,
                        d.display_name as marketing,
                        a.total_akhir as pendapatan,
                        b.hpp,
                        a.total_akhir - b.hpp as gross_profit,
                        (a.total_akhir - b.hpp) * 0.3 as operasional,
                        (a.total_akhir - b.hpp) * 0.25 as equity,
                        (a.total_akhir - b.hpp) * 0.25 as production,
                        (a.total_akhir - b.hpp) * 0.2 as marketing
                    FROM wp_konveksi_apps_transaksi_header a
                    LEFT JOIN wp_konveksi_apps_transaksi_addinfo c on a.no_transaksi = c.no_transaksi
                    LEFT JOIN (
                    
                    -- pengeluaran
                        SELECT 
                            no_transaksi_ref, 
                            sum(total_akhir) as hpp 
                        FROM wp_konveksi_apps_transaksi_header A
                        LEFT JOIN wp_konveksi_apps_transaksi_addinfo B ON A.no_transaksi = B.no_transaksi
                        WHERE pos_code IN ('003','004','005') AND B.no_transaksi_ref IN (
                        SELECT xx.no_transaksi FROM wp_konveksi_apps_transaksi_header xx WHERE pos_code IN ('001','002')
                        )

                        ) b on a.no_transaksi = b.no_transaksi_ref
                    LEFT JOIN wp_users d on a.created_by = d.ID
                    WHERE a.pos_code IN ('001','002')
				 ";

		$total_query = "SELECT COUNT(1) FROM ($query) AS combined_table";
		$total = $wpdb->get_var( $total_query );

		$results = $wpdb->get_results( $query.' ORDER BY tanggal_transaksi DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );
        
        require_once(ABSPATH . 'wp-content/plugins/konveksi/view/bagi_hasil/index.php');
    

}

?>