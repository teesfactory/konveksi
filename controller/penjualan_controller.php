<?php

use Dompdf\Dompdf;

function function_konveksi_penjualan() {


	$dompdf = new Dompdf();

	global $wpdb;
	$table_name   				= $wpdb->prefix . 'konveksi_apps_pelanggan';
	$table_pelanggan			= $wpdb->prefix . 'konveksi_apps_pelanggan';
	$table_config 				= $wpdb->prefix . 'konveksi_config_genericmaster';
	$table_masterjurnal 	 	= $wpdb->prefix . 'konveksi_acct_masterjurnal';
	$table_barang 			 	= $wpdb->prefix . 'konveksi_apps_barang';
	$table_trx_detail   	 	= $wpdb->prefix . 'konveksi_apps_transaksi_detail';
	$table_trx_header   	 	= $wpdb->prefix . 'konveksi_apps_transaksi_header';
	$table_trx_addinfo  	 	= $wpdb->prefix . 'konveksi_apps_transaksi_addinfo';
	$table_detailpembayaran  	= $wpdb->prefix . 'konveksi_apps_detailpembayaran';


	$data['list-kota'] 			= $wpdb->get_results( "SELECT * FROM ". $table_config . " WHERE nama_generic_master='KOTA_LIST' ORDER BY jenis_generic_master");
	$data['list-channel'] 		= $wpdb->get_results( "SELECT * FROM ". $table_config . " WHERE nama_generic_master='CHANNEL_LIST' ORDER BY jenis_generic_master");
	$data['list-segmen'] 		= $wpdb->get_results( "SELECT * FROM ". $table_config . " WHERE nama_generic_master='SEGMENT_LIST' ORDER BY jenis_generic_master");
	$data['list-gender'] 		= $wpdb->get_results( "SELECT * FROM ". $table_config . " WHERE nama_generic_master='GENDER_LIST' ORDER BY jenis_generic_master");
	$data['list-pelanggan'] 	= $wpdb->get_results( "SELECT * FROM ". $table_pelanggan . " WHERE status_pelanggan='1' AND tipe_account='PL'");

	$user = wp_get_current_user();

	echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">';
	echo "<link rel='stylesheet' href='".plugin_dir_url( dirname( __FILE__ ) ) . "assets/css/select2.min.css' media='all' />";

	echo "<script src='https://code.jquery.com/jquery-3.5.1.slim.min.js' integrity='sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj' crossorigin='anonymous'></script>";
    echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx' crossorigin='anonymous'></script>";
    echo "<script src='".plugin_dir_url( dirname( __FILE__ ) ) . "assets/js/select2.min.js'></script>";

	if (isset($_POST['newsubmit'])) {

	  	$ls = $wpdb->get_var( "SELECT value_generic_master FROM ". $table_config . " WHERE jenis_generic_master='PREFIX_CODE_TRANSAKSI'");
	  	$users = $user->ID < 10 ? '0' . $user->ID : $user->ID ;
	  	
	
	  	//echo json_encode($_POST['datadetail']);
	  	$notrx 				= $ls . '/' .$_POST['poscode']. '/' . $users . '/' . date('Ymd',strtotime($_POST['tanggal'])) . '/' .rand(10,99);
	  	$tanggal			= $_POST['tanggal'];
	  	$pengambilan 		= $_POST['pengambilan'];
	  	$akun 				= $_POST['akun'];
	  	$pelanggan 			= $_POST['pelanggan'];
	  	$ccy 				= $wpdb->get_var( "SELECT value_generic_master FROM ". $table_config . " WHERE nama_generic_master='CONFIG_APPS' jenis_generic_master='CCY' LIMIT 0,1");
	  	$keterangan 		= $_POST['keterangan'];
	  	$subtotal 			= $_POST['subtotal'];
	  	$potongan 			= $_POST['potongan'];
	  	$pajak 				= 0;
	  	$biayapengiriman	= $_POST['biayapengiriman'];
	  	$biayalain 			= $_POST['biayalain'];
	  	$totalakhir			= $_POST['subtotal'] + $_POST['biayapengiriman'] + $_POST['biayalain'] - $_POST['potongan'];
	  	$pembayaran			= $_POST['pembayaran'];
	  	$pembayaran_ke 		= 1;
	  	$cara_bayar 		= $pembayaran < $totalakhir ? 'KR' : 'TN';
	  	$jumlah_tunai 		= $cara_bayar == 'TN' ? $pembayaran : 0;
	  	$jumlah_kredit 		= $cara_bayar == 'KR' ? $pembayaran : 0;
	  	$total_pembayaran 	= $pembayaran;
	  	$sisa_pembayaran 	= $cara_bayar == 'TN' ? 0 : $totalakhir - $pembayaran;
	  	$status 			= 1;
	  	$pos_code 			= $_POST['poscode']; // penjualan kaos & sablon
	  	$channel 			= $_POST['channel'];
	  	$segment 			= $_POST['segment'];
	  	$refno 				= $_POST['refno'];
	  	$ordername 			= $_POST['ordername'];
	  	$catatan 			= $_POST['catatan'];
	  	$created_by 		= $user->ID;
	  	$created_at			= date('Y-m-d H:i:s');	 	

	  	$datas = json_decode( stripslashes($_POST['datadetail']));

        foreach ($datas as $row)
          {
            if ( $row[0] > 0 && $row[1] !='' && $row[3] > 0 ){
                $dataDetail[] = [
                  'NoTransaksiPenjualan' => $notrx ,
                  'KodeBarang'           => $row[1],
                  'Jumlah'               => $row[0],
                  'Harga'                => $row[3],
                  'Subtotal'             => $row[0] * $row[3],
                  'Sign'                 => 'D',
                  'Keterangan'           => $row[2],
                  'CreatedBy'            => $user->ID,
                  'CreatedAt'            => date('Y-m-d H:i:s')
                ];
            }
        }  	

	  	foreach ($dataDetail as $row) {

			$query = " INSERT INTO $table_trx_detail 
					   	( no_transaksi, kode_barang, jumlah, harga, subtotal, sign, keterangan, created_by, created_at )
					   VALUES 
					   		( '". $row['NoTransaksiPenjualan'] ."', '" . $row['KodeBarang'] . "', '". $row['Jumlah'] ."', '". $row['Harga'] ."',
					   		   '". $row['Subtotal'] ."', '" .$row['Sign']. "', '" .$row['Keterangan']. "', '" .$row['CreatedBy']. "', '" .$row['CreatedAt']. "'
					   		   )";
			//echo $query;			   		   
            $wpdb->query($query);

        }

        $query = "
        			INSERT INTO $table_trx_header
        			( no_transaksi, tanggal_transaksi, pengambilan, tipe, no_pelanggan, mata_uang, keterangan, sub_total, potongan, pajak, 
        			biaya_pengiriman, biaya_lain, total_akhir, cara_bayar, jumlah_tunai, jumlah_kredit, total_pembayaran, 
        			sisa_pembayaran, status_progress, pos_code, created_by, created_at )
        			VALUES
        			( '".$notrx."', '".$tanggal."', '".$pengambilan."', '".$akun."', '".$pelanggan."', '".$ccy."',
        			  '".$keterangan."', '".$subtotal."', '".$potongan."', '".$pajak."', '".$biayapengiriman."', 
        			  '".$biayalain."', '".$totalakhir."', '".$cara_bayar."', '".$jumlah_tunai."', '".$jumlah_kredit."',
        			  '".$total_pembayaran."', '".$sisa_pembayaran."', '".$status."', '".$pos_code."', '".$created_by."',  '".$created_at."'
        			 )
        		 ";

        $query2 = "
        			INSERT INTO $table_trx_addinfo
        			(no_transaksi, no_transaksi_ref, nama_order, channel, segment, catatan_order, created_by, created_at)
        			VALUES
        			( '" .$notrx. "', '" .$refno. "', '" .$ordername. "',  '" .$channel. "', '" .$segment. "', '" .$catatan. "', '" .$created_by. "', '" .$created_at. "' )
        		  ";
       	$query3 = "
       				INSERT INTO $table_detailpembayaran
       				(no_transaksi, no_pelanggan, pembayaran_ke, tanggal_pembayaran, nominal_pembayaran, akun_pembayaran, keterangan, created_by, created_at)
       				VALUES
       				( '" .$notrx. "', '".$pelanggan."', '".$pembayaran_ke."', '".$tanggal."', '".$pembayaran."', '".$akun."', '".$ordername."', '".$created_by."',  '".$created_at."')
       			  ";
        $wpdb->query($query);
        $wpdb->query($query2);
        $wpdb->query($query3);

        echo "<script>location.replace('admin.php?page=konveksi-penjualan&pg=daftar');</script>";

	}

	else if (isset($_POST['uptsubmit'])) {

	  	$notrx 				= $_POST['no_transaksi'];
	  	$tanggal			= $_POST['tanggal'];
	  	$pengambilan 		= $_POST['pengambilan'];
	  	$akun 				= $_POST['akun'];
	  	$pelanggan 			= $_POST['pelanggan'];
	  	$ccy 				= $wpdb->get_var( "SELECT value_generic_master FROM ". $table_config . " WHERE nama_generic_master='CONFIG_APPS' jenis_generic_master='CCY' LIMIT 0,1");
	  	$keterangan 		= $_POST['keterangan'];
	  	$subtotal 			= $_POST['subtotal'];
	  	$potongan 			= $_POST['potongan'];
	  	$pajak 				= 0;
	  	$biayapengiriman	= $_POST['biayapengiriman'];
	  	$biayalain 			= $_POST['biayalain'];
	  	$totalakhir			= $_POST['subtotal'] + $_POST['biayapengiriman'] + $_POST['biayalain'] - $_POST['potongan'];
	  	$pembayaran			= $_POST['pembayaran'];
	  	$pembayaran_ke		= 1;
	  	$cara_bayar 		= $pembayaran < $totalakhir ? 'KR' : 'TN';
	  	$jumlah_tunai 		= $cara_bayar == 'TN' ? $pembayaran : 0;
	  	$jumlah_kredit 		= $cara_bayar == 'KR' ? $pembayaran : 0;
	  	$total_pembayaran 	= $pembayaran;
	  	$sisa_pembayaran 	= $cara_bayar == 'TN' ? 0 : $totalakhir - $pembayaran;
	  	$status 			= 1;
	  	$pos_code 			= $_POST['poscode']; // penjualan kaos & sablon
	  	$channel 			= $_POST['channel'];
	  	$segment 			= $_POST['segment'];
	  	$refno 				= $_POST['refno'];
	  	$ordername 			= $_POST['ordername'];
	  	$catatan 			= $_POST['catatan'];
	  	$updated_by 		= $user->ID;
	  	$updated_at			= date('Y-m-d H:i:s');	 	

	  	$datas = json_decode( stripslashes($_POST['datadetail']));

        foreach ($datas as $row)
          {
            if ( $row[0] > 0 && $row[1] !='' && $row[3] > 0 ){
                $dataDetail[] = [
                  'NoTransaksiPenjualan' => $notrx ,
                  'KodeBarang'           => $row[1],
                  'Jumlah'               => $row[0],
                  'Harga'                => $row[3],
                  'Subtotal'             => $row[0] * $row[3],
                  'Sign'                 => 'D',
                  'Keterangan'           => $row[2],
                  'CreatedBy'            => $user->ID,
                  'CreatedAt'            => date('Y-m-d H:i:s')
                ];
            }
        }  

        $delete = "DELETE FROM $table_trx_detail WHERE no_transaksi='".$notrx."'";
        $wpdb->query($delete);	

	  	foreach ($dataDetail as $row) {

			$query = " INSERT INTO $table_trx_detail 
					   	( no_transaksi, kode_barang, jumlah, harga, subtotal, sign, keterangan, created_by, created_at )
					   VALUES 
					   		( '". $row['NoTransaksiPenjualan'] ."', '" . $row['KodeBarang'] . "', '". $row['Jumlah'] ."', '". $row['Harga'] ."',
					   		   '". $row['Subtotal'] ."', '" .$row['Sign']. "', '" .$row['Keterangan']. "', '" .$row['CreatedBy']. "', '" .$row['CreatedAt']. "'
					   		   )";
			//echo $query;			   		   
            $wpdb->query($query);

        }

        $query = "
        			UPDATE $table_trx_header SET
        				tanggal_transaksi 	= '".$tanggal."',
        				pengambilan 		= '".$pengambilan."',
        				tipe 				= '".$akun."',
        				no_pelanggan		= '".$pelanggan."',
        				mata_uang			= '".$ccy."',
        				keterangan			= '".$keterangan."',
        				sub_total			= '".$subtotal."',
        				potongan			= '".$potongan."',
        				pajak				= '".$pajak."',
        				biaya_pengiriman	= '".$biayapengiriman."',
        				biaya_lain			= '".$biayalain."',
        				total_akhir			= '".$totalakhir."',
        				cara_bayar			= '".$cara_bayar."',
        				jumlah_tunai		= '".$jumlah_tunai."',
        				jumlah_kredit		= '".$jumlah_kredit."',
        				total_pembayaran	= '".$total_pembayaran."',
        				sisa_pembayaran		= '".$sisa_pembayaran."',
        				status_progress		= '".$status."',
        				pos_code			= '".$pos_code."',
        				updated_by			= '".$updated_by."',
        				updated_at			= '".$updated_at."'
        			WHERE no_transaksi ='".$notrx."'";

        $query2 = "
        			UPDATE $table_trx_addinfo SET
        				no_transaksi_ref 	= '".$refno."',
        				nama_order 		 	= '".$ordername."',
        				channel 		 	= '".$channel."',
        				segment 		 	= '".$segment."',
        				catatan_order	 	= '".$catatan."',
        				updated_by			= '".$updated_by."',
        				updated_at			= '".$updated_at."'
        			WHERE no_transaksi ='".$notrx."'";

        $wpdb->query($query);
        $wpdb->query($query2);
        
        echo "<script>location.replace('admin.php?page=konveksi-penjualan&pg=daftar');</script>";

	}

	else if (isset($_POST['del'])) {

	  	$id 				= $_POST['id'];
	  	$updated_by 		= $user->ID;
	  	$updated_at			= date('Y-m-d H:i:s');	 

	    $del_id = $_GET['del'];
	    $wpdb->query("
	    				UPDATE wp_konveksi_apps_transaksi_header 
	    				SET 
	    					status_progress=0, 
	    					updated_by = '$updated_by',
	    					updated_at = '$updated_at'	
	    				WHERE id_transaksi='$id'
	    			");

	    echo "<script>location.replace('admin.php?page=konveksi-penjualan&pg=daftar');</script>";

	}

	else if (isset($_GET['edit'])) {

	  	$id 					= $_GET['edit'];
	  	$poscode 				= $wpdb->get_var( "SELECT pos_code FROM wp_konveksi_apps_transaksi_header WHERE id_transaksi='".$id."' LIMIT 0,1");
	  	$data['transaksi'] 		= $wpdb->get_results( "
	  							    SELECT
										id_transaksi,
										ath.no_transaksi,
										ath.tanggal_transaksi,
										ath.pengambilan,
										ath.tipe,
										ath.no_pelanggan,
										ath.mata_uang,
										ath.keterangan,
										ath.sub_total,
										ath.potongan,
										ath.pajak,
										ath.biaya_pengiriman,
										ath.biaya_lain,
										ath.total_akhir,
										ath.cara_bayar,
										ath.jumlah_tunai,
										ath.jumlah_kredit,
										ath.total_pembayaran,
										ath.pos_code,
										ath.sisa_pembayaran,
										ata.no_transaksi_ref,
										ata.nama_order,
										ata.channel,
										ata.segment,
										ata.catatan_order
									FROM wp_konveksi_apps_transaksi_header ath
									LEFT JOIN wp_konveksi_apps_transaksi_addinfo ata ON ath.no_transaksi = ata.no_transaksi
									WHERE ath.id_transaksi='".$id."'
									LIMIT 1
	  							  ");
	  	$data['trx_detail']		= $wpdb->get_results( "
									
									SELECT 
										atd.jumlah,
										atd.kode_barang,
										atd.keterangan,
										atd.harga, 
									    CONCAT('=A', @row_num:= @row_num + 1 , '*D' , @row_num:= @row_num  ) as subtotal
									FROM 
									    wp_konveksi_apps_transaksi_header AS ath, 
									    (SELECT @row_num:= 0 AS num) AS c,
									    wp_konveksi_apps_transaksi_detail atd 
									WHERE ath.no_transaksi = atd.no_transaksi 
											AND ath.id_transaksi='".$id."'
	  							  ");
	  	$data['masterjurnal'] 	= $wpdb->get_results( "SELECT * FROM ". $table_masterjurnal . " WHERE status=1");

	  	if ( $poscode == '001' ){
		
			$data['list-barang'] 	= $wpdb->get_results( "SELECT kode_barang AS id, nama_barang AS name FROM ". $table_barang . " WHERE pos_code IN ('1511','1519','3000') ORDER BY kode_barang");

		} else { 

			$data['list-barang'] 	= $wpdb->get_results( "SELECT kode_barang AS id, nama_barang AS name FROM ". $table_barang . " WHERE pos_code IN ('3130','3141','3149') ORDER BY kode_barang");

		}
	    //echo json_encode($data['trx_detail']);
	    require_once(ABSPATH . 'wp-content/plugins/konveksi/view/penjualan/edit.php');

	}

	else if (isset($_GET['bayar'])){
		$id 					= $_GET['bayar'];
		$data['masterjurnal'] 	= $wpdb->get_results( "SELECT * FROM ". $table_masterjurnal . " WHERE status=1");
	  	$data['transaksi'] 		= $wpdb->get_results( "
									SELECT
										id_transaksi,
										ath.no_transaksi,
										ath.tanggal_transaksi,
										ath.pengambilan,
										ath.tipe,
										ath.no_pelanggan,
										ap.nama as nama_pelanggan,
										ath.mata_uang,
										ath.keterangan,
										ath.sub_total,
										ath.potongan,
										ath.pajak,
										ath.biaya_pengiriman,
										ath.biaya_lain,
										ath.total_akhir,
										ath.cara_bayar,
										ath.jumlah_tunai,
										ath.jumlah_kredit,
										ath.total_pembayaran,
										ath.sisa_pembayaran,
										ata.no_transaksi_ref,
										ata.nama_order,
										ata.channel,
										ath.pos_code,
										cgm.value_generic_master as channel_desc,
										ata.segment,
										cgm2.value_generic_master as segment_desc,
										ata.catatan_order
									FROM wp_konveksi_apps_transaksi_header ath
									LEFT JOIN wp_konveksi_apps_transaksi_addinfo ata ON ath.no_transaksi = ata.no_transaksi
									LEFT JOIN wp_konveksi_apps_pelanggan ap ON ath.no_pelanggan = ap.no_pelanggan
									LEFT JOIN wp_konveksi_config_genericmaster cgm ON ata.channel = cgm.jenis_generic_master AND cgm.nama_generic_master='CHANNEL_LIST'
									LEFT JOIN wp_konveksi_config_genericmaster cgm2 ON ata.segment = cgm2.jenis_generic_master AND cgm2.nama_generic_master='SEGMENT_LIST'
									WHERE ath.id_transaksi='".$id."'
									LIMIT 1
	  							  ");
	  	$data['pembayaran']		= $wpdb->get_results( "
									SELECT 
										adp.no_transaksi,
										adp.pembayaran_ke,
										adp.tanggal_pembayaran,
										adp.no_pelanggan,
										adp.tanggal_pembayaran,
										adp.nominal_pembayaran,
										adp.keterangan,
										amj.nama_masterjurnal
									FROM wp_konveksi_apps_detailpembayaran adp 
									LEFT JOIN wp_konveksi_apps_transaksi_header ath ON adp.no_transaksi = ath.no_transaksi	
									LEFT JOIN wp_konveksi_acct_masterjurnal amj ON adp.akun_pembayaran = amj.kode_masterjurnal 
	  								WHERE ath.id_transaksi = '". $id ."' 
	  							  ");
		require_once(ABSPATH . 'wp-content/plugins/konveksi/view/penjualan/bayar.php');
	
	}

	else if (isset($_GET['cetak'])) {

	  	$id 					= $_GET['cetak'];
	  	$no_transaksi			= $wpdb->get_var( "SELECT REPLACE(no_transaksi,'/','.') AS no_transaksi FROM wp_konveksi_apps_transaksi_header WHERE id_transaksi='".$id."' LIMIT 0,1");
	  	$data['transaksi'] 		= $wpdb->get_results( "
									SELECT
										id_transaksi,
										ath.no_transaksi,
										ath.tanggal_transaksi,
										pel.nama,
										pel.alamat,
										pel.no_telp_1 as no_telp,
										ath.pengambilan,
										ath.tipe,
										ath.no_pelanggan,
										ath.mata_uang,
										ath.keterangan,
										ath.sub_total,
										ath.potongan,
										ath.pajak,
										ath.biaya_pengiriman,
										ath.biaya_lain,
										ath.total_akhir,
										ath.cara_bayar,
										ath.jumlah_tunai,
										ath.jumlah_kredit,
										ath.total_pembayaran,
										ath.pos_code,
										ath.sisa_pembayaran,
										ata.no_transaksi_ref,
										ata.nama_order,
										ata.channel,
										ata.segment,
										ata.catatan_order
									FROM wp_konveksi_apps_transaksi_header ath
									LEFT JOIN wp_konveksi_apps_transaksi_addinfo ata ON ath.no_transaksi = ata.no_transaksi
									LEFT JOIN wp_konveksi_apps_pelanggan pel ON ath.no_pelanggan = pel.no_pelanggan
									WHERE ath.id_transaksi='".$id."'
									LIMIT 1
	  							  ");
	  	$data['trx_detail']		= $wpdb->get_results( "
									
									SELECT 
										atd.jumlah,
										atd.kode_barang,
										atd.keterangan,
										atd.harga, 
									    CONCAT('=A', @row_num:= @row_num + 1 , '*D' , @row_num:= @row_num  ) as subtotal
									FROM 
									    wp_konveksi_apps_transaksi_header AS ath, 
									    (SELECT @row_num:= 0 AS num) AS c,
									    wp_konveksi_apps_transaksi_detail atd 
									WHERE ath.no_transaksi = atd.no_transaksi 
											AND ath.id_transaksi='".$id."'
	  							  ");

	  	
		require_once( ABSPATH . 'wp-content/plugins/konveksi/view/laporan/cetak_struk.php' ) ;
		
		$dompdf->set_option('isRemoteEnabled', TRUE);
		$dompdf->load_html($fileContent); 
		$dompdf->render();    
		$pdf = $dompdf->output();
		$invnoabc = 'Invoice - '.$no_transaksi.'.pdf';
		ob_end_clean();
		$dompdf->stream($invnoabc);
		exit;
		
		//require_once(ABSPATH . 'wp-content/plugins/konveksi/view/laporan/cetak_struk.php');
		

	}

	else if (isset($_POST['hutang-pembayaran'])){
		
		$no_transaksi 		= $_POST['no_transaksi'];
		$no_pelanggan 		= $_POST['no_pelanggan'];
		$pembayaran_ke 		= $_POST['pembayaran_ke'];
		$tanggal_pembayaran = $_POST['tanggal'];
		$nominal_pembayaran = $_POST['nominal'];
		$akun_pembayaran 	= $_POST['akun'];
		$keterangan 		= $_POST['keterangan'];
	  	$created_by 		= $user->ID;
	  	$created_at			= date('Y-m-d H:i:s');	

	  	$query  = "
	  				UPDATE
	  					wp_konveksi_apps_transaksi_header
	  				SET
	  					total_pembayaran = total_pembayaran + ".$nominal_pembayaran.",
	  					jumlah_kredit 	 = jumlah_kredit + ".$nominal_pembayaran.",
	  					sisa_pembayaran  = sisa_pembayaran - ".$nominal_pembayaran.",
	  					updated_at 		 = '".$created_at."',
	  					updated_by 		 = '".$updated_by."'
	  				WHERE
	  					no_transaksi = '".$no_transaksi."'
	  			  ";
	  	$query2 = "
	  				INSERT INTO wp_konveksi_apps_detailpembayaran 
	  				(no_transaksi, no_pelanggan, pembayaran_ke, tanggal_pembayaran, nominal_pembayaran, akun_pembayaran, keterangan, created_at, created_by)
	  				VALUES
	  				('".$no_transaksi."', '".$no_pelanggan."', '".$pembayaran_ke."', '".$tanggal_pembayaran."', '".$nominal_pembayaran."', '".$akun_pembayaran."', '".$keterangan."', '".$created_at."', '".$created_by."')
	  			  ";
        $wpdb->query($query);
        $wpdb->query($query2);
        
        echo "<script>location.replace('admin.php?page=konveksi-penjualan&pg=daftar');</script>";
	
	}

	else if (isset($_POST['search-submit'])) {

	  	$id 				= $_GET['edit'];
	  	$data['pelanggan'] 	= $wpdb->get_results( "SELECT * FROM ". $table_name . " WHERE id_pelanggan='$id' LIMIT 1");

	    require_once(ABSPATH . 'wp-content/plugins/konveksi/view/pelanggan/edit.php');

	}

	else if (isset($_GET['pg']) AND $_GET['pg'] == 'daftar' ) {

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
					WHERE A.pos_code IN ('001','002') AND A.status_progress<>'0'
				 ";

		$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
		$total = $wpdb->get_var( $total_query );

		$results = $wpdb->get_results( $query.' ORDER BY tanggal_transaksi DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );

	    require_once(ABSPATH . 'wp-content/plugins/konveksi/view/penjualan/daftar.php');

	}

	else if (isset($_GET['pg']) AND $_GET['pg'] == 'penjualan-lainnya' ) {

	  	$data['masterjurnal'] 	= $wpdb->get_results( "SELECT * FROM ". $table_masterjurnal . " WHERE status=1");
		$data['list-barang'] 	= $wpdb->get_results( "SELECT kode_barang AS id, nama_barang AS name FROM ". $table_barang . " WHERE pos_code IN ('3130','3141','3149') ORDER BY kode_barang");

	  	require_once(ABSPATH . 'wp-content/plugins/konveksi/view/penjualan/pendapatan-lain.php');
	
	}
	else {

	  	$data['masterjurnal'] 	= $wpdb->get_results( "SELECT * FROM ". $table_masterjurnal . " WHERE status=1");
		$data['list-barang'] 	= $wpdb->get_results( "SELECT kode_barang AS id, nama_barang AS name FROM ". $table_barang . " WHERE pos_code IN ('1511','1519','3000') ORDER BY kode_barang");

	  	require_once(ABSPATH . 'wp-content/plugins/konveksi/view/penjualan/index.php');
	
	}	
	
}

?>