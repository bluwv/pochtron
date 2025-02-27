document.addEventListener("DOMContentLoaded", (event) => {

	document.querySelectorAll('[data-action]').forEach(element => {
		element.addEventListener('click', (button) => {
			button.preventDefault();

			let action = button.target.dataset.action;

			document.querySelector(`[data-reaction="${ action }"]`).classList.toggle('active');
		});
	});

	// Toggle state sidebar admin

	if ( localStorage.getItem("sidebar") &&  localStorage.getItem("sidebar") == 'collapse' ) {
		document.body.classList.add('menu-collapse');
	}

	document.querySelector('[data-id="collapse-menu"]').addEventListener('click', (button) => {
		button.preventDefault();

		document.body.classList.toggle('menu-collapse');

		// Save the state of the sidebar
		if ( document.body.classList.contains('menu-collapse') ) {
			localStorage.setItem("sidebar", "collapse");
		} else {
			localStorage.setItem("sidebar", "expand");
		}
	});

	// MODAL
	let wineID;
	document.querySelectorAll('[data-show="delete"]').forEach(modal => {
		modal.addEventListener('click', (button) => {
			button.preventDefault();

			wineID = button.currentTarget.closest('[data-wineid]').dataset.wineid;
			document.querySelector('[data-modal="delete"] [name="wine_id"]').value = wineID;

			wineName = button.currentTarget.closest('[data-wineid]').dataset.wineName;
			document.querySelector('[data-modal="delete"] p > span').innerText = wineName;

			document.querySelector('[data-modal="delete"]').parentElement.classList.add('active');

		});
	});

	document.querySelectorAll('[data-cancel="modal"]').forEach(modal => {
		modal.addEventListener('click', (button) => {
			button.preventDefault();

			document.querySelector('[data-modal="delete"]').parentElement.classList.remove('active');

		});
	});

	// TODO: do next weeks
	// document.addEventListener('click', (event) => {
	// 	if (document.querySelector('.modals').classList.contains('active')) {
	// 		const isClickInside = document.querySelector('.modal').contains(event.target)

	// 		if (!isClickInside) {
	// 			console.log('click outside');

	// 			// The click was OUTSIDE the specifiedElement, do something
	// 		} else {
	// 			console.log('click inside');

	// 		}
	// 	}
	// });

	/**
	 * Remove modal on Escape key pressed
	 */
	document.addEventListener('keydown', function(e) {
		if ( e.key === 'Escape' ) {
			document.querySelector('[data-modal="delete"]').parentElement.classList.remove('active');
		}
	});


});
