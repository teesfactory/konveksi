<style type="text/css">
	.uppercase { text-transform: uppercase; }
	.lowercase { text-transform: lowercase; }
</style>

<div class="wrap container-fluid">
	<h1 class="wp-heading-inline">Pelanggan</h1>
	<a class="page-title-action" data-toggle="modal" data-target="#exampleModal">Tambah Baru</a>
	<hr class="wp-header-end">
	<ul class="subsubsub">
		<li class="all"><a href="edit.php?post_type=post" class="current" aria-current="page">Semua <span class="count">(1)</span></a> |</li>
		<li class="publish"><a href="edit.php?post_status=publish&amp;post_type=post">Telah Terbit <span class="count">(1)</span></a></li>
	</ul>
	<p class="search-box">
		<form action="admin.php?page=konveksi-pelanggan" method="post" style="float:right;">
			<label class="screen-reader-text" for="post-search-input">Cari Pelanggan:</label>
			<input type="search" id="post-search-input" name="s" value="">
			<input type="submit" id="search-submit" class="button" value="Cari Pos">
		</form>
	</p>    
    <table class="wp-list-table widefat striped table" width="100%">
      <thead>
        <tr>
          <th width="8%">User ID</th>
          <th width="25%">Nama</th>
          <th width="25%">Kota Desc</th>
          <th width="25%">Email</th>
          <th width="20%">Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php

		foreach ($results as $print) {	

          ?>
          <tr>
            <td><?php echo $print->no_pelanggan; ?></td>
            <td><?php echo $print->nama; ?></td>
            <td><?php echo $print->kota_desc; ?></td>
            <td><?php echo $print->email_1; ?></td>
            <td>
            	<a href='admin.php?page=konveksi-pelanggan&edit=<?php echo $print->id_pelanggan; ?>' class='btn btn-outline-warning btn-sm'>edit</a>
            	<!--<a href="javascript:hapusAction(' <?php echo $print->id_pelanggan; ?>')" class='btn btn-outline-danger btn-sm'>delete</a> -->
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
        <h5 class="modal-title" id="exampleModalLabel">Add Pelanggan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="admin.php?page=konveksi-pelanggan" method="post">
      	<div class="modal-body">
      		<div class="form-row">
      			<div class="form-group col-md-6">
      				<label for="nama">Nama</label>
      				<input type="text" name="nama" class="form-control form-control-sm uppercase" id="nama">
      			</div>
      			<div class="form-group col-md-6">
      				<label for="gender">Gender</label>
      				<select id="gender" name="gender" class="form-control form-control-sm">
      					<option value='0' selected>BELUM DIKETAHUI</option>
      					<option value='1'>Pria</option>
      					<option value='2'>Wanita</option>
      				</select>
      			</div>
      		</div>
      		<div class="form-row">
      			<div class="form-group col-md-6">
      				<label for="no_handphone_1">No Handphone 1</label>
      				<input type="text" name="no_handphone_1" class="form-control form-control-sm" id="no_handphone_1">
      			</div>
      			<div class="form-group col-md-6">
      				<label for="no_handphone_2">No Handphone 2</label>
      				<input type="text" name="no_handphone_2" class="form-control form-control-sm" id="no_handphone_1">
      			</div>
      		</div>
      		<div class="form-row">
      			<div class="form-group col-md-6">
      				<label for="email_1">Email 1</label>
      				<input type="email" name="email_1" class="form-control form-control-sm lowercase" id="email_1">
      			</div>
      			<div class="form-group col-md-6">
      				<label for="email_2">Email 2</label>
      				<input type="email" name="email_2" class="form-control form-control-sm lowercase" id="email_2">
      			</div>
      		</div>
      		<div class="form-group">
      			<label for="alamat">Alamat</label>
      			<input type="text" name="alamat" class="form-control form-control-sm" id="alamat">
      		</div>
      		<div class="form-row">
      			<div class="form-group col-md-6">
      				<label for="kota">Kota</label><br>
      				<select id='selUser' name="kota" class="form-control form-control-sm">
      					<option selected value="0000">BELUM DIKETAHUI</option>
      					<?php
      						foreach ( $data['list-kota'] as $kota ) {
      					?>
      						<option value="<?php echo $kota->jenis_generic_master ?>"><?php echo $kota->value_generic_master ?></option>
      					<?php } ?>
      				</select>
      			</div>
      			<div class="form-group col-md-6">
      				<label for="kode_pos">Kode Pos<br></label>
      				<input type="text" name="kode_pos" class="form-control form-control-sm" id="kode_pos">
      			</div>
      		</div>
      		<div class="form-row">
      			<div class="form-group col-md-6">
      				<label for="channel">Channel</label>
      				<select id="channel" name="channel" class="mdb-select form-control form-control-sm">
      					<?php
      						foreach ( $data['list-channel'] as $channel ) {
      					?>
      						<option value="<?php echo $channel->jenis_generic_master ?>"><?php echo $channel->value_generic_master ?></option>
      					<?php } ?>
      				</select>
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

