<!DOCTYPE html>
<html>
<head>
	<title>TO-DO</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style>
		.w-4 {
			width: 400px!important;
		}
		.task {
			display: flex;
		}
		.actions {
			margin-left: auto;
			display: flex;
			align-items: center;
		}
		.finish {
			text-decoration: line-through;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-12 text-center mt-3 mb-3">
				<h1 class="text-primary">Welcome TO-DO</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<form action="index.php" method="POST" class="form-inline justify-content-center">
					<div class="form-group">
						<label for="task" class="col-form-label mr-3">Add task</label>
						<div class="col-8">
							<input type="text" name="task" placeholder="ex. work!!" class="form-control w-4">
						</div>
					</div>
					<button class="btn btn-success">Save</button>
				</form>
			</div>
		</div>
		<div class="row mt-3 justify-content-center">
			<div class="col-md-6">
				<ul class="list-group">
				</ul>
			</div>
		</div>
	</div>
	<script>
	</script>
</body>
</html>