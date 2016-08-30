<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
    	<div class="container-fluid">
			<div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        		<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-customer').submit() : false;"><i class="fa fa-trash-o"></i></button>
      		</div>
      		<h1><?php echo $heading_title; ?></h1>
      		<ul class="breadcrumb">
        	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
        		<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        	<?php } ?>
      		</ul>
    	</div>
  	</div>


    <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
  	<div class="panel panel-default">
  		<div class="panel-heading">
        	<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      	</div>


      	<div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                 <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" 	/></td>
                  <td class="text-center"><?php if ($order & ORDER_BY_ID) { ?>
                  	<a href="<?php echo $order_id; ?>" class="id"><?php echo $column_id?></a>
                  	<?php } else {?>
                  	<a href="<?php echo $order_id; ?>"><?php echo $column_id?></a>
                  	<?php }?>
                  </td>
                   <td class="text-center"><?php if ($order & ORDER_BY_EMAIL) { ?>
                  	<a href="<?php echo $order_email; ?>" class="email"><?php echo $column_email?></a>
                  	<?php } else {?>
                  	<a href="<?php echo $order_email; ?>"><?php echo $column_email?></a>
                  	<?php }?>
                  </td>
                  <td class="text-center"><?php if ($order & ORDER_BY_NAME) { ?>
                  	<a href="<?php echo $order_name; ?>" class="name"><?php echo $column_name?></a>
                  	<?php } else {?>
                  	<a href="<?php echo $order_name; ?>"><?php echo $column_name?></a>
                  	<?php }?>
                  </td>
                   <td class="text-center"><?php if ($order & ORDER_BY_STATUS) { ?>
                  	<a href="<?php echo $order_status; ?>" class="status"><?php echo $column_status?></a>
                  	<?php } else {?>
                  	<a href="<?php echo $order_status; ?>"><?php echo $column_status?></a>
                  	<?php }?>
                  </td>
                   <td class="text-center"><?php if ($order & ORDER_BY_FEATURED) { ?>
                  	<a href="<?php echo $order_featured; ?>" class="name"><?php echo $column_featured?></a>
                  	<?php } else {?>
                  	<a href="<?php echo $order_featured; ?>"><?php echo $column_featured?></a>
                  	<?php }?>
                  </td>
                  <td class="text-center"><?php echo $column_customer_link?></td>
                  <td class="text-center"><?php echo $column_channel_id?></td>
                  <td class="text-center"><?php echo $column_actions?></td>
                </tr>
              </thead>
              <tbody>
              	<?php foreach($videos['result'] as $video):?>
              		<tr>
              			<td class="text-center"><?php if (in_array($video['id'], $selected)) { ?>
                    	<input type="checkbox" name="selected[]" value="<?php echo $video['id']; ?>" checked="checked" />
                    	<?php } else { ?>
                    	<input type="checkbox" name="selected[]" value="<?php echo $video['id']; ?>" />
                    	<?php } ?></td>
              			<td class="text-center"><?php echo $video['id']?></td>
              			<td class="text-center"><?php echo $video['email']?></td>
              			<td class="text-center"><?php echo $video['name']?></td>
              			<td class="text-center"><?php echo $video['videoStatus']?></td>
              			<td class="text-center"><?php echo $video['featured']?></td>
              			<td class="text-center"><a href="<?php echo $video['customerLink']?>" target="_blank"><?php echo $video['customerLink']?></a></td>
              			<td class="text-center"><a href="http://youtu.be/<?php echo $video['channelLink']?>" target="_blank"><?php echo $video['channelLink']?></a></td>
              			<td class="text-center">
              				<a href="<?php echo $video['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
              			</td>
              		</tr>
              	<?php endforeach;?>
              </tbody>
            </table>
            <div class="row">
          		<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          		<div class="col-sm-6 text-right"><?php echo $results; ?></div>
        	</div>
          </div>
  	</div>
  </div>
</div>
<?php echo $footer; ?>