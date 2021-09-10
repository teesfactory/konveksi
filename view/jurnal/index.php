<style type="text/css">
	.uppercase { text-transform: uppercase; }
	.lowercase { text-transform: lowercase; }
</style>

<div class="wrap container-fluid">
	<h1 class="wp-heading-inline">Jurnal</h1>
	<a class="page-title-action" href="admin.php?page=konveksi-jurnal&create=new">Tambah Baru</a>
	<hr class="wp-header-end">
	<ul class="subsubsub">
		<li class="all"><a href="edit.php?post_type=post" class="current" aria-current="page">Semua <span class="count">(1)</span></a> |</li>
		<li class="publish"><a href="edit.php?post_status=publish&amp;post_type=post">Telah Terbit <span class="count">(1)</span></a></li>
	</ul>
	<p class="search-box">
		<form action="admin.php?page=konveksi-pelanggan" method="post" style="float:right;">
			<label class="screen-reader-text" for="post-search-input">Cari Jurnal:</label>
			<input type="search" id="post-search-input" name="s" value="">
			<input type="submit" id="search-submit" class="button" value="Cari Pos">
		</form>
	</p>    
    <table class="wp-list-table widefat striped table" width="100%">
      <thead>
        <tr>
          <th width="15%">No Transaksi</th>
          <th width="10%">Tanggal</th>
          <th width="10%">Akun</th>
          <th width="40%">Keterangan</th>
          <th width="5%">(+/-)</th>
          <th width="15%">Nominal</th>
        </tr>
      </thead>
      <tbody>
      <?php

		foreach ($results as $print) {	

          ?>
          <tr>
            <td><?php echo $print->no_transaksi; ?></td>
            <td><?php echo $print->tanggal; ?></td>
            <td><?php echo $print->keterangan_1 .' '. $print->keterangan_2 .' '. $print->keterangan_3 .' '. $print->keterangan_4; ?></td>
            <td><?php echo $print->sign; ?></td>
            <td><?php echo number_format($print->nominal,2,",","."); ?></td>
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