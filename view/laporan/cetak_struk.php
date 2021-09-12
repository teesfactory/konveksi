<table width="100%">
	<tr>
		<td width='95%'></td>
		<td><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . '/assets/img/tees-factory-tagline.png' ?>" /></td>
	</tr>
	<tr>
		<td colspan="2"><center>INVOICE</center></td>
	</tr>
</table>
<br>
<table width="100%" border="1">
	<tr>
		<td colspan="4" bgcolor="#cccccc">INFORMASI ORDER</td>
	</tr>
	<tr>
		<td width="15%">Hari/Tanggal</td>
		<td width="35%"></td>
		<td width="15%">No. Invoice</td>
		<td width="35%"><?php echo $data['transaksi'][0]->no_transaksi; ?></td>
	</tr>
	<tr>
		<td width="15%">Nama</td>
		<td width="35%"></td>
		<td width="15%">No. Telp</td>
		<td width="35%"><?php echo $data['transaksi'][0]->no_transaksi; ?></td>
	</tr>
	<tr>
		<td width="15%">Alamat</td>
		<td width="85%" colspan="3"></td>
	</tr>
</table>

<table width="100%" border="1">
	<tr>
		<td colspan="5" bgcolor="#cccccc">DETAIL ORDER</td>
	</tr>
	<tr>
		<td width="5%">No.</td>
		<td width="50%">Deskripsi</td>
		<td width="5%">Jml</td>
		<td width="20%">Satuan</td>
		<td width="20%">Subtotal</td>
	</tr>
	<tr>
		<td width="5%">No.</td>
		<td width="50%">Deskripsi</td>
		<td width="5%">Jml</td>
		<td width="20%">Satuan</td>
		<td width="20%">Subtotal</td>
	</tr>
</table>
