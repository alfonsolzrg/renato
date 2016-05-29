<script>
$(function(){
	$(".nav-item-post").addClass("current");
	/* Carga de mas post 
	   ------------------------------------------------------ */
	$("#more-posts").click(function(ev){
		var next = $(this).data('next');
		$.get(next,function(response){
			if(response.data.length == 0){
				$("#more-posts").attr('disabled','disabled');
				return;	
			}
			var last = $(".post").last();
			$.each(response.data, function(key, value){  
				console.log(value);
				var id = value.id.split('_')[1];
				last.after("<div  id='cc"+id+"' class='row add-bottom post'><div class='fb-post' data-href='https://www.facebook.com/campociudadorg/posts/"+id+"' data-width='500' ></div></div>");
				last = $(".post").last();	
				FB.XFBML.parse(document.getElementById("cc"+id));
			});
			$("#more-posts").data('next', response.paging.next);
			console.log(response);
		});	
	});
})
</script>
<div id="content-wrap">
		<?php foreach($ids as $id):?>
		<div class="row add-bottom post">
			<div class="fb-post " data-href="https://www.facebook.com/campociudadorg/posts/<?= $id ?>" data-width="500" ></div>
		</div>
		<?php endforeach;?>
		<div class="row">
			<?php if($next != 'no_more_posts'): ?>
				<button id="more-posts" type="button" class="btn btn-primary" data-next="<?= $next?>">Cargar mas posts.</button>
			<?php endif ?>
		</div>
</div>
