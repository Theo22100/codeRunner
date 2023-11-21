<?php 
try {
    $sql = $handler->prepare("SELECT sentence, quest_code, code_answer,explication,time,HTMLCSS FROM coderunner WHERE ID_Quest=:ID_Quest");
    $sql->bindParam(':ID_Quest', $ID_Quest);
    $sql->execute();
    $challengeData = $sql->fetch(PDO::FETCH_ASSOC);

    if ($challengeData) {
      $sentence = htmlspecialchars($challengeData['sentence']);
      $questCode = htmlspecialchars($challengeData['quest_code']);
      $correctAnswer = htmlspecialchars($challengeData['code_answer']);
      $explication = $challengeData['explication'];
      $time = $challengeData['time'];
      $htmlcss = $challengeData['HTMLCSS'];
    } else {
      echo "No challenge found for this ID.";
      exit;
    }
  } catch (PDOException $e) {
    echo 'Echec Connection BDD : ' . $e->getMessage();
  }
  ?>