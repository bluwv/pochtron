document.addEventListener("DOMContentLoaded", (event) => {

	document.querySelectorAll('[data-action]').forEach(element => {
		element.addEventListener('click', (button) => {
			button.preventDefault();

			let action = button.target.dataset.action;

			document.querySelector(`[data-reaction="${ action }"]`).classList.toggle('active');
		});
	});

});
