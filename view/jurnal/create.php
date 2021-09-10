<script src="https://jexcel.net/v5/jexcel.js"></script>
<script src="https://jexcel.net/v5/jsuites.js"></script>
<link rel="stylesheet" href="https://jexcel.net/v5/jexcel.css" type="text/css" />
<link rel="stylesheet" href="https://jexcel.net/v5/jsuites.css" type="text/css" />

<style type="text/css">
  .form-control-sm{ height:10px }
</style>

<div class="wrap container-fluid">
	<h1 class="wp-heading-inline">Create Jurnal</h1>
	<hr class="wp-header-end">
	<div class="clear"></div>
  <form id="form-penjualan" action="admin.php?page=konveksi-penjualan" method="post">
    <input type="hidden" name="datadetail" id="datadetail">
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
          <td>Id. Reference</td>
           <td><input type="text" name="pengambilan" class="form-control form-control-sm"></td>
        </tr>
        <tr>
          <td>No. Transaksi</td>
          <td><input type="text" name="pengambilan" class="form-control form-control-sm"></td>
          <td>Keterangan</td>
          <td><input type="text" class="form-control form-control-sm" name="refno"></td>
        </tr>
          <td colspan="4"><div id='spreadsheet'></div></td>
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
    ['', '', '', '', 0, 0],
    ['', '', '', '', 0, 0],
    ['', '', '', '', 0, 0],
    ['', '', '', '', 0, 0],
    ['', '', '', '', 0, 0],
    ['', '', '', '', 0, 0],
    ['', '', '', '', 0, 0],
    ['', '', '', '', 0, 0],
    ['', '', '', '', 0, 0],
    ['', '', '', '', 0, 0],
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
      {
            type: 'dropdown', 
            title: 'Akun', 
            width: 150, 
            source:<?php echo json_encode( $data['list-jurnal'] );?>, 
            options: { type:'dropdown' },
            autocomplete:true,
      },
      {
            type: 'dropdown', 
            title: 'Channel', 
            width: 150, 
            source:<?php echo json_encode( $data['list-channel'] );?>, 
            options: { type:'dropdown' },
            autocomplete:true,
      },
      {
            type: 'dropdown', 
            title: 'Segment', 
            width: 150, 
            source:<?php echo json_encode( $data['list-segmen'] );?>, 
            options: { type:'dropdown' },
            autocomplete:true,
      },
      {type: 'text', title: 'Keterangan', width: 270},
      {type: 'number', title: 'Debet', width: 165},
      {type: 'number', title: 'Kredit', width: 165}
    ],
    oninsertrow: insertedRow,
    footers: [
                ['','','','','=SUMCOL(TABLE(), 4)','=SUMCOL(TABLE(), 5)'],

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


</script>

