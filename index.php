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
		<?php  
			if(isset($_POST['task'])) {
				if(empty($_POST['task'])) {
					showError('The task cannot be empty');
				} else  {
					try{
						saveTask($_POST['task']);
					} catch(PDOException $e) {
						showError('An error occurred while trying to save the task');
					}					
				}
			} else if(isset($_GET['finish'])){
				finishTask($_GET['finish']);
			} else if(isset($_GET['delete'])){
				deleteTask($_GET['delete']);
			}

			function connectDB() 
			{
				$dsn = 'mysql:host=localhost;dbname=todo';
				$username = 'homestead';
				$password = 'secret';
				return new PDO($dsn, $username, $password);
			}

			function saveTask ($task) 
			{
				$dbh = connectDB();
				$query = 'INSERT INTO task(name) VALUES (:name)';
				$stm = $dbh->prepare($query);
				$stm->bindParam(':name', $task);
				$stm->execute();
				showSuccess('Task added correctly');
			}

			function getTask() 
			{
				$dbh = connectDB();
				$query = "SELECT * FROM task order by create_at desc";
				$stm = $dbh->prepare($query);
				$stm->setFetchMode(PDO::FETCH_ASSOC);
				$task = '';
				$stm->execute();
				while($row=$stm->fetch()) {
					$finish = $row['finish'] == 1 ? 'finish' : '';
					/*$task .="<li class='list-group-item task form-check'><span class='".$finish."'>".$row['name']."</span>
					<div class='actions'>
						<a href='index.php?finish=".$row['id']."' class='btn btn-primary btn-sm'>Finish</a>
						<a href='index.php?delete=".$row['id']."' class='btn btn-danger btn-sm'>Delete</a>
					</div></li>";*/
					$task .= <<<EOT
					<li class="list-group-item task form-check"><span class="{$finish}"">{$row['name']}</span>
					<div class="actions">
						<a href="index.php?finish={$row['id']}" class="btn btn-primary btn-sm">Finish</a>
						<a href="index.php?delete={$row['id']}" class="btn btn-danger btn-sm">Delete</a>
					</div></li>
EOT;
				}
				return $task;
			}

			function finishTask($id) 
			{
				$dbh = connectDB();
				$query = 'SELECT * FROM task WHERE id=:id';
				$stm = $dbh->prepare($query);
				$stm->bindParam(':id', $id);
				$stm->execute();
				if($stm->rowCount() === 1) {
					$row = $stm->fetch(PDO::FETCH_ASSOC);
					$isFinish = $row['finish'] ? 0 : 1;
					
					$query = 'UPDATE task SET finish=:finish WHERE id=:id';
					$stm = $dbh->prepare($query);
					$stm->bindParam(':finish', $isFinish);
					$stm->bindParam(':id', $id);
					$stm->execute();
				}
			}

			function deleteTask($id)
			{
				$dbh = connectDB();
				$query = "DELETE FROM task WHERE id=:id";
				$stm = $dbh->prepare($query);
				$stm->bindParam(':id', $id);
				$stm->execute();
				$result = $stm->rowCount();
				if($result === 1) {
					showSuccess('Task deleted');
				} else {
					showError('An error occurred while trying to delete the task');
				}
			}

			function showError($msj) 
			{
				echo "<div class=\"alert alert-danger mt-3\" role=\"alert\">$msj</div>";
			}

			function showSuccess($msj) 
			{
				echo "<div class=\"alert alert-success mt-3\" role=\"alert\">$msj</div>";
			}
		?>
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
					<?php echo getTask();?>
				</ul>
			</div>
		</div>
	</div>
	<script>
	</script>
</body>
</html>