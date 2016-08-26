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


  	<div class="panel panel-default">
  		<div class="panel-heading">
        	<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      	</div>


      	<div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-center"><?php echo $column_id?></td>
                  <td class="text-center"><?php echo $column_email?></td>
                  <td class="text-center"><?php echo $column_name?></td>
                  <td class="text-center"><?php echo $column_status?></td>
                  <td class="text-center"><?php echo $column_featured?></td>
                  <td class="text-center"><?php echo $column_customer_link?></td>
                  <td class="text-center"><?php echo $column_channel_id?></td>
                  <td class="text-center"><?php echo $column_actions?></td>
                </tr>
              </thead>
              <tbody>
              	<?php foreach($videos['result'] as $video):?>
              		<tr>
              			<td class="text-center"><?php echo $video['id']?></td>
              			<td class="text-center"><?php echo $video['email']?></td>
              			<td class="text-center"><?php echo $video['name']?></td>
              			<td class="text-center"><?php echo $video['videoStatus']?></td>
              			<td class="text-center"><?php echo $video['featured']?></td>
              			<td class="text-center"><?php echo $video['customerLink']?></td>
              			<td class="text-center"><?php echo $video['channelLink']?></td>
              			<td class="text-center"></td>
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
<?php echo $footer; ?>