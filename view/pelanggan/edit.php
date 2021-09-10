<style type="text/css">
      .uppercase { text-transform: uppercase; }
      .lowercase { text-transform: lowercase; }
</style>

<div class="wrap container-fluid">
      <h1 class="wp-heading-inline">Edit Pelanggan</h1>
      <hr class="wp-header-end">
      <br>
      <div class="clear"></div>    
      <form action="admin.php?page=konveksi-pelanggan" method="post">
            <?php foreach ($data['pelanggan'] as $pelanggan){ ?>
            <input type="hidden" name="id_pelanggan" value="<?php echo $pelanggan->id_pelanggan; ?>">
            <div class="form-row">
                  <div class="form-group col-md-6">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" value="<?php echo $pelanggan->nama; ?>" class="form-control form-control-sm uppercase" id="nama">
                  </div>
                  <div class="form-group col-md-6">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="mdb-select form-control">
                              <?php
                              foreach ( $data['list-gender'] as $gender ) {
                                    if ( $gender->jenis_generic_master == $pelanggan->gender ){
                                    ?>
                                    <option value="<?php echo $gender->jenis_generic_master ?>" SELECTED><?php echo $gender->value_generic_master ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $gender->jenis_generic_master ?>"><?php echo $gender->value_generic_master ?></option>
                                    <?php }
                              } ?>
                        </select>
                  </div>
            </div>
            <div class="form-row">
                  <div class="form-group col-md-6">
                        <label for="no_handphone_1">No Handphone 1</label>
                        <input type="text" value="<?php echo $pelanggan->no_telp_1; ?>" name="no_handphone_1" class="form-control form-control-sm" id="no_handphone_1">
                  </div>
                  <div class="form-group col-md-6">
                        <label for="no_handphone_2">No Handphone 2</label>
                        <input type="text" value="<?php echo $pelanggan->no_telp_2; ?>" name="no_handphone_2" class="form-control form-control-sm" id="no_handphone_1">
                  </div>
            </div>
            <div class="form-row">
                  <div class="form-group col-md-6">
                        <label for="email_1">Email 1</label>
                        <input type="email" value="<?php echo $pelanggan->email_1; ?>" name="email_1" class="form-control form-control-sm lowercase id="email_1">
                  </div>
                  <div class="form-group col-md-6">
                        <label for="email_2">Email 2</label>
                        <input type="email" value="<?php echo $pelanggan->email_2; ?>" name="email_2" class="form-control form-control-sm lowercase" id="email_2">
                  </div>
            </div>
            <div class="form-group">
                  <label for="alamat">Alamat</label>
                  <input type="text" value="<?php echo $pelanggan->alamat; ?>" name="alamat" class="form-control form-control-sm" id="alamat">
            </div>
            <div class="form-row">
                  <div class="form-group col-md-5">
                        <label for="kota">Kota</label><br>
                        <select id='selUser' name="kota" class="form-control form-control-sm">
                              <?php
                              foreach ( $data['list-kota'] as $kota ) {
                                    if ( $kota->jenis_generic_master == $pelanggan->kota ){
                                    ?>
                                    <option value="<?php echo $kota->jenis_generic_master ?>" SELECTED><?php echo $kota->value_generic_master ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $kota->jenis_generic_master ?>"><?php echo $kota->value_generic_master ?></option>
                                    <?php }
                              } ?>
                        </select>
                  </div>
                  <div class="form-group col-md-3">
                        <label for="kode_pos">Kode Pos</label>
                        <input type="text" value="<?php echo $pelanggan->kode_pos; ?>" name="kode_pos" class="form-control form-control-sm" id="kode_pos">
                  </div>
                  <div class="form-group col-md-4">
                        <label for="channel">Channel</label>
                        <select id="channel" name="channel" class="mdb-select form-control">
                              <?php
                              foreach ( $data['list-channel'] as $channel ) {
                                    if ( $channel->jenis_generic_master == $pelanggan->channel ){
                                    ?>
                                    <option value="<?php echo $channel->jenis_generic_master ?>" SELECTED><?php echo $channel->value_generic_master ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $channel->jenis_generic_master ?>"><?php echo $channel->value_generic_master ?></option>
                                    <?php }
                              } ?>
                        </select>
                  </div>
            </div>
          <input type="submit" name="uptsubmit" class="btn btn-primary btn-sm" value="Save changes"/>
          <?php } ?>
    </form>
    <br>
    <br>
    <br>
    <div class="clear"></div>    
</div>


<script>
$(document).ready(function(){
    
    // Initialize select2
    $("#selUser").select2();
    
});
</script>