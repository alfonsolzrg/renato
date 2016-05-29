<script>
$(function(){
	$(".nav-item-audio").addClass("current");	
})
</script>

<div id="content-wrap">
<div class="row">
<div class="eight columns">
	<article class="entry">
	<header class="entry-header">
	<h2 class="entry-title">Audios</h2>
	<div class="entry-meta">
		<ul>
			<li>El siguiente material se encuentra bajo la licencia Creative Commons.
			</li>
		</ul>
	</div>
	</header>
	</article>
</div>
</div>

<div class="row">	
		<?php
		foreach($files as $f): ?>
		<div class="four columns" >
				<div class="dew-audio">
					<object type="application/x-shockwave-flash" data="<?= asset_url() ?>dewplayer/dewplayer-mini.swf" width="160" height="20" id="dewplayer" name="dewplayer">
						<param name="wmode" value="transparent" />
						<param name="movie" value="<?= asset_url() ?>/dewplayer/dewplayer-mini.swf" />
						<param name="flashvars" value="mp3=http://media.campo-ciudad.org/audio/<?=$f['mp3']?>&amp;showtime=1&bgcolor=FFFFFF" />
					</object>
					<div>
						<a href="http://media.campo-ciudad.org/audio/<?=$f['mp3']?>"> <?=$f['name']?> </a>
					</div>
					<div 
						class="fb-like" 
						data-href="http://media.campo-ciudad.org/audio/<?=$f['mp3']?>" 
						data-width="300" 
						data-layout="button_count" 
						data-show-faces="true"
						data-share="true" 
						data-send="false">
					</div>
					
				</div>
				
		</div>
		 <?php endforeach; ?>
	</div>
</div>
</div>