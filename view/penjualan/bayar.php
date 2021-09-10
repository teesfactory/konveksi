<style type="text/css">
  .uppercase { text-transform: uppercase; }
  .lowercase { text-transform: lowercase; }
</style>

<div class="wrap container-fluid">
  <h1 class="wp-heading-inline">Pembayaran</h1>
  <a class="page-title-action" data-toggle="modal" data-target="#exampleModal">Tambah Pembayaran</a>
  <hr class="wp-header-end">
  <br>  
    <table class="wp-list-table widefat table-bordered table" width="100%">
      <thead>
        <tr>
          <th width="10%" colspan="2">Informasi Pembelian</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ( $data['transaksi'] as $transaksi ) { ?>
        <tr>
            <td width="30%">No. Transaksi</td>
            <td><?php echo $transaksi->no_transaksi; ?></td>
        </tr>
        <tr>
            <td width="30%">Nama Pemesan</td>
            <td>
                <?php 
                      if ( $transaksi->pos_code == '001' OR $transaksi->pos_code == '002' ) {
                  
                        echo $transaksi->nama_pelanggan; 

                      } else {

                        echo 'TKS FACTORY';

                      }
                ?>
                
            </td>
        </tr>
        <tr>
            <td width="30%">Nama Order</td>
            <td><?php echo $transaksi->nama_order; ?></td>
        </tr>
        <tr>
            <td width="30%">Channel</td>
            <td><?php echo $transaksi->channel_desc; ?></td>
        </tr>
        <tr>
            <td width="30%">Segment</td>
            <td><?php echo $transaksi->segment_desc; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>  

    <table class="wp-list-table widefat striped table" width="100%">
      <thead>
        <tr>
          <th colspan="6">Detail Pembayaran</th>
        </tr>
        <tr>
          <th width="10%">No.</th>
          <th width="20%">Tanggal</th>
          <th width="25%">Pembayaran</th>
          <th width="40%">Keterangan</th>
          <th width="10%">Nominal</th>
        </tr>
      </thead>
      <tbody>
      <?php 
        if ( !empty($data['pembayaran']) ){ 
          foreach ($data['pembayaran'] as $pembayaran) {   
            $total_pembayaran[] = $pembayaran->nominal_pembayaran;
        ?>
            <tr>
              <td><?php echo $pembayaran->pembayaran_ke; ?></td>
              <td><?php echo $pembayaran->tanggal_pembayaran; ?></td>
              <td><?php echo $pembayaran->nama_masterjurnal; ?></td>
              <td><?php echo $pembayaran->keterangan; ?></td>
              <td align="right"><?php echo number_format($pembayaran->nominal_pembayaran,2,",","."); ?></td>
            </tr>
        <?php } ?>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td>Total Pembayaran</td>
              <td align="right"><b><?php echo number_format(array_sum($total_pembayaran),2,",","."); ?></b></td>
            </tr>
          <?php } else { ?>
            <tr>
              <td colspan="6">belum ada pembayaran.</td>
            </tr>
          <?php } ?>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td>Total Tagihan</td>
              <td align="right"><b><?php echo number_format($transaksi->total_akhir,2,",","."); ?></b></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td>Sisa Tagihan</td>
              <td align="right"><b><?php echo number_format($transaksi->sisa_pembayaran,2,",","."); ?></b></td>
            </tr>
      </tbody>
  </table>
</div>


<?php foreach ( $data['transaksi'] as $transaksi ) { ?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pembayaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="admin.php?page=konveksi-penjualan" method="post">
        <input type="hidden" name="no_pelanggan" value="<?php echo $transaksi->no_pelanggan; ?>">
        <input type="hidden" name="no_transaksi" value="<?php echo $transaksi->no_transaksi; ?>">
        <input type="hidden" name="pembayaran_ke" value="<?php echo count($data['pembayaran'])+1; ?>">
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
              <input type="number" name="nominal" class="form-control form-control-sm lowercase" value="<?php echo $transaksi->sisa_pembayaran; ?>" id="nominal">
            </div>
            <div class="form-group col-md-6">
              <label for="cicilan">Keterangan</label>
              <input type="text" name="keterangan" class="form-control form-control-sm lowercase" value="" id="cicilan">
            </div>
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary btn-sm" value="Save changes" name="hutang-pembayaran">
      </div>
    </form>
    </div>
  </div>
</div>
<?php } ?>
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