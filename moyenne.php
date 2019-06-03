

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" media="screen" href="includes/style.css">
    <title>Document</title>
</head>
<body>
<a href="index.html"><img class="left" src="includes/home.png" width = "50" heigth = "50"/></a> 



<table>
    <tr>
        <th>numE</th>
        <th>nom</th>
        <th>prenom</th>
        <th>moyenne</th>
    </tr>
   

<?php

$conn = new mysqli("localhost", "id9808476_sabrinashm", "sabrina", "id9808476_sgn");
if($conn->connect_error) {
    exit('Erreur de connexion à la base de données'); 
  }

//variable facilitant le calcul de la moyenne +initialisation
$sum = 0; //somme des coeff*note
$sum_coeff = 0;//somme des coefficients
$moyenne = 0;

// SELECT de tous les numéros étudiants
$sql = 'SELECT num_etudiant as netud FROM etudiants;';
$results = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($results);


//si j'ai au moins une donnée


    while ($row = mysqli_fetch_assoc($results)) {
        // pour chaque étudiant, on SELECT les notes associées à son numéro d'étudiant
        $sql_tmp = 'SELECT note, coeff
                    FROM notes n, modules m
                    WHERE (n.module = m.id_module) AND (n.etudiant ='.$row['netud'].');';
        
        $res_tmp = mysqli_query($conn, $sql_tmp);
        $resultCheck_tmp = mysqli_num_rows($res_tmp);

        if ($resultCheck_tmp > 0) {

            // ici on calcule la somme des notes, et aussi la somme des coef
            while ($row_tmp = mysqli_fetch_assoc($res_tmp)) {
                $sum += $row_tmp['coeff'] * $row_tmp['note'];
                $sum_coeff += $row_tmp['coeff'];
            }

            
            $moyenne = $sum / $sum_coeff;
            $sum = 0;
            $sum_coeff = 0;
            $num_e = $row['netud'];
    
            $sql= "UPDATE etudiants e SET e.moyenne_g = '$moyenne'
                    WHERE e.num_etudiant ='$num_e';
                    ";
            mysqli_query($conn,$sql);
            

        
            $moyenne = 0;

        }
    }






$sql = 'SELECt * FROM etudiants ORDER BY moyenne_g;';
$results = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($results);

if($resultCheck >0){
    while ($row = mysqli_fetch_assoc($results)){
        echo "<tr><td>".$row["num_etudiant"]."</td><td>".$row["nom"]."</td><td>".$row["prenom"]."</td><td>".$row["moyenne_g"]."</td></tr>";
    }
    echo "</table>";
}


?>





</table>   
</body>
</html>