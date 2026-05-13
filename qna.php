<?php
error_reporting(E_ALL); //zapnutie chybových hlásení
ini_set("display_errors", "On");
require_once('database.php');
include "otazky.php";
class Qna extends Database {

    protected $connection;

    public function __construct() {
        $this->connect();
        //Použitie gettera na získanie spojenia
        $this->connection = $this->getConnection();
    }

    public function vymazatVsetko() {
      $sql = "DELETE FROM otazky";
      try {
        $statement = $this->connection->prepare($sql);
        $delete = $statement->execute();
        http_response_code(200);
      } catch (\Exception $exception) {
          http_response_code(500);
          return false;
      }
    }

    public function vybratVsetko() {
      $sql = "SELECT * FROM otazky";
      try {
        $statement = $this->connection->prepare($sql);
        $read = $statement->execute();
        http_response_code(200);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
      } catch (\Exception $exception) {
          http_response_code(500);
          return false;
      }
    }

    public function nacitatOtazky() {
        $otazky = array(
            "Aké sú vaše skúsenosti s PHP?",
            "Aký je váš oblúbený programovací jayk?",
            "Aké sú vaše ciele pre túto stránku?",
            "Aké je najlepšie zviera?",
            "Aká je tvoja oblúbená rasa v World Of Warcraft?",
            "Aký zvuk robí capybara?",
            "Kto je SUS?"
        );
        $odpovede = array(
            "Mám základné znalosti php a skúsenosti, ktoré neviem použiť.",
            "Môj oblúbený programovací jazyk bude určite PHP.",
            "Mojím cielom je prejsť tento predmet.",
            "Odpoveď buďe vždy kačica.",
            "Moja oblúbená rasa v World Of Warcraft je goblin.",
            "Ok i pull up.",
            "The impostor is SUS."
        );
        $sql = "INSERT INTO otazky (otazka, odpoved)
                VALUES (:otazka, :odpoved)";
        try {
          for ($i=0;$i < count($otazky);$i++) {
            $statement = $this->connection->prepare($sql);
            $insert = $statement->execute(array(
                ':otazka' => $otazky[$i],
                ':odpoved' => $odpovede[$i]
            ));
          }
            http_response_code(200);
            return $insert;
        } catch (\Exception $exception) {
            http_response_code(500);
            return false;
        }
    }
}
$qna = new Qna();

// Toto je len pre ulohu, inak by som to takto netvoril :)
$qna->vymazatVsetko();
$qna->nacitatOtazky();


?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moja stránka</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/accordion.css">
    <link rel="stylesheet" href="css/banner.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <?php include "parts/header.php" ?>
  <main>
    <section class="banner">
      <div class="container text-white">
        <h1>Q&A</h1>
      </div>
    </section>
    <section class="container">
      <div class="row">
        <div class="col-100 text-center">
          <p><strong><em>Elit culpa id mollit irure sit. Ex ut et ea esse culpa officia ea incididunt elit velit veniam qui. Mollit deserunt culpa incididunt laborum commodo in culpa.</em></strong></p>
        </div>
      </div>
    </section>
      <section class="container">
        <?php foreach ($qna->vybratVsetko() as $row){ ?>
          <div class="accordion">
            <div class="question"><?php echo $row["otazka"];?></div>
            <div class="answer"><?php echo $row["odpoved"];?></div>
          </div>
        <?php } ?>
      </section>
    </section>
  </div>
  </main>
  <?php include "parts/footer.php"?>
<script src="js/accordion.js"></script>
<script src="js/menu.js"></script>
</body>
</html>