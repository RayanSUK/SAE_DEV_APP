<?php include('partiels/navbar_adminsys.php'); ?>

<?php

echo"<br><br>";
echo "<h1>Voici les utilisateurs inscrits sur le site </h1><br><br>";
echo "<style>
table,td,tr{
    border: 1px solid black;
    border-collapse: collapse;
    padding: 8px;
}

</style>";

$file = "utilisateurs.csv";
$fp = fopen($file, "r");
echo "<table>";
while($res= fgetcsv($fp, 1024, ",")){
    echo "<tr>";
    foreach ($res as $val){
        echo "<td>".$val."</td>";
    }
    echo "</tr>\n";
}
echo "</table>";

?>

<?php include('partiels/footer.php'); ?>