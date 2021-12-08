<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Document</title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <p style="padding-left:25px;"><a href="recherche_patient.php" class="navbar-brand">Retour au formulaire</a></p>
    <p><a href="formDepot.php" title="Téléverser-documents" class="navbar-brand">Téléverser</a></p>
  </nav>
  <div style="text-align: center;">
    <pre>

      <?php
        require_once 'mysql.php';
        foreach (getDetails() as $result){
            echo '<p>';
            echo ' '.$result['Nom'] .' '.$result['Prenom'].', de sexe : '.$result['libelle'].' né(e) le : '. $result['DateNaissance'].'.';
            echo '</p>';
            echo '<p>';
            echo ' Le numéro de sécurité sociale est :'.$result['NumeroSecSoc'];
            echo '</p>';
            echo '<p>';
            echo ' pour le motif suivant : '.$result['motif'].' à la date du : '.$result['Date1Entree'].' et est originaire de : '.$result['pays'];
            echo '</p>';
          }
      ?>

    </pre>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>


