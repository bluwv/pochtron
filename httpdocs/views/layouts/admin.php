<?php

session_start();

if ( ! empty ($_SESSION) && $_SESSION['timeout'] < time() ) {
	session_destroy();
	header('Location: /admin/login');
	exit();
}

require_once '../app/database.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Catalogue</title>

	<link rel="stylesheet" href="https://pochtron.localhost/admin/assets/css/app.css">

	<?php if ( $body_class === 'wines/edit' ) : ?>
		<script src="https://cdn.tiny.cloud/1/bfdmyne27shq4eta4oj3hbgx8u7r59zgoeyxoyiuux4u8ca4/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
	<?php endif; ?>
</head>

<body class="admin <?php echo $body_class; ?>">

	<div id="app" class="site">
		<?php // include_once 'views/layouts/header.php'; ?>

		<main class="site-main <?php echo $body_class; ?>">

			<?php include $file; ?>

			<?php
			if ( $body_class != 'login' ) {
				include_once 'views/components/sidebar.php';
			}
			?>

		</main>

		<?php if ( in_array($body_class, ['list', 'edit']) ) : ?>
			<aside class="modals">
				<section class="modal" data-modal="delete">
					<p>Souhaitez-vous réellement supprimer “<span></span>” ?</p>
					<p>Cette action est irréversible.</p>

					<form action="/admin/wines/list" method="POST" novalidate>
						<input type="hidden" name="wine_id" value="">

						<button class="button-cancel button" type="button" data-cancel="modal">Annuler</button>
						<button class="button-delete button" type="submit" name="delete">Delete ?</button>
					</form>
				</section>
			</aside>
		<?php endif; ?>

		<?php if ( in_array($body_class, ['wines/list', 'wines/edit', 'grapes/list', 'grapes/edit']) ) : ?>
			<aside class="modals">
				<section class="modal" data-modal="delete">
					<p>Souhaitez-vous réellement supprimer “<span></span>” ?</p>
					<p>Cette action est irréversible.</p>

					<form action="" method="POST" novalidate>
						<input type="hidden" name="item_id" value="">

						<button class="button-cancel button" type="button" data-cancel="modal">Annuler</button>
						<button class="button-delete button" type="submit" name="delete">Delete ?</button>
					</form>
				</section>
			</aside>
		<?php endif; ?>

		<?php // include_once 'views/layouts/footer.php'; ?>
	</div>

	<?php if ( $body_class === 'wines/edit' ) : ?>
		<script>
		tinymce.init({
			selector: 'textarea',
			// plugins: [
			// // Core editing features
			// 'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
			// // Your account includes a free trial of TinyMCE premium features
			// // Try the most popular premium features until Apr 3, 2025:
			// 'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
			// ],
			// toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
			// tinycomments_mode: 'embedded',
			// tinycomments_author: 'Author name',
			// mergetags_list: [
			// { value: 'First.Name', title: 'First Name' },
			// { value: 'Email', title: 'Email' },
			// ],
			// ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
		});
		</script>
	<?php endif; ?>
	<script src="https://pochtron.localhost/admin/assets/js/app.js"></script>
</body>
</html>
