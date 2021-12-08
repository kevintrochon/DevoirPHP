<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Recherche Documents</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <p style="padding-left:25px;"><a href="recherche_patient.php" class="navbar-brand">Retour au formulaire</a></p>
      <p><a href="formDepot.php" title="Téléverser-documents" class="navbar-brand">Téléverser</a></p>
    </nav>
    <h1 class="text-center">Saisie d'informations</h1>
    <form method="post" action="recherche_document.php">
      <!-- champ d'entrée du nom de l'utilisateur. -->
      <div class="form-group">
        <div style="padding-left:350px;">
          <label for="iduser" class="h4" > Nom document : </label>
        </div>
        <div  class="h4" style="padding-left:350px;">
          <input type="text" class="form-control" id="iduser" name="user" autofocus style="width: 250px;height:35px;" placeholder="prescription, identitée,..." />
        </div>
        <div style="padding-left:350px;">
          <label for="typDocu" class="h4" > Type document : </label>
        </div>
        <div  class="h4" style="padding-left:350px;">
          <input type="text" class="form-control" id="typDocu" name="typDocu" autofocus style="width: 250px;height:35px;" placeholder="pdf, png, jpeg, jpg, gif,..." />
        </div>
        <div style="padding-left:350px;">
          <label for="motifs"  class="h4">Motif d'admission : </label>
          <!-- Sélectionneur de motif d'admission-->
          <select class="form-select form-select-sm" name="motif" style="width: 250px;height:35px;">
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
          <div style="padding-left:350px;">
          <label for="Contenu" class="h4" > Contenu : </label>
        </div>
        <div  class="h4" style="padding-left:350px;">
          <input type="text" class="form-control" id="typDocu" name="Contenu" autofocus style="width: 250px;height:35px;" placeholder="Radio, Certificat,..."/>
        </div>
        </div>
        <br>
      <p style="padding-left:350px;">
        <input type="submit" class="btn btn-outline-info" name="valid_form" value="Rechercher">
      </p>
      <?php
      require_once 'mysql.php';
      require_once 'utilitaire.php';
      //On vérifie qu'une recherche a été lancée.
      if (lancerRecherche()) {
        echo '<div class="table-responsive" background-color: lightGreen;border: 1px solid black;" style="padding-left:50px;">
                <table class="table table-bordered" style="width: 1300px;height:50px;">
                    <tbody>
                      <thead>
                        <tr>
                          <th scope="col">Numéro ligne</th>
                          <th scope="col">Nom du patient</th>
                          <th scope="col">Nom du document</th>
                          <th scope="col">contenu</th>
                          <th scope="col">typeDocument</th>
                          <th scope="col">Motif</th>
                          <th scope="col">Telechargement</th>
                          <th scope="col">Visualiser</th>
                          <th scope="col">email</th>
                        </tr>
                      </thead>';
        $index = 0;
        foreach(getDocumentHorsPatient() as $key){
        //Si oui on affiche le résultat de la recherche.
        $motifDocument = getMotifById($key['CodeMotif']);
        echo '<tr>
              <th scope="row">'.++$index.'</th>
              <td>'.$key['namePatient'] .'</td>
              <td>'.$key['name'] .'</td>
              <td>'.$key['contenu'] .'</td>
              <td>'.$key['typeDocument'] .'</td>
              <td>'.array_values($motifDocument)[1].'</td>';
              echo '<td><form action="recherche_patient.php" method="post">          
              <input name="filePathDownloadDocument" type="hidden" value = "'.$key['path'].'"/>
              <input type="submit" class="btn btn-outline-info" name="download" value="💾" style="width: 100%;height:center;" /></form></td>';
              if(isset($_POST['filePathDownloadDocument']))
              {
                download($_POST['filePathDownloadDocument']);
              }
              echo '<td><form action="visualisation.php" method="post">
                                    <input name="filePathVisualiser" type="hidden" value = "'.$key['path'].'"/>
                                    <input type="submit" class="btn btn-outline-info" name="visualiser" value="👀" style="width: 100%;height:center;"/></form></td>';
              echo '<td><form action="recherche_patient.php" method="post">
                    <input name="filePath" type="hidden" value = "'.$key['path'].'"/>
                    <input type="submit" class="btn btn-outline-info" name="email" value="📧" style="width: 100%;height:center;"/></form></td>';
            }
            if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['filePath']))
            {
              require_once 'email.php';
              envoieMail($_POST['filePath']);
            }
        echo'</tr></tbody></table></div>';
      }
    ?>
  </form>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>