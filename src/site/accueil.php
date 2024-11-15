<?php
require('header_visiteur.php');
header_page("Accueil");

echo "<div class='video'>
    <h2>Vidéo explicative du fonctionnement du site</h2>
    <iframe width='560' height='315' src='https://www.youtube.com/embed/QmSxX2loVQ4' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
      </div>";
include('footer.html');
?>
