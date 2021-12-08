<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Recherche Patient</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <p style="padding-left:25px;"><a href="recherche_document.php" title="Recherche des documents" class="navbar-brand">Recherche des documents</a></p>
      <p><a href="formDepot.php" title="Téléverser-documents" class="navbar-brand">Téléverser</a></p>
    </nav>
    <h1 class="text-center">Saisie d'informations patient</h1>
    <form method="post" action="recherche_patient.php">
      <!-- champ d'entrée du nom de l'utilisateur. -->
      <div class="form-group">
        <div style="padding-left:350px;">
          <label for="iduser" class="h4" > Nom : </label>
        </div>
        <div  class="h4" style="padding-left:350px;">
          <input type="text" class="form-control" id="iduser" name="user" autofocus style="width: 250px;height:35px;" placeholder="Nom du patient !!!" />
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
          <label for="Pays"  class="h4">Pays : </label>
          <!-- Sélectionneur de pays. -->
          <select class="form-select form-select-sm" name="pays" style="width: 250px;height:35px;">
            <?php
            require_once 'mysql.php';
            echo '<option value="">Indifférent</option>';
            foreach (getPays() as $value) {
                echo '<option value="'.$value['codePays'].'">'.$value['Libelle'].'</option>';
            }
            ?>
          </select>
        </div>
      </div>
      <p style="padding-left:350px;">
        <label for="Date1"  class="h4">Date de naissance entre : </label>
        <?php
        require_once 'utilitaire.php';
        // Sélectionneur de date.
        echo '<input class="sd" type="date" name="date_debut" value="Indifférent" min="1900-01-01" max="'.dateDuJour().'"/>';
            echo " et ";
        echo '<input class="sd" type="date" name="date_fin" value="Indifférent" min="1900-01-01" max="'.dateDuJour().'"/>';
        ?>
      </p>
      <p style="padding-left:350px;">
        <input type="submit" class="btn btn-outline-info" name="valid_form" value="Rechercher">
      </p>
    </form>
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
                          <th scope="col">Nom</th>
                          <th scope="col">Prenom</th>
                          <th scope="col">Details</th>
                          <th scope="col">Nom document</th>
                          <th scope="col">Telechargement</th>
                          <th scope="col">Visualiser</th>
                          <th scope="col">email</th>
                        </tr>
                      </thead>';
        $index = 0;
        foreach(getRecherche() as $key){
        //Si oui on affiche le résultat de la recherche.
        echo '<tr>
              <th scope="row">'.++$index.'</th>
              <td>'.$key['Nom'] .'</td>
              <td>'.$key['Prenom'] .'</td>
              <td><a href="fiche_patient.php?var1='.$key['CodePatients'].'" title="Détails">'.$key['Nom'].$key['Prenom'].'  </a></td>
              <td>'.$key['name'] .'</td>';
              echo '<td><form action="download.php" method="post">
              <input name="filePath" type="hidden" value = "'.$key['path'].'"/>
              <input name="patient" type="hidden" value = "patient"/>      
              <input type="submit" class="btn btn-outline-info" name="download" value="💾" style="width: 100%;height:center;" /></form></td>';
              echo '<td><form action="visualisation.php" method="post">
                        <input name="filePathVisualiser" type="hidden" value = "'.$key['path'].'"/>
                        <input type="submit" class="btn btn-outline-info" name="visualiser" value="👀" style="width: 100%;height:center;"/></form></td>';
              echo '<td><form action="envoie_email.php" method="post">
                    <input name="filePath" type="hidden" value = "'.$key['path'].'"/>
                    <input type="submit" class="btn btn-outline-info" name="email" value="📧" style="width: 100%;height:center;"/></form></td>';
            }
        echo'</tr></tbody></table></div>';
      }
    ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>