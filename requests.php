<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Activités de Vacances</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="icon" type="image/png" href="favicon.png" sizes="512x512">
  <link rel="apple-touch-icon" type="image/png" href="favicon.png" sizes="512x512">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    function show_comment_input(tag) {
      $(tag).next().show();
      $(tag).attr("onClick", "hide_comment_input(this)");
    }
    function hide_comment_input(tag) {
      $(tag).next().hide();
      $(tag).attr("onClick", "show_comment_input(this)");
    }
  </script>
</head>
<body>
  <p id="accueil"><a href="index.html">Revenir à l'Accueil</a></p>
<?php
  // Argument page nécessaire
  if (!isset($_REQUEST["page"])) {
    echo "<h1>Désolé veuillez spécifier l'argument page dans l'URL</h1>";
  }
  else {
    
    // Récupération du fichier JSON
    $file = "./".$_REQUEST["page"].".json";
    $json = file_get_contents($file);
    
    // Fichier JSON non accessible
    if ($json === false) {
      echo "<h1>Désolé cette page est introuvable...</h1>";
    }
    
    // Génération de la page HTML à partir du JSON
    else {
      
      $page = json_decode($json, true);
      
      // Enregistrement éventuel de commentaire
      if (isset($_REQUEST["activity"]) 
        && isset($_REQUEST["pseudo"]) 
        && $_REQUEST["pseudo"] !== "Votre Pseudo" && $_REQUEST["pseudo"] !== ""
        && isset($_REQUEST["comment"]) 
        && $_REQUEST["comment"] !== "Entrez un commentaire..."
        && $_REQUEST["comment"] !== "") {
        for ($i = 0; $i < count($page); $i++) {
          if (isset($page[$i]["ul"])) {
            for ($j = 0; $j < count($page[$i]["ul"]); $j++) {
              if ($page[$i]["ul"][$j]["activity"] === $_REQUEST["activity"]) {
                $new_comment = array("pseudo" => htmlspecialchars(trim($_REQUEST["pseudo"])),
                   "comment" => htmlspecialchars(trim($_REQUEST["comment"])));
                if (!in_array($new_comment, $page[$i]["ul"][$j]["comments"])) {
                  array_push($page[$i]["ul"][$j]["comments"], $new_comment);
                } break;
              }
            }
          }
        }
        file_put_contents($file, json_encode($page, JSON_PRETTY_PRINT));
      }
      
      foreach($page as $object) {
        if (isset($object["h1"])) {
          echo "<h1>".$object["h1"]."</h1>";
        }
        else if (isset($object["h2"])) {
          echo "<h2>".$object["h2"]."</h2>";
        }
        else if (isset($object["ul"])) {
          echo "<ul>";
          // Liste de liens
          foreach($object["ul"] as $li) {
            echo "<li><a target='_blank' href='"
            .$li["link"]."'>".$li["activity"]."</a><br>";
            // Liste de commentaires
            foreach($li["comments"] as $comment) {
              echo "<p class='comment'>".$comment["pseudo"]."&nbsp;:&nbsp;".$comment["comment"]."</p>";
            }
            // Entrée de commentaire
            echo "<button id='fold_input_comment' onClick='show_comment_input(this)'>Ajouter un Commentaire</button>";
            echo "<form hidden action='requests.php' method='post' id='".$li["activity"]."'>";
            echo "<input type='hidden' name='activity' value='".$li["activity"]."'>";
            echo "<input type='hidden' name='page' value='".$_REQUEST["page"]."'>";
            echo "<input type='text' name='pseudo' value='Votre pseudo'><br>";
            echo "<textarea name='comment' form='".$li["activity"]."'>Entrez un commentaire...</textarea><br>";
            echo "<input type='submit' value='Commenter'>";
            echo "</form></li>";
          }
          echo "</ul>";
        }
      }
    }
  }
?>
  <footer>
    Site Web Personnel de Maxime Vincent | Juillet 2021 | <a href="https://github.com/orthose/holidays-activities">Code Source</a>
  </footer>
</body>
</html>