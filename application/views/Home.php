<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/mdb.min.css');?>">
<title>QR Code Generator</title>
<style type="text/css">
.modal {
  padding: 0 !important;
}
.modal .modal-dialog {
  width: 100%;
  max-width: none;
  height: 100vh;
  margin: 0;
}
.modal .modal-content {
  height: 100%;
  border: 0;
  border-radius: 0;
}
.modal .modal-body {
  overflow-y: auto;
}
.close {
    color:black ! important;
    opacity:1.0;
}

tbody {
  display: block;
  overflow: auto;
  height: 100vh;
  width: 100%;
}
thead tr {
  display: table;
  width: 100%;
  table-layout: fixed;
}

thead, tbody tr {
  display: table;
  width: 100%;
  table-layout: fixed;
}

thead {
  width: calc( 100% - 1em )
}
</style>
</head>

<body>
	<div class="container">
		<div class="row justify-content-md-center">
			<div class="col-md-5">
				<div class="card shadow-sm mt-2">
					<div class="card-body">
						<div class="form-group row">
							<div class="col-sm-12">
								<input id="nama" name="nama" class="form-control text-center" type="text" onkeydown="search(this)">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row justify-content-center mt-3">
			<h1><b>Selamat Datang</b></h1>
		</div>
		<div class="row justify-content-center">
			<h3 id="nmTamu"><b>Nama</b></h3>
		</div>
		<div class="row justify-content-center">
			<h5 id="jam"><b>Jam</b></h5>
		</div>
	</div>
	
	<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content ">
				<div class="modal-header">
					<span class="mt-1"><h5><b>Data Kehadiran</b></h5></span>
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					
				</div>
				<div class="modal-body">  
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label"><b>Upload Data</b></label>
								<div class="col-sm-6">
									<input type="file" class="form-control" id="customFile" accept='.xlsx'/>
								</div>
								<div class="col-sm-3">
									<button type="button" class="btn btn-block btn-primary btn-md" id="btUpl" disabled>Upload</button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<table class="table datatable-table table-striped table-responsive table-fixed">
								<thead class="datatable-header">
				                    <tr>
				                        <th>Nama</th>
				                        <th>Alamat</th>
				                        <th>Kehadiran</th>
				                    </tr>                
				                </thead>
				                <tbody class="datatable-body" id="detData">
				                    <tr>
				                        <td>Day 1</td>
				                        <td>11/08/2016</td>
				                        <td></td>
				                        <td>$1.00</td>
				                    </tr>       
				                </tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="fixed-bottom text-right">
		<button type="button" class="btn btn-primary" id="btData" data-toggle="modal" data-target="#modal1">Data</button>
	</div>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>

<script type="text/javascript">
$(document).ready(function () {
	$("#customFile").val('');
	$('#nama').focus();
	$(window).click(function() {
		$('#nama').focus(); 
	});
	$("#modal1").on('hidden.bs.modal', function(){
		setTimeout(function(){ $('#nama').focus(); }, 500);
		
	});

	$("#btData").click(function () {
		loadData();
	})

	$("#btUpl").click(function () {
		var postData = new FormData();
		postData.append('file', $('#customFile')[0].files[0]);
		$.ajax({
			url:'<?php echo site_url();?>/Home/fileImport',
	        type:"post",
	        data: postData,
	        processData: false,
	        contentType: false,
	        cache: false,
	        async: true,
	        beforeSend: function() {
	        	//$('#loader').jqxLoader('open'); 
            },
            success: function (response) {
            	
            },
            error: function (xhr, ajaxOptions, thrownError) {
            	//toastr.success(thrownError);
            },
            complete: function (xhr) {
            	loadData();
            }
	    });
	});

	$(document).on('change', '#customFile', function(e){
		console.log(e.target.files[0].name);
		if ($("#customFile").val() != "") {
			$("#btUpl").removeAttr("disabled");
		} else {
			$("#btUpl").attr('disabled', true);
		}
	});
	$("#btUpl").attr('disabled', true);
});

function search(ele) {
    if(event.key === 'Enter') {
        //alert(ele.value);
    	var url = '<?php echo site_url();?>/Home/getTamu';
    	$.ajax({
    	    type: "POST",
    	    data: {
    	      nama: ele.value
    	    },
    	    url: url,
    	    dataType: "html",
    	    async: false,
    	    success: function(data) {
    	      //alert(data);
				if (data == 'false') {
					alert("Data Tidak ditemukan");
				} else {
					data = JSON.parse(data);
					$("#nmTamu").html(data['nama']+"<br>"+data['alamat']);
	    	    	$("#jam").html(data['jam']);
				} 
    	    }
    	  });      
        ele.value = "";      
    }
}

function loadData()
{
	$("#detData").empty();
	$.ajax({
		cache:false,
		type: "POST",
		url: '<?php echo site_url();?>/Home/getHadir',    
		beforeSend: function() {
//         	$('#loader').jqxLoader('open'); 
        },
		success: function (html){
// 			$("#grid").jqxGrid('updatebounddata', 'cells');  
// 			toastr.success(html);
		}, 
		error: function (xhr, ajaxOptions, thrownError) {
//         	toastr.success(thrownError);
        },
        complete: function (xhr) {
        	var data = JSON.parse(xhr.responseText);
        	for (i = 0; i < data.length; i++) {
        		$("#detData").append("<tr>"+
                        "<td>"+data[i]["guest_name"]+"</td>"+
                        "<td>"+data[i]["guest_addr"]+"</td>"+
                        "<td>"+data[i]["guest_date"]+"</td>"+
                    "</tr> ");
        	}
//         	$('#modal-alert').modal('hide');
// 	    	$('#loader').jqxLoader('close');
        }
	});
}
</script>
</body>
