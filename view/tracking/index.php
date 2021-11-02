<style type="text/css">
	.uppercase { text-transform: uppercase; }
	.lowercase { text-transform: lowercase; }
</style>

<div class="wrap container-fluid">
	<h1 class="wp-heading-inline">Tracking Progress</h1>
    
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
          <th width="8%">Dateline</th>
          <th width="25%">No. Transaksi</th>
          <th width="25%">Marketing</th>
          <th width="25%">Customer</th>
          <th width="20%">Nama Order</th>
          <th width="5%">WO</th>
          <th width="5%">Film</th>
          <th width="5%">Jahit</th>
          <th width="5%">Sablon</th>
          <th width="5%">Packing</th>
          <th width="5%">Finish</th>

        </tr>
      </thead>
      <tbody>
      <?php

		foreach ($results as $print) {	

          ?>
          <tr>
            <td><?php echo $print->dateline; ?></td>
            <td><?php echo $print->no_transaksi; ?></td>
            <td><?php echo $print->marketing; ?></td>
            <td><?php echo $print->cust; ?></td>
            <td><?php echo $print->nama_order; ?></td>
            <td><?php echo $print->work_order; ?></td>
            <td><?php echo $print->film; ?></td>
            <td><?php echo $print->jahit; ?></td>
            <td><?php echo $print->sablon; ?></td>
            <td><?php echo $print->packing; ?></td>
            <td><?php echo $print->finish; ?></td>
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