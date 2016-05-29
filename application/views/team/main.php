<script>
$(function(){
	$(".nav-item-team").addClass("current");
})
</script>
<div id="content-wrap">
	<div class="row section-head">
		<div class="twelve columns">
			<h1>Colaboradores</h1>
			<p class="lead">Campo-Ciudad, es un proyecto colectivo en el que
				participan hombres y mujeres en una nueva etapa de
				comunicaci&oacute;n a trav&eacute;s del uso de las
				tecnolog&iacute;as.</p>
		</div>

	</div>
	<div class="row ">
		<div>
			<ul class="list-group">
				<?php foreach ($collaborators as $collab) : ?>
					<li class="list-group-item">
					<h4 class="list-group-item-heading"><?= $collab["name"] ?></h4>
					<p class="list-group-item-text">
					<dl class="dl-horizontal">
						<dt>Correo</dt>
						<dd><?= $collab['email'] ?></dd>
						<dt>Perfil</dt>
						<dd><?= $collab['profile'] ?></dd>
						<dt>Acerca de mí</dt>
						<dd><?= $collab['about'] ?></dd>
					</dl>
					</p>
				</li>	
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>

