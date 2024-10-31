<div id="fxd-container" style="margin-right: 320px;">
  <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="<?php echo admin_url( 'options-general.php?page=fxd-brandplugin.php' );?>" >
    <?php wp_nonce_field( 'security-setting' ); ?>
    <?php
include('branding_form.php');
		foreach($fxdOptions as $value){
			switch($value['type']){
			case "file":
?>
    <div class="clearfix"></div>
    <div class="form-group">
      <label class="col-sm-3 control-label" for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
      <div class="col-sm-9">
        <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>"/>
        <input name="upload_image_button" type="button" value="Upload" rel="<?php echo $value['id']; ?>" class="<?php echo $value['class']; ?>"/>
        <small><?php echo $value['description']; ?></small> </div>
      <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <?php 	
break;
case "radio":
?>
    <div class="clearfix"></div>
    <div class="from-group">
      <label class="col-sm-3 control-label"  for="<?php echo $value['id']; ?>" ><?php echo $value['name']; ?></label>
      <div class="col-sm-9">
        <?php  
		if(!empty($value['option_value'])){
			$i = 0;
	foreach($value['option_value'] as $row){ 
	$checked=''; if( ( get_option($value['id']) || get_option($value['id']) == '0' ) && (get_option($value['id']) ==  $row)){ $checked = "checked=\"checked\""; }elseif( (! get_option($value['id']) ) && $row == $value['std']){ $checked = "checked=\"checked\""; } else { $checked = ""; } 
?><input type="radio" value="<?php echo $row; ?>" <?php echo $checked; ?> id="<?php echo $value['id'].$i ;?>" name="<?php echo $value['id'] ?>" />
        <?php echo isset($value['option_text'][$i])?$value['option_text'][$i]:''; ?>
        <?php $i++;
		}
}?>
      </div>
    </div>
    <div class="clearfix"></div>
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
    <?php			}
		}
?>
    <input name="save" type="submit" class="btn btn-success" value="Save changes" />
    <input type="hidden" name="action" value="save" />
  </form>
</div>