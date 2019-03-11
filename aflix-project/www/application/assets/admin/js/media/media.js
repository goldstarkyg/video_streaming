var manager = new Vue({
	el: '#filemanager',
	data: {
  		files: '',
  		folders: [],
  		selected_file: '',
  		directories: [],
	},
});




$(function(){

	$("#upload").dropzone({ 
		url: "/admin/media/upload", 
		previewsContainer: "#uploadPreview",
		totaluploadprogress: function(uploadProgress, totalBytes, totalBytesSent){
			$('#uploadProgress .progress-bar').css('width', uploadProgress + '%');
			if(uploadProgress == 100){
				$('#uploadProgress').delay(1500).slideUp(function(){
					$('#uploadProgress .progress-bar').css('width', '0%');
				});
				
			}
		},
		processing: function(){
			$('#uploadProgress').fadeIn();
		},
		sending: function(file, xhr, formData) {
			formData.append("upload_path", manager.files.path);
		},
		success: function(e, res){
			if(res.success){
				toastr.success(res.message, "Sweet Success!");
			} else {
				toastr.error(res.message, "Whoopsie!");
			}
		},
		error: function(e, res, xhr){
			toastr.error(res, "Whoopsie");
		},
		queuecomplete: function(){
			getFiles(manager.folders);
		}
	});

	getFiles('/');


	$('#files').on("dblclick", "li .file_link", function(){
		manager.folders.push( $(this).data('folder') );
		getFiles(manager.folders);
	});

	$('#files').on("click", "li", function(e){
		var clicked = e.target;
		if(!$(clicked).hasClass('file_link')){
			clicked = $(e.target).closest('.file_link');
		}
		setCurrentSelected(clicked);
	});

	$('.breadcrumb').on("click", "li", function(){
		var index = $(this).data('index');
		manager.folders = manager.folders.splice(0, index);
		getFiles(manager.folders);
	});

	$('.breadcrumb-container .toggle').click(function(){
		$('.flex #right').toggle();
		var toggle_text = $('.breadcrumb-container .toggle span').text();
		$('.breadcrumb-container .toggle span').text(toggle_text == "Close" ? "Open" : "Close");
		$('.breadcrumb-container .toggle .icon').toggleClass('fa-toggle-right').toggleClass('fa-toggle-left');
	});

	//********** Add Keypress Functionality **********//
	$(document).keydown(function(e) {
		var curSelected = $('#files li .selected').data('index');
		// left key
	    if( (e.which == 37 || e.which == 38) && parseInt(curSelected)) {
	    	newSelected = parseInt(curSelected)-1;
	    	setCurrentSelected( $('*[data-index="'+ newSelected + '"]') );
	    }
	    // right key
	    if( (e.which == 39 || e.which == 40) && parseInt(curSelected) < manager.files.items.length-1 ) {
	        newSelected = parseInt(curSelected)+1;
	    	setCurrentSelected( $('*[data-index="'+ newSelected + '"]') );
	    }
	    // enter key
	    if(e.which == 13) {
	    	if (!$('#new_folder_modal').is(':visible') && !$('#move_file_modal').is(':visible') && !$('#confirm_delete_modal').is(':visible') ) {
	    		manager.folders.push( $('#files li .selected').data('folder') );
				getFiles(manager.folders);
			}
			if($('#confirm_delete_modal').is(':visible')){
				$('#confirm_delete').trigger('click');
			}
	    }
	});
	//********** End Keypress Functionality **********//


	/********** TOOLBAR BUTTONS **********/
	$('#refresh').click(function(){
		getFiles(manager.folders);
	});

	$('#new_folder_modal').on('shown.bs.modal', function() {
		console.log('what what');
        $("#new_folder_name").focus();
    });

    $('#new_folder_name').keydown(function(e) {
    	if(e.which == 13) {
    		$('#new_folder_submit').trigger('click');
    	}
    });

	$('#new_folder_submit').click(function(){
		new_folder_path = manager.files.path + '/' + $('#new_folder_name').val();
		$.post('/admin/media/new_folder', { new_folder: new_folder_path }, function(data){
			if(data.success == true){
				toastr.success('successfully created ' + $('#new_folder_name').val(), "Sweet Success!");
				getFiles(manager.folders);
			} else {
				toastr.error(data.error, "Whoops!");
			}
			$('#new_folder_name').val('');
			$('#new_folder_modal').modal('hide');
		});
	});

	$('#delete').click(function(){
		if(manager.selected_file.type == 'folder'){
			$('.folder_warning').show();
		} else {
			$('.folder_warning').hide();
		}
		$('.confirm_delete_name').text(manager.selected_file.name);
		$('#confirm_delete_modal').modal('show');
	});

	$('#confirm_delete').click(function(){
		
		$.post('/admin/media/delete_file_folder', { file_folder: manager.selected_file.path }, function(data){
			if(data.success == true){
				toastr.success('successfully deleted ' + manager.selected_file.name, "Sweet Success!");
				getFiles(manager.folders);
				$('#confirm_delete_modal').modal('hide');
			} else {
				toastr.error(data.error, "Whoops!");
			}
		});
	});

	$('#move').click(function(){
		$('#move_file_modal').modal('show');
	});

	$('#move_folder_dropdown').keydown(function(e) {
		if(e.which == 13) {
    		$('#move_btn').trigger('click');
    	}
	});

	$('#move_btn').click(function(){
		source = manager.selected_file.path;
		destination = './content/uploads/' + $('#move_folder_dropdown').val() + '/' + manager.selected_file.name;
		$('#move_file_modal').modal('hide');
		$.post('/admin/media/move_file', { source: source, destination: destination }, function(data){
			if(data.success == true){
				toastr.success('Successfully moved file/folder', "Sweet Success!");
				getFiles(manager.folders);
			} else {
				toastr.error(data.error, "Whoops!");
			}
		});
	});

	// $('#upload').click(function(){
	// 	$('#upload_files_modal').modal('show');
	// });
	/********** END TOOLBAR BUTTONS **********/

	manager.$watch('files', function (newVal, oldVal) {
		setCurrentSelected( $('*[data-index="0"]') );
		$('#filemanager #content #files').hide();
		$('#filemanager #content #files').fadeIn('fast');
		$('#filemanager .loader').fadeOut(function(){
			
			$('#filemanager #content').fadeIn();	
		});

		if(newVal.items.length < 1){
			$('#no_files').show();
		} else {
			$('#no_files').hide();
		}
	});

	manager.$watch('directories', function (newVal, oldVal) {
		$("#move_folder_dropdown").select2('destroy');
		$("#move_folder_dropdown").select2();
	});

	manager.$watch('selected_file', function (newVal, oldVal) {
		if(typeof(newVal) == 'undefined'){
			$('.right_details').hide();
			$('.right_none_selected').show();
			$('#move').attr('disabled', true);
			$('#delete').attr('disabled', true);
		} else {
			$('.right_details').show();
			$('.right_none_selected').hide();
			$('#move').removeAttr("disabled");
			$('#delete').removeAttr("disabled");
		}
	});

	function getFiles(folders){
		if(folders != '/'){
			var folder_location = '/' + folders.join('/');
		} else {
			var folder_location = '/';
		}
		$.post('/admin/media/files', { folder:folder_location }, function(data) {
			manager.files = data;
			for(var i=0; i < manager.files.items.length; i++){
				if(typeof(manager.files.items[i].size) != undefined){
					manager.files.items[i].size = bytesToSize(manager.files.items[i].size);
				}
			}
		});

		// Add the latest files to the folder dropdown
		var all_folders = '';
		$.get('/admin/media/directories', function(data){
			manager.directories = data;
		});
		
	}

	function setCurrentSelected(cur){
		$('#files li .selected').removeClass('selected');
		$(cur).addClass('selected');
		manager.selected_file = manager.files.items[$(cur).data('index')];
	}

	function bytesToSize(bytes) {
		var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
		if (bytes == 0) return '0 Bytes';
		var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
		return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
	}


});
