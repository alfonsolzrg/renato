<script id="user-menu-template" type="text/x-handlebars-template">
{{#if isLogged }}
<li><img alt="User profile" src="{{user.picture}}" class="img-rounded" style="height:36px"
	 /></li>
<li>
	<div class="dropdown">
		<a data-toggle="dropdown" href="#" role="button" aria-expanded="true">
			{{user.name}} <span class="caret"></span>
		</a>
		<ul id="dropdown-user-menu" class="dropdown-menu" role="menu">
			<li><a href="/user" >Mi perfil</a></li>
			<li><a id="logout-button" href="#">Cerrar sesion</a></li>
		</ul>
	</div>
</li>
{{else}}
<li>
	<button class="nav-btn" id="colaborador-btn">colaborador</button>
</li>
{{/if }}	
</script>
<header id="top">
	<!-- Nice Logo-->
	<div class="row">
		<div class="header-content twelve columns">
			<h1 id="logo-text">
				<a href="<?php echo site_url('campo-ciudad')?>" title="">Campo
					Ciudad</a>
			</h1>
			<p id="intro">
				<?php echo utf8_encode('Programa radiofonico de participacion ciudadana');?>
			</p>
		</div>
	</div>
	<!-- navigation -->
	<nav id="nav-wrap">
		<div class="row">
			<ul id="nav" class="nav">
				<li class="nav-item-radio"><a href="<?php echo site_url()?>">Radio</a></li>
				<li class="nav-item-post"><a
					href="<?php echo site_url('post')?>">Publicaciones</a></li>
				<li class="nav-item-audio"><a href="<?php echo site_url('audio')?>">Audio</a></li>
				<li class="nav-item-team"><a
					href="<?php echo site_url('team')?>">Equipo</a></li>
				<li class="nav-item-about"><a
					href="<?php echo site_url('about')?>">Historia</a></li>
			</ul>
			<ul id="nav-right" class="nav-right">
			</ul>
		</div>
	</nav>
</header>