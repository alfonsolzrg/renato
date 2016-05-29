<script>
$(function(){
	$(".nav-item-radio").addClass("current");	
})
</script>

<div id="content-wrap">
	<div class="row section-head">
		<div id="main" class="eight columns">
			<p class="lead add-bottom">
					<?php $this->view('home/jplayer'); ?>
			<div class="fb-like"
				data-href="<?php  echo base_url().uri_string() ?>"
				data-layout="standard" data-action="like" data-show-faces="false"
				data-share="true"></div>
			</p>
			<div class="fb-comments"
			data-href="<?php  echo base_url().uri_string() ?>" data-numposts="10"
			data-colorscheme="light"></div>
		</div>
		<div id="sidebar" class="four columns">
			<div class="fb-like-box"
				data-href="https://www.facebook.com/campociudadorg"
				data-colorscheme="light" data-show-faces="false" data-header="false"
				data-stream="true" data-show-border="false"></div>
		</div>
	</div>
	<div class="row">
		
	</div>
</div>
