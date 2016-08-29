<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
     		<div class="pull-right">
				<button type="button" id="getyoutubeinfo" data-toggle="tooltip" title="<?php echo $button_get_content; ?>" class="btn btn-primary"><i class="fa fa-upload"></i></button>
        		<button type="submit" form="form-customer" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        		<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-custom-field" class="form-horizontal">

				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
						<div class="col-sm-10">
							<select name="status" id="input-status" class="form-control">
								<option value="new"><?php echo $status_new;?></option>
								<option value="download"><?php echo $status_download;?></option>
								<option value="downloaded"><?php echo $status_downloaded?></option>
								<option value="upload"><?php echo $status_upload;?></option>
								<option value="not_ready"><?php echo $status_not_ready;?></option>
								<option value="ready"><?php echo $status_ready;?></option>
								<option value="error_upload"><?php echo $status_error_upload;?></option>
								<option value="error_download"><?php echo $status_error_download;?></option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="name"><?php echo $entry_name; ?></label>
						<div class="col-sm-10">
							<input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="name" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="description"><?php echo $entry_description; ?></label>
						<div class="col-sm-10">
							<textarea name="description" placeholder="<?php echo $entry_description; ?>" id="description" class="form-control">
								<?php echo $description;?>
							</textarea>
						</div>
					</div>

					<div class="form-group required">
						<label class="col-sm-2 control-label" for="customer_link"><?php echo $entry_customer_link; ?></label>
						<div class="col-sm-10">
							<input type="text" name="customer_link" id="customer_link" value="<?php echo $customer_link; ?>" placeholder="<?php echo $entry_customer_link; ?>" id="customer_link" class="form-control" />
								<?php if ($error_customer_link) { ?>
									<div class="text-danger"><?php echo $error_customer_link; ?></div>
								<?php  } ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="channel_link"><?php echo $entry_channel_link; ?></label>
						<div class="col-sm-10">
							<input type="text" name="channel_link" value="<?php echo $channel_link; ?>" placeholder="<?php echo $entry_channel_link; ?>" id="channel_link" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label"><?php echo $entry_featured; ?></label>
						<div class="col-sm-10">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="featured" value="1" />
								</label>
							</div>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
<script type="text/javascript">
	$("#getyoutubeinfo").click(function(e){
        e.preventDefault();
        var customerLink = $('#customer_link').val();
        var parts = customerLink.split('=');
        if(parts[1] != undefined) {
            $.ajax ({
                type: 'GET',
                url: '/admin/index.php?route=video/video/getYoutubeContent&token=<?php echo $token?>&video_id=' + parts[1],
                success : function(data){
                    if(data.result == true) {
                        $("#name").val(data.name);
                        $('#description').text(data.description);
                    }
                },
                dataType: 'json'
            });
        }
    });
</script>
</div>
<?php echo $footer; ?>