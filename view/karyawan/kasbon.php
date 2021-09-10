<style type="text/css">
	.uppercase { text-transform: uppercase; }
	.lowercase { text-transform: lowercase; }
</style>

<div class="wrap container-fluid">
	<h1 class="wp-heading-inline">Kas Bon</h1>
	<a class="page-title-action" data-toggle="modal" data-target="#exampleModal">Tambah Baru</a>
	<hr class="wp-header-end">
  <br>  
    <table class="wp-list-table widefat table-bordered table" width="100%">
      <thead>
        <tr>
          <th width="10%" colspan="2">Informasi Umum</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ( $data['karyawan'] as $karyawan ) { ?>
        <tr>
            <td width="30%">Kode Karyawan</td>
            <td><?php echo $karyawan->kode_karyawan; ?></td>
        </tr>
        <tr>
            <td width="30%">Nama</td>
            <td><?php echo $karyawan->nama_karyawan; ?></td>
        </tr>
        <tr>
            <td width="30%">No. Handphone</td>
            <td><?php echo $karyawan->no_handphone; ?></td>
        </tr>
        <tr>
            <td width="30%">Email</td>
            <td><?php echo $karyawan->email; ?></td>
        </tr>
        <tr>
            <td width="30%">Alamat</td>
            <td><?php echo $karyawan->alamat; ?></td>
        </tr>
        <tr>
            <td width="30%">Limit Kas Bon</td>
            <td><?php echo number_format($karyawan->limit_kasbon,2,",","."); ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>  

    <table class="wp-list-table widefat striped table" width="100%">
      <thead>
        <tr>
          <th colspan="6">Detail Kas Bon</th>
        </tr>
        <tr>
          <th width="10%">Tanggal</th>
          <th width="20%">No Transaksi</th>
          <th width="25%">Pembayaran</th>
          <th width="10%">Kas Bon</th>
          <th width="10%">Cicilan</th>
          <th width="40%">Keterangan</th>
        </tr>
      </thead>
      <tbody>
      <?php 
        if ( !empty($data['kasbon']) ){ 
          foreach ($data['kasbon'] as $kasbon) {	 
            $total_kasbon[] = $kasbon->nominal_kasbon;
            $total_cicilan[] = $kasbon->pembayaran_kasbon; 
        ?>
            <tr>
              <td><?php echo $kasbon->tanggal; ?></td>
              <td><?php echo $kasbon->no_transaksi; ?></td>
              <td><?php echo $kasbon->nama_masterjurnal; ?></td>
              <td><?php echo number_format($kasbon->nominal_kasbon,2,",","."); ?></td>
              <td><?php echo number_format($kasbon->pembayaran_kasbon,2,",","."); ?></td>
              <td><?php echo $kasbon->keterangan; ?></td>
            </tr>
        <?php } ?>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td><b><?php echo number_format(array_sum($total_kasbon),2,",","."); ?></b></td>
              <td><b><?php echo number_format(array_sum($total_cicilan),2,",","."); ?></b></td>
              <td></td>
            </tr>
          <?php } else { ?>
            <tr>
              <td colspan="6">belum ada kasbon.</td>
            </tr>
          <?php } ?>
      </tbody>
  </table>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah/Cicil Kas Bon</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="admin.php?page=konveksi-karyawan" method="post">
        <input type="hidden" name="kode_karyawan" value="<?php echo $id; ?>">
      	<div class="modal-body">
      		<div class="form-row">
      			<div class="form-group col-md-6">
      				<label for="no_handphone_1">Pembayaran Dari/Ke</label>
             <select id="akun" name="akun" class="mdb-select form-control form-control-sm">
                <option selected value="0">BELUM DIKETAHUI</option>
                <?php
                  foreach ( $data['masterjurnal'] as $masterjurnal ) {
                ?>
                  <option value="<?php echo $masterjurnal->kode_masterjurnal ?>"><?php echo $masterjurnal->nama_masterjurnal ?></option>
                <?php } ?>
              </select>
      			</div>
      			<div class="form-group col-md-6">
      				<label for="no_handphone_2">Tanggal</label>
      				<input type="date" name="tanggal" class="form-control form-control-sm" id="tanggal">
      			</div>
      		</div>
      		<div class="form-row">
      			<div class="form-group col-md-6">
      				<label for="nominal">Nominal</label>
      				<input type="number" name="nominal" class="form-control form-control-sm lowercase" value="0" id="nominal">
      			</div>
            <div class="form-group col-md-6">
              <label for="cicilan">Cicilan</label>
              <input type="number" name="cicilan" class="form-control form-control-sm lowercase" value="0" id="cicilan">
            </div>
      		</div>
          <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <input type="text" name="keterangan" class="form-control form-control-sm" id="keterangan">
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary btn-sm" value="Save changes" name="kasbon-pembayaran">
      </div>
    </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
    
    // Initialize select2
    $("#selUser").select2();
    
});

	function hapusAction(data){
        $("#id").val(data);
        $('#dialogHapus').modal('show');
        //alert(data);
    }

</script>