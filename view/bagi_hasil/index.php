<style type="text/css">
	.uppercase { text-transform: uppercase; }
	.lowercase { text-transform: lowercase; }
  .small { 
            font-size:6px; padding:1px; }
</style>

<div class="wrap container-fluid">
	<h1 class="wp-heading-inline">Bagi Hasil</h1>
    
	<hr class="wp-header-end">
	<ul class="subsubsub">

	</ul>    
    <table class="wp-list-table widefat striped table" width="100%">
      <thead>
        <tr>
          <th width="10%">Tanggal</th>
          <th width="23%">Nama Order</th>
          <th width="7%">Marketing</th>
          <th width="5%">Pendapatan</th>
          <th width="5%">HPP</th>
          <th width="10%">Gross Profit</th>
          <th width="5%">Operations</th>
          <th width="5%">Equity</th>
          <th width="5%">Marketing</th>
          <th width="5%">Operator</th>
        
        </tr>
      </thead>
      <tbody>
      <?php

		foreach ($results as $print) {	

          ?>
          <tr>
            <td class="small"><?php echo $print->tanggal_transaksi; ?></td>
            <td class="small"><?php echo $print->nama_order; ?></td>
            <td class="small"><?php echo $print->display_name; ?></td>
            <td class="small"><?php echo number_format($print->pendapatan,2,",","."); ?></td>
            <td class="small"><?php echo number_format($print->hpp,2,",","."); ?></td>
            <td class="small"><?php echo number_format($print->gross_profit,2,",","."); ?></td>
            <td class="small"><?php echo number_format($print->operasional,2,",","."); ?></td>
            <td class="small"><?php echo number_format($print->equity,2,",","."); ?></td>
            <td class="small"><?php echo number_format($print->marketing,2,",","."); ?></td>
            <td class="small">
                              <?php 
                                      if ( $print->is_paid_operator == '1' ) { 
                                          echo '<span class="badge badge-pill badge-success">'. number_format($print->production,2,",",".") .'</span>';
                                      } else {
                                          echo '<span class="badge badge-pill badge-info">'. number_format($print->production,2,",",".") .'</span>';
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