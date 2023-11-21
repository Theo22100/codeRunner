<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Challenge</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz@1,6..96&family=Fira+Code:wght@300;400&display=swap" rel="stylesheet">
</head>

<body>
  <?php
  require 'connection.php';
  $ID_Quest = $_GET['id'];
  require 'data.php';
  ?>

  <h1>The Challenge <?php echo $htmlcss; ?> :</h1>
  
  <div id="sentence"><?php echo $sentence; ?></div>

  <button id="startButton" onclick="startChallenge()">Start the challenge</button>
  <div id="challengeForm" style="display: none;">
    <form id="challenge">
      <label for="questCode">Code of the question :</label>
      <textarea id="questCode" name="questCode" rows="20"><?php echo $questCode; ?></textarea>
      <div id="buttons">
        <button type="button" id="buttonReset" onclick="resetCode()">Reset</button>
        <input type="submit" id="buttonSubmit" value="Submit">
      </div>
    </form>
  </div>

  <div id="timer" style="display: none;">
    Temps restant : <span id="timerValue"></span>
  </div>

  <div id="result" style="display: none;">
    <p id="resultText"></p>
    <p id="correctAnswer1"></p>
    <textarea id="correctAnswer2" rows="20" readonly></textarea>
    <div id="explanation"></p>
  </div>

  <script>
    let timer;
    let timeLeft = <?php echo json_encode($time) ?>;


    function startChallenge() {
      document.getElementById("startButton").style.display = "none";
      document.getElementById("challengeForm").style.display = "block";
      document.getElementById("timer").style.display = "block";

      timer = setInterval(function() {
        //timeLeft--;
        document.getElementById("timerValue").textContent = timeLeft + "s";

        if (timeLeft <= 0) {
          clearInterval(timer);
          checkAnswer();
        }
      }, 1000);
    }

    function resetCode() {
      const originalQuestCode = <?php echo json_encode($questCode); ?>; 
      document.getElementById("questCode").value = originalQuestCode;
    }

    function checkAnswer() {
      const userAnswer = document.getElementById("questCode").value.toLowerCase().replace(/\s/g, '');
      const correctAnswer = <?php echo json_encode(strtolower($correctAnswer));?>.replace(/\s/g, ''); 

      if (userAnswer === correctAnswer) {
        showResult(true);
      } else {
        showResult(false);
      }
    }

    function showResult(isCorrect) {
      clearInterval(timer);

      const resultDiv = document.getElementById("result");
      const resultText = document.getElementById("resultText");
      const correctAnswerElem1 = document.getElementById("correctAnswer1");
      const correctAnswerElem2 = document.getElementById("correctAnswer2");
      const explanationElem = document.getElementById("explanation");

      resultDiv.style.display = "block";

      if (isCorrect) {
        resultText.textContent = "Congratulations! You have found the correct answer";
      } else {
        resultText.textContent = "Sorry, the answer is incorrect.";
      }
      correctAnswerElem1.textContent = "The answer is :";
      correctAnswerElem2.textContent = <?php echo json_encode($correctAnswer); ?>;
      explanationElem.textContent = "Explanation : <?php echo $explication; ?>"; 

      document.getElementById("challengeForm").style.display = "none";
      document.getElementById("timer").style.display = "none";
    }

    document.getElementById("challenge").addEventListener("submit", function(event) {
      event.preventDefault();
      checkAnswer();
    });
  </script>
</body>

</html>
