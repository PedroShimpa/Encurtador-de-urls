<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
	<title>Encurtador de URL</title>
</head>

<body>
	<div class="container m-3">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h2>Encurtador de URL</h2>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-6">
								<input class="form-control" id="url" placeholder="Digite aqui a url que deseja encurtar, exemplo: http://google.com.br">
							</div>
							<div class="col-12" id="append-info">
							</div>
							<div class="col-12">

								<button type="button" class="btn btn-primary mt-2" id="encurtar">ENCURTAR</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).on('click', '#encurtar', function() {
			url = $('#url').val();
			$.ajax({
				url: '/',
				data: JSON.stringify({
					url: url
				}),
				method: 'POST',
				contentType: 'application/json',
			}).done(function(response) {
				console.log(response, 'sucesso')
				html = '<h3 class="text-success font-weight-bold"> URL gerada com sucesso: <a>' + response.url + '</a></h3>'
				$('#append-info').html(html)

			}).fail(function(response) {
				html = '<h3 class="text-danger font-weight-bold">' + response.responseJSON.erro + '</h3>'
				$('#append-info').html(html)
			})

		})
	</script>
</body>

</html>