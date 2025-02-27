<?php

require_once '../app/database.php';

$sql = "SELECT wines.id as wine_id, wines.name, wines.thumbnail, producers.id as producer_id, producers.domain
		FROM wines
		LEFT JOIN producers ON wines.id = producers.id";

$stmt = $db->prepare($sql);
$stmt->execute();
$wines = $stmt->fetchAll();

?>

<div class="catalogue-intro">
	<h1 class="title">Vin du monde</h1>
	<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quo in maxime ab porro vel incidunt delectus harum a? Et, molestiae. Consequuntur repellat adipisci necessitatibus qui a quidem mollitia omnis inventore?</p>
</div>

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

<div class="catalogue-view">
	<?php foreach ($wines as $wine) : ?>
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
</div>

<section class="catalogue-about">
	<div>
		<h2 class="title">Le point de vue du Baroudeur</h2>
		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet amet similique culpa alias velit nostrum aut ut fuga dolor expedita magnam explicabo ab suscipit, accusantium placeat vero harum consequatur quo.</p>
	</div>

	<figure>
		<img src="assets/images/47d97b01294c430c83622a4394711cd0.jpg" alt="">
	</figure>
</section>

<section class="catalogue-faq">
	<h3 class="title">FAQ</h3>
</section>
