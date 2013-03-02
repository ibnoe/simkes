<html>
	<head>
	<title>Ajax File Uploader Plugin For Jquery</title>
	<link href="ajaxfileupload.css" type="text/css" rel="stylesheet">
	<script type="text/javascript" src="<?php echo base_url()?>asset/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>asset/js/ajaxfileupload.js"></script>
	<script type="text/javascript">
	function ajaxFileUpload()
	{
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});

		$.ajaxFileUpload
		(
			{
				url:'./upload/do_upload',
				secureuri:false,
				fileElementId:'gambar',
				dataType: 'json',
				//data:{name:'logan', id:'id'},
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert('data.error');
							alert(data.error);
						}else
						{
							alert('data.msg');
							alert(data.msg);
							alert(data.pesan);
						}
					}
				},
				error: function (data, status, e)
				{
					alert('Ayo jangan Patah Semangat');
					alert(e);
					
				}
			}
		)
		
		return false;

	}
	</script>	
	</head>

	<body>

    <div id="content">
    	 	
		<img id="loading" src="loading.gif" style="display:none;">
		<form name="form" action="" method="POST" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" class="tableForm">

		<thead>
			<tr>
				<th>Please select a file and click Upload button</th>
			</tr>
		</thead>
		<tbody>	
			<tr>
				<td><input id="userfile" type="file" size="45" name="userfile" class="input"></td>			</tr>

		</tbody>
			<tfoot>
				<tr>
					<td><button class="button" id="buttonUpload" onclick="return ajaxFileUpload();">Upload</button></td>
				</tr>
			</tfoot>
	
	</table>
		</form>    	
    </div>
    

	</body>
</html>