<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
    	<div class="container-fluid">
			<div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        		<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-video').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
				<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_groups_list; ?></h3>
			</div>
			<div class="panel-body">

				<div class="well">
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label" for="search-string"><?php echo $entry_search; ?></label>
								<input type="text" name="search_string" value="<?php echo $search_string; ?>" placeholder="<?php echo $entry_search; ?>" id="search-string" class="form-control" />
							</div>            
							<button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
						</div>
					</div>
				</div>

				 <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-video">
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
								<td class="text-center"><?php if ($order & ORDER_BY_NAME) { ?>
									<a href="<?php echo $order_name; ?>" class="name"><?php echo $column_name?></a>
									<?php } else {?>
									<a href="<?php echo $order_name; ?>"><?php echo $column_name?></a>
									<?php }?>
								</td>
								<td class="text-center"><?php echo $column_associated?></td>
								<td class="text-center"><?php echo $column_actions?></td>
							</tr>
						</thead>
						<tbody>
							<?php foreach($groups['result'] as $group):?>
              					<tr>
              						<td class="text-center"><?php if (in_array($group['id'], $selected)) { ?>
                    					<input type="checkbox" name="selected[]" value="<?php echo $group['id']; ?>" checked="checked" />
                    					<?php } else { ?>
                    					<input type="checkbox" name="selected[]" value="<?php echo $group['id']; ?>" />
                    				<?php } ?></td>
              						<td class="text-center"><?php echo $group['id']?></td>
              						<td class="text-center"><?php echo $group['name']?></td>
              						<td class="text-center"><button id="assocs<?php echo $group['id'];?>" type="button" link="<?php echo $group['change_assoc'];?>"
                   						 <?php if($group['associated'] == 1) echo ' class="btn btn-danger">' . $text_associated; else echo ' class="btn btn-default">' . $text_not_associated;?></button>
                    				</td>
              						<td class="text-center">
              							<a href="<?php echo $group['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
              						</td>
              					</tr>
              				<?php endforeach;?>
						</tbody>
					</table>
      				</div>
      			</form>

				<div class="row">
					<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
					<div class="col-sm-6 text-right"><?php echo $results; ?></div>
				</div>
		</div>



			
       </div>
    </div>
<script type="text/javascript">
	
</script>
</div>
<?php echo $footer; ?>