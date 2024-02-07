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
    <?php
	// Connecting to database
	$host = "localhost";
	$user = $pass = $name = "DB2023_dogee4803";
	$conn = new mysqli($host, $user, $pass, $name);
	if($conn->connect_error) {
		die("Ошибка: " . $conn->connect_error);
	}
    
	session_start();
	
	// Getting username
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	
	//Getting all questions with all fields
	$allQuestions = json_decode($_POST['allQuestionsSecond'], true);
	
	//Getting username's answers_id
	for ($i=1; $i<5; $i++) {
		if (isset($_POST['temp_answer' . $i])){
			$answers_id[$i-1] = mysqli_real_escape_string($conn, $_POST['temp_answer' . $i]);
		}
	}
	if (isset($_POST['temp_answer5'])){
		$answers_id[4] = mysqli_real_escape_string($conn, $_POST['temp_answer5']);
	}
	
	// Checking answers and calculate score.
	$score = 0;
	for ($i=0; $i<5; $i++) {
		$exact_user_answer = $answers_id[$i];
		$exact_question = $allQuestions[$i];
		$answers = $exact_question['answers'];
		foreach ($answers as $a){
			if (($a['id'] == $exact_user_answer) and ($a['correct'] == 1)){
				$score += 1;
			}
		}
	}
	$score = mysqli_real_escape_string($conn, $score);
	
    $marks = [
        0 => 'Дурак',
        1 => 'Кол',
		2 => 'Два',
        3 => 'Три',
		4 => 'Хорошо',
		5 => 'Отлично',
    ];
	
	$mark = $marks[$score];
	$mark = mysqli_real_escape_string($conn, $mark);

	// Inserting User data
	$check_last_user_id = "SELECT COUNT(*) as count FROM Users";
	$current_user_id = $conn->query($check_last_user_id)->fetch_assoc()['count'] + 1;
	$current_user_id = mysqli_real_escape_string($conn, $current_user_id);
	$insert_user_query = "INSERT INTO Users (id, username) VALUES ($current_user_id, '$username')";
	$conn->query($insert_user_query);
	
	// Inserting Results data
	$check_last_results_id = "SELECT COUNT(*) as count FROM Results";
	$current_results_id = $conn->query($check_last_results_id)->fetch_assoc()['count'] + 1;
	$insert_results_query = "INSERT INTO Results (id, score, mark, user_id) VALUES ('$current_results_id', $score, '$mark', $current_user_id)";
	$conn->query($insert_results_query);
	
	//Getting Results data
	$count_marks = [];
	for ($i = 0; $i < 6; $i++) {
		$result = $conn->query("SELECT COUNT(*) as count FROM Results WHERE score = $i");
		$row = $result->fetch_assoc();
		$count_marks[$i] = $row['count'];
	}
	
	$conn->close();
	
	function buildHist($marks, $count_marks) {
			echo '<canvas id="Hist" width="1200" height="400" ></canvas>';
			echo '<script src="https://cdn.jsdelivr.net/npm/echarts@latest/dist/echarts.min.js"></script>';
			echo '<script>';
				echo 'var chartDom = document.getElementById("Hist");';
				echo 'var myChart = echarts.init(chartDom);';
				echo 'var option;';
				echo 'option = {';
					echo 'xAxis: {';
						echo 'type: "category",';
						echo 'data: ' . json_encode($marks);
					echo '},';
					echo 'yAxis: {';
						echo 'type: "value"';
					echo '},';
					echo 'series: [';
						echo '{';
						echo 'data: ' . json_encode($count_marks) . ',';
						echo 'type: "bar",';
						echo 'showBackground: true,';
						echo 'backgroundStyle: {';
							echo 'color: "rgba(180, 180, 180, 0.2)"';
						echo '}';
						echo '}';
					echo ']';
				echo '};';
				echo 'option && myChart.setOption(option);';
			echo '</script>';
		}
		
	echo '<main class="container shadow p-3 mb-5 bg-light rounded text-center position-absolute top-50 start-50 translate-middle" >';
		echo '<h1 class="display-4 text-center">Результаты тестирования</h1>';
		echo '<div>'; 
			buildHist($marks, $count_marks);
		'</div>';
		echo '<p class="lead text-center">Ваш итоговый счет: ' . $score . '</p>';
		echo '<p class="lead text-center">Ваша оценка: ' . $mark . '</p>';
	echo '</main>';
	?>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>	