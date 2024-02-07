<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Эрудит!</title>
    <link rel="icon" href="images/question_icon.svg">
</head>

<body class="body">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	<main class="container shadow p-3 mb-5 bg-light rounded position-absolute top-50 start-50 translate-middle w-50 p-3">
		<?php
		
		// Func for choosing a page that gets data from this page
		function chooseAction($question_number) {
		// What page gets our form
		if ($question_number < 5) {
			$next_page = 'show_question.php?question_number=' . ($question_number+1);
		}
		else {
			$next_page = 'results.php';
		}
		return $next_page;
}

		// Func for choosing a text for btn
		function chooseButton($question_number) {
			// Questions listings
			if ($question_number < 5) {
				$next_btn = '<div class="mb-4-text-center lead text-center"><input type="submit" class="btn btn-secondary" value="Следующий вопрос"></div>';
			}
			else {
				$next_btn = '<div class="mb-4-text-center lead text-center"><input type="submit" class="btn btn-secondary" value="Закончить тестирование"></div>';
			}
			return $next_btn;
		}
		
		session_start();
		require("make_questions.php");
		
		// Getting question number from url
		if (isset($_GET['question_number'])){
			$question_number = $_GET['question_number'];
		}
		else{
			$question_number = 1;
		}
		
		
		// Functions that define what page will be open and what button we will get
		$action_string = chooseAction($question_number);
		$button_string = chooseButton($question_number);

		// Form for sending a list of questions, username and answers
		echo '<form method="post" action=' . $action_string . '>';
		
			// Получение вопроса и ответов по номеру вопроса
			if (isset($_POST['allQuestionsFirst'])) {
				$allQuestionsFirst = json_decode($_POST['allQuestionsFirst'], true);
				$question = $allQuestionsFirst[$question_number - 1];
				$allQuestionsSecond = $allQuestionsFirst;
				echo '<input type="hidden" name="allQuestionsSecond" value="' . htmlspecialchars(json_encode($allQuestionsSecond)) . '">';
			}
			else {
				$allQuestionsSecond = json_decode($_POST['allQuestionsSecond'], true);
				$question = $allQuestionsSecond[$question_number - 1];
				echo '<input type="hidden" name="allQuestionsSecond" value="' . htmlspecialchars(json_encode($allQuestionsSecond)) . '">';
			}
			$answers = $question['answers'];
		
			// hidden usernname
			$username = $_POST['username'];
			echo '<input type="hidden" name="username" value="' . $username . '">';
			
			// hidden user's answers
			for ($i=1; $i<6; $i++){
				if (isset($_POST['temp_answer' . $i])){
					$temp_answer = $_POST['temp_answer' . $i];
					echo '<input type="hidden" name="temp_answer' . $i . '" value="' . $temp_answer . '">';
				}
			}		
			// Printing question and forms for answers
			echo '<h1 class="display-4 lead text-center">' . $question['question'] . '</h1>';
			echo '<p class="display-6">Выберите ответ: </p>';
			foreach ($answers as $answer) {
				echo '<div class="form-check">';
					echo '<input class="form-check-input" type="radio" name="temp_answer' . $question_number . '" value="' . $answer['id'] . '" required>';
					echo '<label class="form-check-label" for="temp_answer' . $question_number . '">' . $answer['answer'] . '</label>';
				echo '</div>';
			};
			echo $button_string;
		echo '</form>';
		?>
	</main>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>