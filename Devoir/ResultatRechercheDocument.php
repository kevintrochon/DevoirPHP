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
              if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['filePathDownloadDocument']))
              {
                echo $_POST['filePathDownloadDocument'];
                //download($key['path']);
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