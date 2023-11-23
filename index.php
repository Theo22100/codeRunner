<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>CodeRunner</title>
  <link rel="icon" type="image/x-icon" href="logo.png">
  <link rel="stylesheet" href="style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300;400&family=Press+Start+2P&family=Sora:wght@300&display=swap"
    rel="stylesheet">
</head>

<body>
  <!--  
  /////////////////////////////////////////////////////////////////////
  //                                                                 //
  //                                                                 //
  //                  IT'S NOT RIGHT TO CHEAT :(                     //
  //                                                                 //
  //                                                                 //
  /////////////////////////////////////////////////////////////////////
  -->
  <?php
  $ID_Quest = $_GET['id'];
  require 'connection.php';
  
  require 'data.php';
  ?>
  <div id="container">
      <img src="logo.png" alt="Logo CodeRunner"></img>
    <h2>The Challenge
      <?php echo $htmlcss; ?> :
    </h2>

    <div id="sentence">
      <?php echo $sentence; ?>
    </div>

    <button id="startButton" onclick="startChallenge()">Start the challenge</button>
    <div id="challengeForm" style="display: none;">
      <div id="timer" style="display: none;">
        Temps restant : <span id="timerValue"></span>
      </div>
      <form id="challenge">
        <label for="questCode">Code of the question :</label>
        <textarea id="questCode" name="questCode" spellcheck="false"><?php echo $questCode; ?></textarea>
        <div id="buttons">
          <button type="button" id="buttonReset" onclick="resetCode()">Reset</button>
          <input type="submit" id="buttonSubmit" value="Submit">
        </div>
      </form>
    </div>




    <div id="result" style="display: none;">
      <p id="resultText"></p>
      <p id="correctAnswer1"></p>
      <textarea id="correctAnswer2" readonly></textarea>
      <div id="explanation">
        </p>
      </div>
    </div>
  </div>

  <script>
    //Timer
    let timer;
    let timeLeft = <?php echo json_encode($time) ?>;
    //Start
    function startChallenge() {
      document.getElementById("startButton").style.display = "none";
      document.getElementById("challengeForm").style.display = "block";
      document.getElementById("timer").style.display = "block";

      timer = setInterval(function () {
        timeLeft--;
        document.getElementById("timerValue").textContent = timeLeft + "s";

        if (timeLeft <= 0) {
          clearInterval(timer);
          checkAnswer();
        }
      }, 1000);
    }


    // Reset Button
    function resetCode() {
      const questCodeContent = `<?php echo htmlspecialchars_decode($questCode, ENT_QUOTES); ?>`;
      document.getElementById("questCode").value = questCodeContent;
    }




    //Answer
    function checkAnswer() {
      const userAnswer = document.getElementById("questCode").value.toLowerCase().replace(/\s/g, '');
      const correctAnswer = <?php echo json_encode(strtolower($correctAnswer)); ?>.replace(/\s/g, '').replace(/&gt;/g, '>').replace(/&lt;/g, '<');
      console.log(correctAnswer);
      console.log(userAnswer);

      if (userAnswer === correctAnswer) {
        showResult(true);
      } else {
        showResult(false);
      }
    }
    //Rows counter
    function countLines(text) {
      var lines = text.split(/\r\n|\r|\n/);
      lines = lines.filter(function (line) { //Filtre
        return line.trim() !== '';
      });
      return lines.length + 1;
    }
    document.getElementById("questCode").rows = countLines(<?php echo json_encode($questCode); ?>);
    document.getElementById("correctAnswer2").rows = countLines(<?php echo json_encode($correctAnswer); ?>);



    //Result
    function showResult(isCorrect) {
      clearInterval(timer);

      const resultDiv = document.getElementById("result");
      const resultText = document.getElementById("resultText");
      const correctAnswerElem1 = document.getElementById("correctAnswer1");
      const correctAnswerElem2 = document.getElementById("correctAnswer2");
      const explanationElem = document.getElementById("explanation");

      resultDiv.style.display = "block";

      if (isCorrect) {
        resultText.innerHTML = "Congratulations! The answer is <span class='correct'>CORRECT</span>.";
      } else {
        resultText.innerHTML = "Sorry, the answer is <span class='incorrect'>INCORRECT</span>.";
      }
      correctAnswerElem1.textContent = "The answer is :";

      correctAnswerElem2.innerHTML = `<?php echo $correctAnswer; ?>`;



      explanationElem.innerHTML = "<div><span class='underline'>Explanation :</span>  <?php echo $explication; ?></div>";


      document.getElementById("challengeForm").style.display = "none";
      document.getElementById("timer").style.display = "none";
    }

    document.getElementById("challenge").addEventListener("submit", function (event) {
      event.preventDefault();
      checkAnswer();
    });
  </script>
</body>

</html>
