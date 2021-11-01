SELECT
	a.pengambilan as dateline,
	a.no_transaksi,
	c.display_name as marketing,
	d.nama as cust,
	b.nama_order,
	b.work_order,
	b.film,
	b.jahit_kaos,
	b.sablon,
	b.packing,
	b.selesai
FROM wp_konveksi_apps_transaksi_header a
LEFT JOIN wp_konveksi_apps_transaksi_addinfo b ON a.no_transaksi = b.no_transaksi
LEFT JOIN wp_users c on a.created_by = c.ID
LEFT JOIN wp_konveksi_apps_pelanggan d on a.no_pelanggan = d.no_pelanggan
WHERE pos_code IN ('001','002')
