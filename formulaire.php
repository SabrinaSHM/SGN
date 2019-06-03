

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" media="screen" href="includes/style.css">
    <title>SYSTEME DE GESTION DE NOTES</title>
</head>
<body>
<a href="index.html"><img class="left" src="includes/home.png" width = "50" heigth = "50"/></a> 

<div class = "titre">
  <p>ETUDIANT/FORMATION</p>
</div>



<form action ="formulaire.php" method="GET" >
        <p>
        <input type="text" name="num" pattern="[0-9]{1,10}" placeholder="num_etudiant .ex : 111111" required>
          
            <input type="text" name="nom" placeholder = "nom" maxlength = "20" required> 
            <input type="text" name="prenom" placeholder="Prénom" maxlength = '20' required>  
            <input type="email" name="email" placeholder= "E-mail" maxlength = '120' required><br><br>
            <input type="text" name="id_matiere1" placeholder= "matière 1" maxlength = '4' required/>
            <input type="number" step="0.01" name="note1" placeholder= "note 1" min = "0" max = "20" required> 
            <input type="number" name="coeff1" placeholder= "coéfficient 1" min = "1" max = "10"  required> <br>
            <input type="text" name="id_matiere2" placeholder= "matière 2" maxlength = '4' required/>
            <input type="number" step="0.01" name="note2" placeholder= "note 2" min = "0" max = "20" required> 
            <input type="number" name="coeff2" placeholder= "coéfficient2" min = "0" max = "10"  required> <br> 
            <input type="text" name="id_matiere3" placeholder= "matière 3" maxlength = '4' required/>
            <input type="number" step="0.01" name="note3" placeholder= "note 3" min = "0" max = "20"  required> 
            <input type="number" name="coeff3" placeholder= "coéfficient 3" min = "1" max = "10"  required> <br>
           
         
     </p>   
     <br><br> 
        <input type="submit" name="submit" value="Enregistrer etudiant" class="btn-login" /><br>
        <input type="submit" name="calculate" value="Calculer la moyenne" class="btn-login" /><br>
 </form>

 <?php
  $conn = new mysqli("localhost", "id9808476_sabrinashm", "sabrina", "id9808476_sgn");


  try {

       //insertion dans la base de donées
        if(isset($_GET['submit'])){

          //reccuperation de l'information
          
          $num = $_GET['num'];
          $nom = $_GET['nom'];
          $prenom =$_GET['prenom'];
          $email = $_GET['email'];
          $id_matiere1 = $_GET['id_matiere1'];
          $note1 = $_GET['note1'];
          $coeff1 = $_GET['coeff1'];
          $id_matiere2 = $_GET['id_matiere2'];
          $note2 = $_GET['note2'];
          $coeff2 = $_GET['coeff2'];
          $id_matiere3 = $_GET['id_matiere3'];
          $note3 = $_GET['note3'];
          $coeff3 = $_GET['coeff3'];
  
          // insert student
           $sql = "INSERT INTO etudiants(num_etudiant ,nom,prenom,email) VALUES('$num','$nom','$prenom','$email');";
           mysqli_query($conn,$sql);
          // insert modules 
           $sql_tm = "INSERT INTO modules(id_module,coeff) VALUES('$id_matiere1','$coeff1'),
                                                              ('$id_matiere2','$coeff2'),
                                                              ('$id_matiere3','$coeff3');";
          mysqli_query($conn,$sql_tm);  
         
         /// find  the studentID 
         $sql = "SELECT num_etudiant FROM etudiants WHERE email = '$email' AND nom = '$nom' AND prenom = '$prenom'";
         $id = mysqli_query($conn,$sql);
         $row = mysqli_fetch_array($id);   
         $id = $row['num_etudiant'];

         // insert into note
         $sql = "INSERT INTO notes(note,module,etudiant) VALUES('$note1','$id_matiere1','$id'),
                                                               ('$note2','$id_matiere2','$id'),
                                                               ('$note3','$id_matiere3','$id');";
         mysqli_query($conn,$sql);   
         
         
         }
          //calcule de moyenne sans ajout à la bdd
          if(isset($_GET['calculate'])){

            $num = $_GET['num'];
            $nom = $_GET['nom'];
            $prenom =$_GET['prenom'];
            $email = $_GET['email'];
            $id_matiere1 = $_GET['id_matiere1'];
            $note1 = $_GET['note1'];
            $coeff1 = $_GET['coeff1'];
            $id_matiere2 = $_GET['id_matiere2'];
            $note2 = $_GET['note2'];
            $coeff2 = $_GET['coeff2'];
            $id_matiere3 = $_GET['id_matiere3'];
            $note3 = $_GET['note3'];
            $coeff3 = $_GET['coeff3'];

            //affichage de la moyenne si le boutton calculer est préssé 
            echo "<br>"."moyenne : ".(($note1*$coeff1)+($note2*$coeff2)+($note3*$coeff3))/($coeff1+$coeff2+$coeff3);

  
  }} catch (Exception $e) {
      echo $e ;
  }
  ?>

    
</body>
</html>