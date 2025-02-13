document.addEventListener("DOMContentLoaded", (event) => {

	// Mettre à jour dynamiquement le prix dans le button sur la page single product
	if (document.body.classList.contains('single')) {
		const price = document.querySelector('.price strong').innerText;

		document.querySelector('#qty').addEventListener('input', (input) => {
			document.querySelector('.form-row--button [type="submit"] span').innerHTML = price * input.target.value;
		});
	}

});
