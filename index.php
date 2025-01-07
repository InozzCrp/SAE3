<?php
	require_once("constante.php");
	get_head();
?>
<body>
	<?php
		get_header();
	?>

	<main class="w-100 d-flex flex-column px-5">
		<section class="d-flex container gap-5 py-5 justify-content-center">
			<div class="text-center col d-flex flex-column justify-content-center v-100">
				<div class="col-12 mb-5">
					<h1>
						Système de Transport Gérico
					</h1>
					<h4>
						Votre partenaire de confiance pour le transport de marchandises
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

		<section class='py-5'>
			<div class="d-flex container gap-5 justify-content-center">
				<h2>Nos Services</h2>
			</div>
			<div class="d-flex container gap-5 justify-content-center">
				<div class="service-item">
					<h3>Transport Routier</h3>
					<p>Des camions modernes pour acheminer vos marchandises partout en Europe.</p>
				</div>
				<div class="service-item">
					<h3>Logistique et Entreposage</h3>
					<p>Des solutions complètes pour stocker et gérer vos produits efficacement.</p>
				</div>
				<div class="service-item">
					<h3>Transport International</h3>
					<p>Une expertise mondiale pour vos expéditions internationales.</p>
				</div>
			</div>
		</section>

		<section id='contact' class='py-5'>
			<div class="d-flex container gap-5 justify-content-center">
				<h2>Contactez-nous</h2>
			</div>
			<div class="d-flex container gap-5 justify-content-center">
				<div class="service-item">
					<h3>Email :</h3>
					<p>contact@gerico.fr</p>
				</div>
				<div class="service-item">
					<h3>Téléphone :</h3>
					<p>+33 1 23 45 67 89</p>
				</div>
				<div class="service-item">
					<h3>Adresse :</h3>
					<p>123 Rue du Transport, 75001 Paris, France</p>
				</div>
			</div>
		</section>
	</main>
</body>
