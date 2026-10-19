@extends('layouts.app')

@section('content')
<div class="login-page">
	<section class="login-intro" aria-label="Acceso al portal SENA">
		<p class="eyebrow">Portal de gestión</p>
		<h1>Tu talento<br><em>mueve</em> el futuro.</h1>
		<p>Ingresa al espacio donde la formación, las personas y las oportunidades se encuentran.</p>
		<div class="login-stamp">
			<img src="{{ asset('assets/png-clipart-logo-sena-la-granja-leaf-text.png') }}" alt="Logo SENA">
			<span>Servicio Nacional<br>de Aprendizaje</span>
		</div>
	</section>

	<section class="login-panel" aria-labelledby="login-title">
		<a class="login-back" href="{{ route('home') }}"><i class="fas fa-arrow-left" aria-hidden="true"></i> Volver al inicio</a>

		<div class="login-panel__heading">
			<span class="profile-avatar"><i class="fas fa-user" aria-hidden="true"></i></span>
			<p class="eyebrow">Bienvenido de nuevo</p>
			<h2 id="login-title">Iniciar sesión</h2>
			<p>Accede a tu cuenta para continuar en el portal.</p>
		</div>

		<form class="login-form" action="{{ route('login') }}" method="POST">
			@csrf
			@if ($errors->any())
				<div role="alert">
					{{ $errors->first() }}
				</div>
			@endif
			<label for="email">Correo electrónico</label>
			<input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="nombre@ejemplo.com" autocomplete="email" required>

			<label for="password">Contraseña</label>
			<div class="password-field">
				<input type="password" name="password" id="password" placeholder="Ingresa tu contraseña" autocomplete="current-password" required>
				<button type="button" aria-label="Mostrar contraseña"><i class="fas fa-eye" aria-hidden="true"></i></button>
			</div>

			<div class="login-options">
				<label><input type="checkbox"> Recordarme</label>
				<a href="#">¿Olvidaste tu contraseña?</a>
			</div>

			<button class="sena-button sena-button--login" type="submit">Iniciar sesión <i class="fas fa-arrow-right" aria-hidden="true"></i></button>
		</form>

		<div class="login-divider"><span>o continúa con</span></div>
		<button class="login-google" type="button"><i class="fab fa-google" aria-hidden="true"></i> Continuar con Google</button>

		<p class="login-register">¿Aún no tienes una cuenta? <a href="#">Crear cuenta</a></p>
		<p class="login-note"><i class="fas fa-info-circle" aria-hidden="true"></i> Usa tus credenciales para acceder al portal.</p>
	</section>
</div>
@endsection
