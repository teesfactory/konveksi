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
<center>INVOICE</center>

<br>
<table width='100%' border='1'>
	<tr>
		<td colspan='4' bgcolor='#cccccc'>INFORMASI ORDER</td>
	</tr>
	<tr>
		<td width='15%'>Hari/Tanggal</td>
		<td width='35%'></td>
		<td width='15%'>No. Invoice</td>
		<td width='35%'>" . $data['transaksi'][0]->no_transaksi . "</td>
	</tr>
	<tr>
		<td width='15%'>Nama</td>
		<td width='35%'>" . $data['transaksi'][0]->nama . "</td>
		<td width='15%'>No. Telp</td>
		<td width='35%'>" . $data['transaksi'][0]->no_telp . "</td>
	</tr>
	<tr>
		<td width='15%'>Alamat</td>
		<td width='85%' colspan='3'>" . $data['transaksi'][0]->alamat . "</td>
	</tr>
</table>
<br>
<table width='100%' border='1'>
	<tr>
		<td colspan='5' bgcolor='#cccccc'>DETAIL ORDER</td>
	</tr>
	<tr>
		<td width='5%'>No.</td>
		<td width='50%'>Deskripsi</td>
		<td width='5%'>Jml</td>
		<td width='20%'>Satuan</td>
		<td width='20%'>Subtotal</td>
	</tr>
";
$i = 1;
foreach ( $data['trx_detail'] as $detail ){

$fileContent .="
    <tr>
        <td> " . $i . "</td>
        <td> " . $detail->kode_barang . "</td>
        <td> " . $detail->jumlah . "</td>
        <td> " . $detail->harga . "</td>
        <td> " . $detail->jumlah * $detail->harga . "</td>
    </tr>
";    
    
$i++;    
}

$fileContent .= "
</table>
</html>
";
