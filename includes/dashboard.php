<div id="fxd-container" style="margin-right: 320px;">
  <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="<?php echo admin_url( 'options-general.php?page=fxd-brandplugin.php' );?>" >
    <?php wp_nonce_field( 'security-setting' ); ?>
    <?php
include('dashboardForm.php');
		foreach($fxdOptionsDashboard as $value){
			switch($value['type']){
			case "select":
?>
    <div class="form-group">
      <label for="fxd_pwpa_welcome_visible_to" class="col-sm-3 control-label"><?php echo $value['name']; ?></label>
      <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
        <option value="0">choose a role</option>
        <?php foreach ($value['options'] as $role => $option) { ?>
        <option value="<?php echo $role;?>"<?php if (get_option( $value['id'] ) == $role) { echo 'selected="selected"'; } elseif ($role==$value['std']) {echo 'selected="selected"';} ?>><?php echo $option; ?></option>
        <?php } ?>
      </select>
      <small><?php echo $value['description']; ?></small>
      <div class="clearfix"></div>
    </div>
    <?php
break;
case "text":
?>
    <div class="clearfix"></div>
    <div class="from-group">
      <label class="col-sm-3 control-label" for="<?php echo $value['id']; ?>" ><?php echo $value['name']; ?></label>
      <div class="col-sm-9">
        <input type="text" name="<?php echo $value['id'] ?>" id="<?php echo $value['id'] ?>" value="<?php if ( get_option( $value['id'] ) != "") {
		 echo stripslashes(get_option( $value['id'])  ); 
		 } else { 
		 echo $value['std']; 
		 } ?>"  />
        <small><?php echo $value['description']; ?></small> </div>
    </div>
    <div class="clearfix"></div>
    <?php
 break;
 case "textarea":
 ?>
    <div class="form-group">
      <label for="<?php echo $value['id']; ?>" class="col-sm-3 control-label"><?php echo $value['name']; ?></label>
      <div class="col-sm-9">
        <textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo $value['std']; } ?>
</textarea>
        <small><?php echo $value['description']; ?></small></div>
      <div class="clearfix"></div>
    </div>
    <?php 
 break;
 case "subtitle":

 ?>
    <div class="section">
      <div class="subtitle">
        <h3><?php echo $value['name']; ?></h3>
        <div class="clearfix"></div>
      </div>
    </div>
    <?php			
	}
		}

?>
    <input name="save" type="submit" class="btn btn-success" value="Save changes" />
    <input type="hidden" name="action" value="save" />
  </form>
</div>