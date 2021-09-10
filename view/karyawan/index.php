<style type="text/css">
	.uppercase { text-transform: uppercase; }
	.lowercase { text-transform: lowercase; }
</style>

<div class="wrap container-fluid">
	<h1 class="wp-heading-inline">Karyawan</h1>
	<a class="page-title-action" data-toggle="modal" data-target="#exampleModal">Tambah Baru</a>
	<hr class="wp-header-end">
	<ul class="subsubsub">
		<li class="all"><a href="edit.php?post_type=post" class="current" aria-current="page">Semua <span class="count">(1)</span></a> |</li>
		<li class="publish"><a href="edit.php?post_status=publish&amp;post_type=post">Telah Terbit <span class="count">(1)</span></a></li>
	</ul>
	<p class="search-box">
		<form action="admin.php?page=konveksi-pelanggan" method="post" style="float:right;">
			<label class="screen-reader-text" for="post-search-input">Cari Karyawan:</label>
			<input type="search" id="post-search-input" name="s" value="">
			<input type="submit" id="search-submit" class="button" value="Cari Pos">
		</form>
	</p>    
    <table class="wp-list-table widefat striped table" width="100%">
      <thead>
        <tr>
          <th width="8%">Kode</th>
          <th width="25%">Nama</th>
          <th width="25%">No Handphone</th>
          <th width="20%">Total Kas Bon</th>
          <th width="10%">Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php

		foreach ($results as $print) {	

          ?>
          <tr>
            <td><?php echo $print->kode_karyawan; ?></td>
            <td><?php echo $print->nama_karyawan; ?></td>
            <td><?php echo $print->no_handphone; ?></td>
            <td><?php echo number_format($print->total_kasbon,2,",","."); ?></td>
            <td>
            	<a href='admin.php?page=konveksi-karyawan&kas-bon=<?php echo $print->kode_karyawan; ?>' class='btn btn-outline-primary btn-sm'>kas bon</a>
              <!-- <a href='admin.php?page=konveksi-karyawan&edit=<?php echo $print->kode_karyawan; ?>' class='btn btn-outline-warning btn-sm'>edit</a>
            	<a href="javascript:hapusAction(' <?php echo $print->kode_karyawan; ?>')" class='btn btn-outline-danger btn-sm'>delete</a> -->
            </td>
          </tr>
          <?php
      	  }
      ?>
      </tbody>
  </table>
	<?php
				echo paginate_links( array(
				                        'base' => add_query_arg( 'cpage', '%#%' ),
				                        'format' => '',
				                        'prev_text' => __('&laquo;'),
				                        'next_text' => __('&raquo;'),
				                        'total' => ceil($total / $items_per_page),
				                        'current' => $page
				                    ));
	?>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Karyawan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="admin.php?page=konveksi-karyawan" method="post">
      	<div class="modal-body">
      		<div class="form-row">
      			<div class="form-group col-md-6">
      				<label for="no_handphone_1">Nama Karyawan</label>
      				<input type="text" name="nama_karyawan" class="form-control form-control-sm" id="nama_karyawan">
      			</div>
      			<div class="form-group col-md-6">
      				<label for="no_handphone_2">No Handphone</label>
      				<input type="text" name="no_handphone" class="form-control form-control-sm" id="no_handphone">
      			</div>
      		</div>
      		<div class="form-row">
      			<div class="form-group col-md-6">
      				<label for="email_1">Email</label>
      				<input type="email" name="email" class="form-control form-control-sm lowercase" id="email">
      			</div>
            <div class="form-group col-md-6">
              <label for="channel">Jabatan</label>
              <select id="jabatan" name="jabatan" class="mdb-select form-control form-control-sm">
                <option selected value="0">BELUM DIKETAHUI</option>
                <?php
                  foreach ( $data['list-jabatan'] as $jabatan ) {
                ?>
                  <option value="<?php echo $jabatan->jenis_generic_master ?>"><?php echo $jabatan->value_generic_master ?></option>
                <?php } ?>
              </select>
            </div>
      		</div>
      		<div class="form-group">
      			<label for="alamat">Alamat</label>
      			<input type="text" name="alamat" class="form-control form-control-sm" id="alamat">
      		</div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="gaji_bulanan">Gaji Bulanan</label>
              <input type="number" name="gaji_bulanan" class="form-control form-control-sm lowercase" id="gaji_bulanan">
            </div>
            <div class="form-group col-md-6">
              <label for="limit_kasbon">Limit Kas Bon</label>
              <input type="numeric" name="limit_kasbon" class="form-control form-control-sm lowercase" id="limit_kasbon">
            </div>
          </div>
      	</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary btn-sm" value="Save changes" name="newsubmit">
      </div>
    </form>
    </div>
  </div>
</div>

<div id="dialogHapus" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hapus Pelanggan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="admin.php?page=konveksi-pelanggan" method="POST">
      	<div class="modal-body">
      		Apakah Yakin Menghapus Data?
      		<input type="hidden" name="id" id="id">
      	</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary btn-sm" value="Ya Hapus!" name="del">
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