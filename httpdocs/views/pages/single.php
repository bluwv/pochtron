<?php

require_once '../app/database.php';

$sql = "SELECT wines.id as wine_id, wines.name, wines.price, wines.description, wines.year, wines.format, wines.thumbnail, producers.id as producer_id, producers.domain
		FROM wines
		LEFT JOIN producers ON wines.id = producers.id
		WHERE wines.id = :wine_id";

$stmt = $db->prepare($sql);
$stmt->execute([':wine_id' => $args['wine_id']]);
$wine = $stmt->fetch();

$sql = "SELECT wines.id as wine_id, wines.name, wines.price, wines.description, wines.year, wines.format, wines.thumbnail, producers.id as producer_id, producers.domain
		FROM wines
		LEFT JOIN producers ON wines.id = producers.id
		WHERE wines.id <> :wine_id
		ORDER BY RAND()
		LIMIT 4";

$stmt = $db->prepare($sql);
$stmt->execute([':wine_id' => $args['wine_id']]);
$related_wines = $stmt->fetchAll();

?>

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
		<img src="assets/images/<?php echo $wine->thumbnail; ?>" alt="">
	</div>

	<div>
		<h1 class="title"><?php echo $wine->name; ?></h1>
		<p class="domain"><?php echo $wine->domain ?></p>
		<p class="price"><strong><?php echo $wine->price ?></strong> € <span>L’unité</span></p>
		<p><?php echo $wine->description; ?></p>

		<form action="" method="POST" novalidate>
			<div class="form-row">
				<label for="qty">Quantité</label>
				<input id="qty" type="number" name="qty" value="1" min="1" max="6">
			</div>

			<div class="form-row">
				<label for="year">Millésime</label>
				<select id="year" name="year">
					<option value="<?php echo $wine->year; ?>"><?php echo $wine->year; ?></option>
				</select>
			</div>

			<div class="form-row">
				<label for="format">Format</label>
				<select id="format" name="format">
					<option value="<?php echo $wine->format; ?>"><?php echo $wine->format; ?> cl</option>
				</select>
			</div>

			<div class="form-row form-row--button">
				<button type="submit">Ajouter au panier — <span><?php echo $wine->price; ?></span>€</button>
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

	<?php foreach ($related_wines as $wine) : ?>
		<article class="card-product card">
			<a href="/wines/<?php echo $wine->wine_id; ?>/<?php echo urlify($wine->name); ?>">
				<img src="assets/images/<?php echo $wine->thumbnail; ?>" alt="">

				<div>
					<h3 class="title"><?php echo $wine->name; ?></h3>
					<p><?php echo $wine->domain; ?></p>
				</div>
			</a>
		</article>
	<?php endforeach; ?>
</section>
