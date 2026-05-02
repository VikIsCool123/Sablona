<?php
    function getImages(){
        $jsonSubor = file_get_contents("json/portfolia.json");
        $portfolia = json_decode($jsonSubor, true);
        //$portfolia["portfolios"][0]["url"];
        for ($i=0;$i<8;$i++){
            $url = $portfolia["portfolios"][$i]["url"];
            $imageID = $portfolia["portfolios"][$i]["image"];
            echo "<a href='$url'>";
            echo "<div class='col-25 portfolio text-white text-center' id='$imageID'>";
                echo $portfolia["portfolios"][$i]["name"];
            echo "</div>";
            echo "</a>";
        }
    }
?>