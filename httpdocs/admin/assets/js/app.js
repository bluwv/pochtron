document.addEventListener("DOMContentLoaded", (event) => {

	document.querySelectorAll('[data-action]').forEach(element => {
		element.addEventListener('click', (button) => {
			button.preventDefault();

			let action = button.target.dataset.action;

			document.querySelector(`[data-reaction="${ action }"]`).classList.toggle('active');
		});
	});

	document.querySelector('[data-id="collapse-menu"]').addEventListener('click', (button) => {
		button.preventDefault();

		document.body.classList.toggle('menu-collapse');
	});

	// MODAL

	document.querySelectorAll('[data-show="delete"]').forEach(modal => {
		modal.addEventListener('click', (button) => {
			button.preventDefault();

			document.querySelector('[data-modal="delete"]').parentElement.classList.add('active');

		});
	});

	document.querySelectorAll('[data-cancel="modal"]').forEach(modal => {
		modal.addEventListener('click', (button) => {
			button.preventDefault();

			document.querySelector('[data-modal="delete"]').parentElement.classList.remove('active');

		});
	});


});
