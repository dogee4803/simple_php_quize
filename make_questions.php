<?php
// Func for getting questions from database
function getQuestions($conn) 
{
    $questions = [];
	
    $result = $conn->query("SELECT * FROM Questions ORDER BY RAND() LIMIT 5");
	
	while($question = $result->fetch_assoc()){
		$test = $question;
		$test['answers'] = getAnswers($conn, $question['id']);
		$questions[] = $test;
	}
    return $questions;
}

// Func for getting answers from database
function getAnswers($conn, $question_id) 
{
    $answers = [];

    // Getting correct answer
    $correctAnswerQuery = "SELECT * FROM Answers WHERE question_id = $question_id AND correct = 1 ORDER BY RAND() LIMIT 1";
    $resultCorrect = $conn->query($correctAnswerQuery);
    $correctAnswer = $resultCorrect->fetch_assoc();
    
    // Getting other questions
    $otherRandomAnswersQuery = "SELECT * FROM Answers WHERE question_id = $question_id AND id != {$correctAnswer['id']} ORDER BY RAND() LIMIT 3";
    $resultOtherRandom = $conn->query($otherRandomAnswersQuery);

    while ($row = $resultOtherRandom->fetch_assoc()) {
        $otherRandomAnswers[] = $row;
    }

    // Unite correct and uncorrect answers
    $answers = array_merge([$correctAnswer], $otherRandomAnswers);

    // Shuffle array
    shuffle($answers);
    
    return $answers;	
}

// Func for returning array with questions
function getList(){
	// Connecting to database
	$host = "localhost";
	$user = $pass = $name = "DB2023_dogee4803";
	$conn = new mysqli($host, $user, $pass, $name);
	if($conn->connect_error){
		die("Ошибка: " . $conn->connect_error);
	}
	
	// Return of Question array with all fields
	$allQuestions = getQuestions($conn);
	return $allQuestions;
}
?>