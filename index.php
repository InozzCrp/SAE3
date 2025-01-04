<?php
	require("constante.php");
	get_head();
?>
<body>
	<?php
		get_header();
	?>

	<main class="w-100 d-flex flex-column p-5">
		<section class="d-flex container gap-5 justify-content-center">
			<div class="text-center col d-flex flex-column justify-content-center v-100">
				<div class="col-12 mb-5">
					<h1>
						Système de transport Gérico
					</h1>
					<h4>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
					</h4>					
				</div>
				<div>
					<a class="btn btn-primary" href="login.php" role="button">Se connecter à l'espace employé</a>
				</div>
			</div>
			<div class="col-6 d-none d-xl-block">
				<img src="media/image/camions_illustration_1.jpg" width="100%"/>
			</div>
		</section>
	</main>
</body>
