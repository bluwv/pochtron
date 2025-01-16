{/* <form id="jeeuw" action="" novalidate>
					<input type="text" name="firstname" required>
					<input type="email" name="email" required>
					<button type="submit">send</button>
				</form>

				<script>
					let errors;
					const form = document.querySelector('#jeeuw');
					const fields = document.querySelector('#jeeuw').elements;

					form.addEventListener('submit', (event) => {
						errors = [];
						event.preventDefault();

						for (let index = 0; index < fields.length; index++) {
							if (fields[index].value == '' && fields[index].required) {
								errors.push(fields[index].name)
							}
						}

						if ( errors.length > 0 ) {
							console.log(`Champs manquants !`);
						} else {
							console.log(`Succès`);
						}
					});
				</script> */}
