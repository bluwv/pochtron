<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Catalogue</title>

	<link rel="stylesheet" href="assets/css/app.css">
</head>

<body class="single">

	<div class="site">
		<?php include_once 'views/layouts/header.php'; ?>

		<main class="site-main">
			<aside class="catalogue-filters">
				<form action="" method="GET" novalidate>
					<fieldset>
						<legend class="title">Couleur</legend>

						<div class="form-row">
							<input id="Orange" type="checkbox" name="color" value="Orange">
							<label for="Orange">Orange</label>
						</div>
						<div class="form-row">
							<input id="Blanc" type="checkbox" name="color" value="Blanc">
							<label for="Blanc">Blanc</label>
						</div>
						<div class="form-row">
							<input id="Rouge" type="checkbox" name="color" value="Rouge">
							<label for="Rouge">Rouge</label>
						</div>
						<div class="form-row">
							<input id="Rosé" type="checkbox" name="color" value="Rosé">
							<label for="Rosé">Rosé</label>
						</div>
					</fieldset>

					<fieldset>
						<legend class="title">Format</legend>

						<div class="form-row">
							<input id="37" type="checkbox" name="size" value="37">
							<label for="37">37,5 cl</label>
						</div>
						<div class="form-row">
							<input id="75" type="checkbox" name="size" value="75">
							<label for="75">75 cl</label>
						</div>
						<div class="form-row">
							<input id="150" type="checkbox" name="size" value="150">
							<label for="150">150 cl</label>
						</div>
					</fieldset>
				</form>
			</aside>

			<div class="single-product">
				<div>
					<img src="assets/images/bergerie_2020_75cl_rg_pic_saint_loup-999999999x1140.png" alt="">
				</div>

				<div>
					<h1 class="title">Foravia Langhe Nebbiolo</h1>
					<p class="domain">Domaine de l’Hortus</p>
					<p class="price">28,00 € <span>L’unité</span></p>
					<p>Un Nebbiolo travaillé dans les codes de l'ère moderne : frais, élégant et aérien.</p>

					<form action="" method="POST" novalidate>
						<div class="form-row">
							<label for="qty">Quantité</label>
							<input id="qty" type="number" name="qty" placeholder="">
						</div>

						<div class="form-row">
							<label for="year">Millésime</label>
							<select id="year" name="year">
								<option value="2022">2022</option>
							</select>
						</div>

						<div class="form-row">
							<label for="format">Format</label>
							<select id="format" name="format">
								<option value="75">75 cl</option>
							</select>
						</div>

						<div class="form-row form-row--button">
							<button type="submit">Ajouter au panier — 28,00€</button>
						</div>
					</form>
				</div>
			</div>

			<section class="single-description">
				<div>
					<h2 class="title">Un grand vin blanc, profond, complexe et long.</h2>
					<p>Au fond de notre vallon coule une « rivière »… ou plutôt ne coule pas.</p>
					<p>Il s’agit en réalité d’un oued qui peut charrier à l’automne de nombreuses alluvions. Au creux de ses méandres, de petites parcelles ont été aménagées au fil des siècles. C’est le domaine des chênes blancs majestueux sur les bordures.</p>
					<p>Les cépages blancs y trouvent leur meilleure expression : le Chardonnay sur les parcelles les plus froides, et le Viognier, la Roussanne, le Sauvignon Gris et le Petit Manseng, selon les nuances de sol et du climat de chaque parcelle.</p>

					<h3>Accords Culinaires</h3>
					<p>A déguster sur des viandes rouges en sauce, des gibiers comme du cerf ou du chevreuil, un foie de veau aux framboises, un boudin de porc noir de Bigorre, ou sur un plateau de fromages puissants.</p>
					<p>Après des années de vieillissement, ce vin pourra s'accorder avec le chocolat noir et les tartes aux fruits secs.</p>
				</div>
			</section>

			<section class="single-related-products">
				<h3 class="title">Nos autres vins</h3>

				<?php for ($i=0; $i < 4; $i++) : ?>
					<article class="card-product card">
						<a href="single.php">
							<img src="assets/images/bergerie_2020_75cl_rg_pic_saint_loup-999999999x1140.png" alt="">

							<div>
								<h3 class="title">Foravia Langhe Nebbiolo</h3>
								<p>Domaine de l’Hortus</p>
							</div>
						</a>
					</article>
				<?php endfor; ?>
			</section>
		</main>

		<?php include_once 'views/layouts/footer.php'; ?>
	</div>

</body>
</html>
