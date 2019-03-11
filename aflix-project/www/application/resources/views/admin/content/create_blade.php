@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ '/application/assets/js/tagsinput/jquery.tagsinput.css' }}" />
@stop
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

@section('content')

	<div id="admin-container">
		<!-- This is where -->

		<div class="admin-section-title">
			
				<h3>About Us </h3>
				
			
				
		</div>
		<div class="clear"></div>



		<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

			

			

			
			
<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
					<div class="panel-title">Video Details, Links, and Info</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
				<div class="panel-body" style="display: block; padding:0px;">
					<textarea class="form-control" name="details" id="details"></textarea>
				</div>
			</div>

			

			

			
			
			

			<div class="clear"></div>


			


			

			

			<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
			<input type="submit" value="Update " class="btn btn-success pull-right" />

		</form>

		<div class="clear"></div>
		<!-- This is where now -->
	</div>




@section('javascript')


	<script type="text/javascript" src="{{ '/application/assets/admin/js/tinymce/tinymce.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/application/assets/js/tagsinput/jquery.tagsinput.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/application/assets/js/jquery.mask.min.js' }}"></script>

	<script type="text/javascript">

        $ = jQuery;

        $(document).ready(function(){

            $('#duration').mask('00:00:00');
            $('#tags').tagsInput();

            $('#type').change(function(){
                if($(this).val() == 'file'){
                    $('.new-video-file').show();
                    $('.new-video-embed').hide();
                } else {
                    $('.new-video-file').hide();
                    $('.new-video-embed').show();
                }
            });

            tinymce.init({
                relative_urls: false,
                selector: '#details',
                toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor | code",
                plugins: [
                    "advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen",
                    "save table contextmenu directionality emoticons template paste textcolor code"
                ],
                menubar:false,
            });

        });



	</script>

@stop

@stop
