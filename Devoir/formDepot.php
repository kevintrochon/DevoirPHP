<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Formulaire dépot documents</title>
  </head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <p style="padding-left:25px;"><a href="recherche_patient.php" class="navbar-brand">Retour au formulaire</a></p>
        <p><a href="recherche_document.php" title="Recherche des documents" class="navbar-brand">Recherche des documents</a></p>
    </nav>
    <h1 class="text-center">Dépôt de documents</h1>
    <form action="formDepot.php" enctype="multipart/form-data" method="post" style="padding-left:350px;">
        <div>
          <label for="iduser" class="h4" > Nom du patient : </label>
        </div>
        <div  class="h4">
          <input type="text" class="form-control" id="iduser" name="name" autofocus style="width: 250px;height:35px;" required="required" />
        </div>
        <div>
          <label for="idprenom" class="h4" > Prenom du patient : </label>
        </div>
        <div  class="h4">
          <input type="text" class="form-control" id="idprenom" name="prenom" autofocus style="width: 250px;height:35px;" required="required" />
        </div>
        <div>
          <label for="iduser" class="h4" > Nom du document : </label>
        </div>
        <div  class="h4">
          <input type="text" class="form-control" id="iduser" name="nameDocu" style="width: 250px;height:35px;" placeholder="prescription, identitée,..." required="required"/>
        </div>
        <div >
          <label for="typDocu" class="h4" > Type de document : </label>
        </div>
        <div  class="h4">
          <input type="text" class="form-control" id="typDocu" name="typDocu" style="width: 250px;height:35px;" placeholder="pdf, png, jpeg, jpg, gif,..." required="required"/>
        </div>
          <div>
          <label for="Contenu" class="h4" > Contenu du document : </label>
        </div>
        <div  class="h4">
          <input type="text" class="form-control" id="Contenu" name="Contenu" style="width: 250px;height:35px;" placeholder="Radio, Certificat,..." required="required"/>
        </div>
        <div>
            <label for="motifs" class="h4">Motif d'admission : </label>
            <!-- Sélectionneur de motif d'admission-->
            <select class="form-select form-select-sm" style="width: 250px;height:35px;" name="motif" required="required">
            <?php
            require_once 'mysql.php';
            echo '<option value="">Indifférent</option>';
            $i=1;
            foreach (getMotif() as $value) {
                echo '<option value="'.$i.'">'.$value['Libelle'].'</option>';
                $i++;
            }
            ?>
            </select>
        </div>
    <p>
    <label for="iduser" class="h4" > Documents : </label>
    <br>
        <input type = "file" name = "upload" class="btn btn-outline-info" required="required"/><br/>
    </p>
    <p>
        <input type = "submit" name = "submit" class="btn btn-outline-info"/>
    </p>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>


<?php
    require_once 'mysql.php';
    // On vérifie que tout les champs on bien été rempli et que le nom du patient existe en base de données pour enregistrer un document.
    if(isset($_POST['submit']) 
        && isset($_POST['name']) && !empty($_POST['name'])
        && isset($_POST['nameDocu']) && !empty($_POST['nameDocu'])
        && isset($_POST['typDocu']) && !empty($_POST['typDocu'])
        && isset($_POST['Contenu']) && !empty($_POST['Contenu'])
        && isset($_POST['motif']) && !empty($_POST['motif'])
        && isset($_POST['prenom']) && !empty($_POST['prenom'])
        && verifNomPatient($_POST['name'],$_POST['prenom'])){
        $maxSize = 5000000;
        $validExt = array('.pdf');

        if($_FILES['upload']['error']>0){
            Echo "Une erreur est survenur lors du transfert";
            die;
        }

        if ($_FILES['upload']['size'] > $maxSize) {
            echo "Le fichier est trop volumineux";
            die;
        }
        
        $name = $_FILES['upload']['name'];
        $fileExt = "." . strtolower(substr(strrchr($_FILES['upload']['name'], '.'),1));
        $filename = strtolower(substr(strrchr($_FILES['upload']['name'], '.'),0));
        if(!in_array($fileExt,$validExt)){
            echo "Mauvais type de fichier";
            die;
        }

        $tmpName = $_FILES['upload']['tmp_name'];
        $pathDocument = "D:/wamp64/www/Devoir/upload/". $name;
        $resultat = move_uploaded_file($tmpName, $pathDocument);
        if ($resultat) {
            if(enregistreDocument($_POST['name'],$_POST['prenom'],$_POST['nameDocu'],$pathDocument,$_POST['Contenu'],$_POST['typDocu'],getIdPatientByName($_POST['name']),$_POST['motif'])){
                echo '<p class="alert alert-success" style="padding-left:350px;">Transfert terminé !</p>';
            }
        }
    }
?>