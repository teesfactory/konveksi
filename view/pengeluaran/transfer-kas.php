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
  <form id="form-penjualan" action="admin.php?page=konveksi-pengeluaran" method="post">
    <input type="hidden" name="poscode" value="<?php echo $data['poscode']; ?>">
    <table class="wp-list-table widefat table-bordered table" width="100%">
      <thead>
        <tr>
          <th colspan="4">Transfer Kas</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td width="15%">Tanggal</td>
          <td width="75%"><input type="date" name="tanggal" class="form-control form-control-sm"></td>
        </tr>
        <tr>
          <td width="15%">Dari</td>
          <td width="75%">
              <select id="akun" name="dari" class="mdb-select form-control form-control-sm">
                <option selected value="0">BELUM DIKETAHUI</option>
                <?php
                  foreach ( $data['masterjurnal'] as $masterjurnal ) {
                ?>
                  <option value="<?php echo $masterjurnal->kode_masterjurnal ?>"><?php echo $masterjurnal->nama_masterjurnal ?></option>
                <?php } ?>
              </select>
          </td>
        </tr>
        <tr>
          <td width="15%">Ke</td>
          <td width="75%">
              <select id="akun" name="ke" class="mdb-select form-control form-control-sm">
                <option selected value="0">BELUM DIKETAHUI</option>
                <?php
                  foreach ( $data['masterjurnal'] as $masterjurnal ) {
                ?>
                  <option value="<?php echo $masterjurnal->kode_masterjurnal ?>"><?php echo $masterjurnal->nama_masterjurnal ?></option>
                <?php } ?>
              </select>              
          </td>
        </tr>
        <tr>
          <td width="15%">Keterangan</td>
          <td width="75%"><input type="text" class="form-control form-control-sm" name="keterangan"></td>
        </tr>
        <tr>
          <td width="15%">Nominal</td>
          <td width="75%"><input type="number" name="nominal" value="0" class="form-control form-control-sm"></td>
        </tr>
      </tbody>
    </table>
    <button type="submit" class="btn btn-primary" name="submit-kas">Simpan</button>
  </form>     
			
</div>



