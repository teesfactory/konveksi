<script src="https://jexcel.net/v5/jexcel.js"></script>
<script src="https://jexcel.net/v5/jsuites.js"></script>
<link rel="stylesheet" href="https://jexcel.net/v5/jexcel.css" type="text/css" />
<link rel="stylesheet" href="https://jexcel.net/v5/jsuites.css" type="text/css" />

<style type="text/css">
  .form-control-sm{ height:10px }
</style>

<div class="wrap container-fluid">
	<h1 class="wp-heading-inline"><?php echo $data['judul'] ; ?></h1>
	<hr class="wp-header-end">
  <ul class="subsubsub">
    <li class="all"><a href="admin.php?page=konveksi-pengeluaran">Daftar Pengeluaran</a> |</li>
    <li class="publish"><a href="admin.php?page=konveksi-pengeluaran&pg=belanja-kaos" <?php if ( $data['judul'] == 'Belanja Kaos' ) { echo $data['active'];  } ?> >Belanja Kaos</a> |</li>
    <li class="publish"><a href="admin.php?page=konveksi-pengeluaran&pg=belanja-bahan" <?php if ( $data['judul'] == 'Belanja Bahan' ) { echo $data['active'];  } ?> >Belanja Bahan</a> |</li>
    <li class="publish"><a href="admin.php?page=konveksi-pengeluaran&pg=biaya-operasional-produksi" <?php if ( $data['judul'] == 'Biaya Produksi & Operasional' ) { echo $data['active'];  } ?> >Biaya Produksi & Operasional</a> |</li>
    <li class="publish"><a href="admin.php?page=konveksi-pengeluaran&pg=transfer-kas" <?php if ( $data['judul'] == 'Transfer Kas' ) { echo $data['active'];  } ?> >Transfer Kas</a></li>
  </ul> 
	<div class="clear"></div>
  <form id="form-penjualan" action="admin.php?page=konveksi-penjualan" method="post">
    <input type="hidden" name="datadetail" id="datadetail">
    <input type="hidden" name="poscode" value="<?php echo $data['poscode']; ?>">
    <table class="wp-list-table widefat table-bordered table" width="100%">
      <thead>
        <tr>
          <th colspan="4">Informasi Pengeluaran</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td width="15%">Tanggal</td>
          <td width="35%"><input type="date" name="tanggal" class="form-control form-control-sm"></td>
          <td width="15%">Channel</td>
          <td width="35%">
          <select id="channel" name="channel" class="mdb-select form-control form-control-sm">
            <option selected value="0">BELUM DIKETAHUI</option>
            <?php
              foreach ( $data['list-channel'] as $channel ) {
            ?>
              <option value="<?php echo $channel->jenis_generic_master ?>"><?php echo $channel->value_generic_master ?></option>
            <?php } ?>
          </select>
          </td>
        </tr>
        <tr>
          <td>Pengambilan</td>
          <td><input type="date" name="pengambilan" class="form-control form-control-sm"></td>
          <td>Segment</td>
          <td>
          <select id="segment" name="segment" class="mdb-select form-control form-control-sm">
            <option selected value="0">BELUM DIKETAHUI</option>
            <?php
              foreach ( $data['list-segmen'] as $segment ) {
            ?>
              <option value="<?php echo $segment->jenis_generic_master ?>"><?php echo $segment->value_generic_master ?></option>
            <?php } ?>
          </select>
          </td>
        </tr>
        <tr>
          <td>Supplier</td>
          <td>
          <select id="selUser" name="pelanggan" class="mdb-select form-control form-control-sm">
            <option selected value="0">BELUM DIKETAHUI</option>
            <?php
              foreach ( $data['list-pelanggan'] as $pelanggan ) {
            ?>
              <option value="<?php echo $pelanggan->no_pelanggan ?>"><?php echo $pelanggan->nama ?></option>
            <?php } ?>
          </select>
          </td>
          <td>Ref. No</td>
          <td><input type="text" class="form-control form-control-sm" name="refno"></td>
        </tr>
        <tr>
          <td width="15%">Pembayaran</td>
          <td width="35%">
             <select id="akun" name="akun" class="mdb-select form-control form-control-sm">
                <option selected value="0">BELUM DIKETAHUI</option>
                <?php
                  foreach ( $data['masterjurnal'] as $masterjurnal ) {
                ?>
                  <option value="<?php echo $masterjurnal->kode_masterjurnal ?>"><?php echo $masterjurnal->nama_masterjurnal ?></option>
                <?php } ?>
              </select>
          </td>
          <td>Order Name</td>
          <td><input type="text" class="form-control form-control-sm" name="ordername"></td>
        </tr>
        <tr>
          <td colspan="4"><div id='spreadsheet'></div></td>
        </tr>
        <tr>
          <td colspan="3" width="65%" align="right"><b>Subtotal</b></td>
          <td><input type="number" name="subtotal" id="SubTotal" value="0" class="form-control form-control-sm"></td>
        </tr>
        <tr>
          <td colspan="3" width="65%" align="right"><b>Biaya Pengiriman</b></td>
          <td><input type="number" name="biayapengiriman" id="BiayaPengiriman" value="0" class="form-control form-control-sm"></td>
        </tr>
        <tr>
          <td colspan="3" width="65%" align="right"><b>Biaya Lain</b></td>
          <td><input type="number" name="biayalain" id="BiayaLain" value="0" class="form-control form-control-sm"></td>
        </tr>
        <tr>
          <td colspan="3" width="65%" align="right"><b>Potongan</b></td>
          <td><input type="number" name="potongan" id="Potongan" value="0" class="form-control form-control-sm"></td>
        </tr>
        <tr>
          <td colspan="3" width="65%" align="right"><b>Total</b></td>
          <td><input type="number" name="total" id="Total" value="0" class="form-control form-control-sm"></td>
        </tr>
        <tr>
          <td colspan="3" width="65%" align="right"><b>Pembayaran</b></td>
          <td><input type="text" name="pembayaran" id="Pembayaran" value="0" class="form-control form-control-sm"></td>
        </tr>
        <tr>
          <td colspan="3" width="65%" align="right"><b>Kembali/Pelunasan</b></td>
          <td><input type="text" name="Kembali" readonly id="Kembali" class="form-control form-control-sm"></td>
        </tr>
        <tr>
          <td colspan="4">
            <label for="inputAddress">Syarat & Ketentuan</label>
            <input type="text" class="form-control form-control-sm" name="keterangan" value="Periksa Kembali Barang Yang Dipesan. Barang Yang Sudah Dibeli Tidak Dapat Dikembalikan.">
          </td>
        </tr>
        <tr>
          <td colspan="4">
            <label for="inputAddress">Catatan Produksi</label>
            <input type="text" class="form-control form-control-sm" name="catatan" value="Biasakan doa sebelum bekerja. Teliti kembali work order">
          </td>
        </tr>
      </tbody>
    </table>
    <button type="submit" class="btn btn-primary" name="newsubmit">Simpan</button>
  </form>     
			
</div>


<script>
$(document).ready(function(){
    
    // Initialize select2
    $("#selUser").select2();
    
});	

var data = [
    [0,'', '', 0, "=A1*D1"],
    [0,'', '', 0, "=A2*D2"],
    [0,'', '', 0, "=A3*D3"],
    [0,'', '', 0, "=A4*D4"],
    [0,'', '', 0, "=A5*D5"],
    [0,'', '', 0, "=A6*D6"],
    [0,'', '', 0, "=A7*D7"],
    [0,'', '', 0, "=A8*D8"],
    [0,'', '', 0, "=A9*D9"],
    [0,'', '', 0, "=A10*D10"],
];

// data.push(
//         ['','','','','Subtotal','=SUM(F1:F4)'],
//         ['','','','','Biaya Lain','0'],
//         ['','','','','Potongan','0'],
//         ['','','','','Total','=TOT(TABLE(), 5)'],
// );

// A custom method to SUM all the cells in the current column

var SUMCOL = function(instance, columnId) {
    var total = 0;
    for (var j = 0; j < instance.options.data.length; j++) {
        if (Number(instance.records[j][columnId].element.innerHTML)) {
            total += Number(instance.records[j][columnId].element.innerHTML);
        }
    }

    $('#SubTotal').val(total);

    $("#Total").val( total + parseInt( $("#BiayaLain").val() ) - parseInt( $("#Potongan").val() ) ) ;


    return total;
}


var insertedRow = function(instance) {
    alert(getRowData);
}

var TOT = function(instance, columnId) {
    var total = 0;
    for (var j = 0; j < instance.options.data.length; j++) {
        if (Number(instance.records[j][columnId].innerHTML)) {
            total += Number(instance.records[j][columnId].innerHTML);
        }
    }

    return j;
}


var table = jexcel(document.getElementById('spreadsheet'), {
    data:data,
    columnDrag:true,
    columns: [
      {type: 'number', title: 'Qty', width: 40},
      {
            type: 'dropdown', 
            title: 'Barang', 
            width: 330, 
            source:<?php echo json_encode( $data['list-barang'] );?>, 
            options: { type:'dropdown' },
            autocomplete:true,
      },
      {type: 'text', title: 'Keterangan', width: 270},
      {type: 'number', title: 'Harga', width: 165},
      {type: 'number', title: 'Subtotal', width: 165}
    ],
    oninsertrow: insertedRow,
    footers: [
                ['','','','','=SUMCOL(TABLE(), 4)'],
             ], 
    editable:true,
    updateTable:function(instance, cell, col, row, val, label, cellName) {
        if (col == 1) {
            cell.style = 'text-align:left;';
        }
        if (col == 2) {
            cell.style = 'text-align:left;';
        }
        if (col == 3) {
            cell.style = 'text-align:right;';
        }
        if (col == 4) {
            cell.style = 'text-align:right';
        }
        if (col == 5) {
            cell.style = 'text-align:right';
        }
    },
});


$(function () {
  $('#form-penjualan').submit(function (event) {
    var data = $('#spreadsheet').jexcel('getData');
    $('#datadetail').val(JSON.stringify(data));

  });
});

$('#BiayaLain').keyup(function () {
   
    
    var sum = 0;
    $('#BiayaLain').each(function() {
        sum =  parseInt( $("#SubTotal").val() ) + parseInt( $("#BiayaPengiriman").val() ) + parseInt( $("#BiayaLain").val() ) - parseInt( $("#Potongan").val() );
    });
    
    $('#Total').val(sum);
    
});

$('#Potongan').keyup(function () {
   
    
    var sum = 0;
    $('#Potongan').each(function() {
        sum =  parseInt( $("#SubTotal").val() ) + parseInt( $("#BiayaPengiriman").val() ) + parseInt( $("#BiayaLain").val() ) - parseInt( $("#Potongan").val() );
    });
    
    $('#Total').val(sum);
    
});

$('#Pembayaran').keyup(function () {
   
    
    var sum = 0;
    $('#Pembayaran').each(function() {
        sum =  parseInt( $("#Pembayaran").val() )  - parseInt( $("#Total").val() );
    });
    
    $('#Kembali').val(sum);
    
});


</script>

