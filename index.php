<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel="stylesheet" href="styles.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Эрудит!</title>
</head>

<body class="body">
	<form method="post" action="show_question.php">
		<main class = "container shadow p-3 mb-5 bg-light rounded position-absolute top-50 start-50 translate-middle w-50 p-3">
			<h1 class="display-4 lead text-center" >Эрудит!</h1>
			<div class="mb4 input-group">
				<label for="username" class="form-label"></label>
				<span class="input-group-text">
					<i class="bi bi-person-circle" style="font-size: 3rem; color: cornflowerblue;"></i>
				</span>
				<input type="text" class="form-control" placeholder="Имя пользователя" style="height: 90px"
				id="username" name="username" aria-describedby="basic-addon1" required>
			</div>
			<?php
				require("make_questions.php");
				$allQuestionsFirst = getList();
				echo '<input type="hidden" name="allQuestionsFirst" value="' . htmlspecialchars(json_encode($allQuestionsFirst)) . '">';
			?>
			<div class="mb-4-text-center lead text-center">
				<input type="submit" class="btn btn-secondary" value="Начать тест">
			</div>
		</main>
	</form>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>	