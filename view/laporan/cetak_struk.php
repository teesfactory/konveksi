<?php 
$fileContent = "
<html>

<style>
body {  
    font-family: 'Helvetica';
    font-size: 12 px;
}
table, th, td {
  border: 1px solid black;
}
table{
border-collapse: collapse;
}
</style>

<img src='https://teesfactory.id/wp-content/uploads/2021/05/tees-factory-tagline.png' width='100 px' style='float:right'/>
<br>
<br>
<br>
<center><b>INVOICE</b></center>

<br>
<table width='100%' border='1'>
	<tr>
		<td colspan='4' bgcolor='#cccccc'><b>INFORMASI ORDER</b></td>
	</tr>
	<tr>
		<td width='15%'><b>Hari/Tanggal</b></td>
		<td width='35%'></td>
		<td width='15%'><b>No. Invoice</b></td>
		<td width='35%'>" . $data['transaksi'][0]->no_transaksi . "</td>
	</tr>
	<tr>
		<td width='15%'><b>Nama</b></td>
		<td width='35%'>" . $data['transaksi'][0]->nama . "</td>
		<td width='15%'><b>No. Telp</b></td>
		<td width='35%'>" . $data['transaksi'][0]->no_telp . "</td>
	</tr>
	<tr>
		<td width='15%'><b>Alamat</b></td>
		<td width='85%' colspan='3'>" . $data['transaksi'][0]->alamat . "</td>
	</tr>
</table>
<br>
<table width='100%' border='1'>
	<tr>
		<td colspan='5' bgcolor='#cccccc'><b>>DETAIL ORDER</b></td>
	</tr>
	<tr>
		<td width='5%'><b>No.</b></td>
		<td width='70%'><b>Deskripsi</b></td>
		<td width='5%'><b>Jml</b></td>
		<td width='20%'><b>Satuan</b></td>
		<td width='20%'><b>Subtotal</b></td>
	</tr>
";
$i = 1;
foreach ( $data['trx_detail'] as $detail ){

$fileContent .="
    <tr>
        <td> " . $i . "</td>
        <td> " . $detail->nama_barang . " <br> " . $detail->keterangan .  "</td>
        <td> " . $detail->jumlah . "</td>
        <td> " . number_format($detail->harga,2,",",".") . "</td>
        <td> " . number_format($detail->jumlah * $detail->harga,2,",",".") . "</td>
    </tr>
";    
    
$i++;    
}

$fileContent .= "

<tr>
<td width='60%' colspan='3'></td>
<td width='20%'><b>Subtotal</b></td>
<td width='20%'> " . number_format($data['transaksi'][0]->sub_total,2,",",".") . " </td>
</tr>
<tr>
<td width='60%' colspan='3'></td>
<td width='20%'><b>Biaya Pengiriman</b></td>
<td width='20%'> " . number_format($data['transaksi'][0]->biaya_pengiriman,2,",",".") . " </td>
</tr>
<tr>
<td width='60%' colspan='3'></td>
<td width='20%'><b>Biaya Lain</b></td>
<td width='20%'> " . number_format($data['transaksi'][0]->biaya_lain,2,",",".") . " </td>
</tr>
<tr>
<td width='60%' colspan='3'></td>
<td width='20%'><b>Potongan</b></td>
<td width='20%'> " . number_format($data['transaksi'][0]->potongan,2,",",".") . " </td>
</tr>
<tr>
<td width='60%' colspan='3'></td>
<td width='20%'><b>Total</b></td>
<td width='20%'> " . number_format($data['transaksi'][0]->total_akhir,2,",",".") . " </td>
</tr>
<tr>
<td width='60%' colspan='3'></td>
<td width='20%'><b>Pembayaran</b></td>
<td width='20%'> " . number_format($data['transaksi'][0]->pembayaran,2,",",".") . " </td>
</tr>
<tr>
<td width='60%' colspan='3'></td>
<td width='20%'><b>Sisa Pembayaran</b></td>
<td width='20%'> " . number_format($data['transaksi'][0]->sisa_pembayaran,2,",",".") . " </td>
</tr>

</table>
</html>
";
