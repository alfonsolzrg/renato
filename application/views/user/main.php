<script type="text/javascript">
/* Events 
------------------------------------------------------ */
$(document).on('unsynchronized', function(event){
	$('.auth_error').fadeOut('fast');
	$('#content-wrap').load('user #content-wrap .row');
});
</script>

<div id="content-wrap">
	<div class="row">
		<div class="eight columns">
			<h1>Perfil de Colaborador</h1>
			<div>
	<?php if ($this->facebook->isConnected()) : ?>
			<?php if (!$isColaborador) : ?>
			<div class="alert alert-warning" role="alert">Por el momento
					necesitas un token de acceso para registrarte como colaborador del
					colectivo.</div>
			<?php endif; ?>
			<p>
					Bienvenido <b><?= $name ?> </b>
				</p>
				<form action="<?= base_url ()?>user" method="POST">
					<input type="hidden" name="name" value="<?= $name ?>"> <input
						type="hidden" name="facebook_id" value="<?= $facebook_id ?>">
					<div
						class="form-group <?=  form_error('username')!=''?'has-error':''; ?>">
						<label class="control-label" for="username">Usuario</label> <input
							class="form-control" type="text" id="username" name="username"
							<?php if ($isColaborador) : echo "disabled='disabled'"; endif ?>
							value="<?= set_value('username',$username) ?>">
							<?php if ($isColaborador) : ?> 
								<input type="hidden"  name="username" 	value="<?= set_value('username',$username) ?>" /> 
							<?php endif ?>
					<?= form_error('username') ?>
				</div>
					<div
						class="form-group <?=  form_error('email')!=''?'has-error':''; ?>">
						<label for="email">Email</label> <input name="email" type="email"
							class="form-control" id="email"
							value="<?= set_value('email',$email) ?>">
    				<?= form_error('email') ?>
  				</div>
					<div
						class="form-group <?=  form_error('profile')!=''?'has-error':''; ?>">
						<label for="profile">Perfil</label> <input name="profile"
							placeholder="Describe tu rol o lo que haces en la organizacion."
							type="text" class="form-control" id="profile"
							value="<?= set_value('profile',$profile) ?>">
    				<?= form_error('profile') ?>
  				</div>
					<div
						class="form-group <?=  form_error('about')!=''?'has-error':''; ?>">
						<label for="about">Acerca de mi</label>
						<textarea name="about" rows="2" class="form-control"
							placeholder="Escribe un poco sobre ti."><?= set_value('about',$about) ?></textarea>
    				<?= form_error('about') ?>
  					</div>
  				<?php if (!$isColaborador) : ?>
  					<div
						class="form-group <?=  form_error('token')!=''?'has-error':''; ?>">
						<label for="token">Token</label> <input name="token"
							class="form-control" placeholder="Ingresa el token de registro">
    				<?= form_error('token') ?>
  					</div>
					<button type="submit" class="btn btn-default" name="operation" value="signin">Registrarse</button>
				<?php else: ?>
					<button type="submit" class="btn btn-default" name="operation" value="update">Actualizar</button>
				<?php endif; ?>
  				
  				
				</form>
		
	<?php else: ?>
		<div class="alert alert-danger auth_error" role="alert">Necesitas iniciar session
					como colaborador. Da click en el boton 'COLABORADOR'.
		</div>
	<?php endif; ?>
		</div>
		</div>
	</div>
</div>
