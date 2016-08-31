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
        	<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      	</div>
         <div class="panel-body">

          <div class="well">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="search-string"><?php echo $entry_search; ?></label>
                <input type="text" name="search_string" value="<?php echo $search_string; ?>" placeholder="<?php echo $entry_search; ?>" id="search-string" class="form-control" />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="select-status"><?php echo $entry_status; ?></label>
                <select name="select_status" id="select-status" class="form-control">
                  <option value="*"></option>
                  <option value="new" <?php if($select_status == 'new') echo "selected";?>><?php echo $status_new;?></option>
                  <option value="download" <?php if($select_status == 'download') echo "selected";?>><?php echo $status_download;?></option>
                  <option value="downloaded" <?php if($select_status == 'downloaded') echo "selected";?>><?php echo $status_downloaded?></option>
                  <option value="upload" <?php if($select_status == 'upload') echo "selected";?>><?php echo $status_upload;?></option>
                  <option value="not_ready" <?php if($select_status == 'not_ready') echo "selected";?>><?php echo $status_not_ready;?></option>
                  <option value="ready" <?php if($select_status == 'ready') echo "selected";?>><?php echo $status_ready;?></option>
                  <option value="error_upload" <?php if($select_status == 'error_upload') echo "selected";?>><?php echo $status_error_upload;?></option>
                  <option value="error_download" <?php if($select_status == 'error_download') echo "selected";?>><?php echo $status_error_download;?></option>
                </select>
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

                    <td class="text-center"><button id="nextStatus<?php echo $video['id'];?>" type="button" link="<?php echo $video['change_status'];?>"

<?php switch($video['videoStatus']):?>
<?php case 'new': echo ' class="btn btn-info"> ' . $status_new;?>
<?php break;?>
<?php case 'download': echo ' class="btn btn-deafult"> ' . $status_download;?>
<?php break;?>
<?php case 'downloaded': echo ' class="btn btn-primary"> ' . $status_downloaded;?>
<?php break;?>
<?php case 'upload': echo ' class="btn btn-default"> ' . $status_upload;?>
<?php break;?>
<?php case 'ready': echo ' class="btn btn-success"> ' . $status_ready;?>
<?php break;?>
<?php case 'err_download': echo ' class="btn btn-danger"> ' . $status_error_download;?>
<?php break;?>
<?php case 'err_upload': echo ' class="btn btn-danger"> ' . $status_error_upload;?>
<?php break;?>
<?php case 'not_ready': echo ' class="btn btn-warning"> ' . $status_not_ready;?>
<?php break;?>
<?php endswitch;?>

                    </button></td>


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
jQuery.expr[':'].regex = function(elem, index, match) {
    var matchParams = match[3].split(','),
        validLabels = /^(data|css):/,
        attr = {
            method: matchParams[0].match(validLabels) ?
                        matchParams[0].split(':')[0] : 'attr',
            property: matchParams.shift().replace(validLabels,'')
        },
        regexFlags = 'ig',
        regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
    return regex.test(jQuery(elem)[attr.method](attr.property));
}

$("button:regex(id, ^nextStatus[0-9]+$)").click(function(e){
        e.preventDefault();
        var linkObj = this;
        $.ajax ({
            type: 'GET',
            url: $(this).attr('link'),
            success : function(data){
               if(data.result == true) {
                    $(linkObj).empty();
                    switch (data.status) {
                        case 'new':
                        $(linkObj).attr('class', 'btn btn-info');
                        $(linkObj).text('<?php echo $status_new?>');
                        break;

                        case 'download':
                        $(linkObj).attr('class', 'btn btn-default');
                        $(linkObj).text('<?php echo $status_download?>');
                        break;

                        case 'downloaded':
                        $(linkObj).attr('class', 'btn btn-primary');
                        $(linkObj).text('<?php echo $status_downloaded?>');
                        break;

                        case 'upload':
                        $(linkObj).attr('class', 'btn btn-default');
                        $(linkObj).text('<?php echo $status_upload?>');
                        break;

                        case 'not_ready':
                        $(linkObj).attr('class', 'btn btn-warning');
                        $(linkObj).text('<?php echo $status_not_ready?>');
                        break;

                        case 'ready':
                        $(linkObj).attr('class', 'btn btn-success');
                        $(linkObj).text('<?php echo $status_ready?>');
                        break;
                    }
               }
            },
            dataType: 'json'
        });
    });


$('#button-filter').on('click', function() {
  url = 'index.php?route=video/video&token=<?php echo $token; ?>';
  
  var search_string = $('input[name=\'search_string\']').val();
  
  if (search_string) {
    url += '&search_string=' + encodeURIComponent(search_string);
  }
  
  var select_status = $('select[name=\'select_status\']').val();
  
  if (select_status != '*') {
    url += '&select_status=' + encodeURIComponent(select_status);
  } 
  
  location = url;
});
</script>
</div>
<?php echo $footer; ?>