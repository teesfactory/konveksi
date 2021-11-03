<style type="text/css">
	.uppercase { text-transform: uppercase; }
	.lowercase { text-transform: lowercase; }
  .small { 
            font-size:6px; padding:1px; }
</style>

<div class="wrap container-fluid">
	<h1 class="wp-heading-inline">Tracking Progress</h1>
    
	<hr class="wp-header-end">
	<ul class="subsubsub">

	</ul>    
    <table class="wp-list-table widefat striped table" width="100%">
      <thead>
        <tr>
          <th width="10%">Dateline</th>
          <th width="15%">No. Transaksi</th>
          <th width="25%">Customer</th>
          <th width="30%">Nama Order</th>
          <th width="3%">WO</th>
          <th width="3%">Film</th>
          <th width="3%">Jahit</th>
          <th width="3%">Sablon</th>
          <th width="3%">Packing</th>
          <th width="3%">Finish</th>

        </tr>
      </thead>
      <tbody>
      <?php

		foreach ($results as $print) {	

          ?>
          <tr>
            <td class="small"><?php echo $print->dateline; ?></td>
            <td class="small"><?php echo $print->no_transaksi; ?></td>
            <td class="small"><?php echo $print->cust; ?></td>
            <td class="small"><?php echo $print->nama_order; ?></td>
            <td class="small">
              <?php 
                    if ( $print->work_order == 0 ) {
                      echo "<span class='dashicons dashicons-dismiss'  style='color:red'></span>";
                    }else{
                      echo "<span class='dashicons dashicons-yes-alt'  style='color:green'></span>";
                    }                              
              ?>
            </td>
            <td class="small">
              <?php 
                    if ( $print->film == 0 ) {
                      echo "<span class='dashicons dashicons-dismiss'  style='color:red'></span>";
                    }else{
                      echo "<span class='dashicons dashicons-yes-alt'  style='color:green'></span>";
                    }                              
              ?>
            </td>
            <td class="small">
              <?php 
                    if ( $print->jahit == 0 ) {
                      echo "<span class='dashicons dashicons-dismiss'  style='color:red'></span>";
                    }else{
                      echo "<span class='dashicons dashicons-yes-alt'  style='color:green'></span>";
                    }                            
              ?>
            </td>
            <td class="small">
              <?php 
                    if ( $print->sablon == 0 ) {
                      echo "<span class='dashicons dashicons-dismiss'  style='color:red'></span>";
                    }else{
                      echo "<span class='dashicons dashicons-yes-alt'  style='color:green'></span>";
                    }                            
              ?>
            </td>
            <td class="small">
              <?php 
                    if ( $print->pakcing == 0 ) {
                      echo "<span class='dashicons dashicons-dismiss'  style='color:red'></span>";
                    }else{
                      echo "<span class='dashicons dashicons-yes-alt'  style='color:green'></span>";
                    }                             
              ?>
            </td>
            <td class="small">
              <?php 
                    if ( $print->finish == 0 ) {
                      echo "<span class='dashicons dashicons-dismiss'  style='color:red'></span>";
                    }else{
                      echo "<span class='dashicons dashicons-yes-alt'  style='color:green'></span>";
                    }                             
              ?>
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