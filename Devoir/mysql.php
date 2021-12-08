<?php
/*
  Récupération des motids d'admission dans la table correspondante.

  @return un tableau associatif avec les valeurs de la table.
*/
function getMotif() :array {
  require 'db-config.php';
  $request;
  try {
    $PDO = new PDO($DB_DSN, $DB_USER ,$DB_PASS, $OPTIONS);
    $request = $PDO->prepare('SELECT * FROM motifs');
    $request -> execute();
    return $request -> fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $pe) {
    echo 'ERREUR : '.$pe->getMessage();
  }
}

/*
  Récupération des motids d'admission en recherchant par l'id.

  @return un tableau associatif avec les valeurs de la table.
*/
function getMotifById($codeMotif) :array {
  require 'db-config.php';
  $request;
  try {
    $PDO = new PDO($DB_DSN, $DB_USER ,$DB_PASS, $OPTIONS);
    $request = $PDO->prepare('SELECT * FROM motifs WHERE CodeMotifs = ?');
    $request->bindParam(1, $codeMotif);
    $request -> execute();
    return $request -> fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $pe) {
    echo 'ERREUR : '.$pe->getMessage();
  }
}

/*
  Récupération des pays dans la table correspondante.

  @return un tableau associatif avec les valeurs de la table.
*/
function getPays() :array {
  require 'db-config.php';
  $request;
  try {
    $PDO = new PDO($DB_DSN,$DB_USER,$DB_PASS, $OPTIONS);
    $request = $PDO->prepare('SELECT * FROM pays');
    $request -> execute();
    return $request -> fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $pe) {
    echo 'ERREUR : '.$pe->getMessage();
  }
}

/*
  Récupération des détails du patient.

  @return un tableau associatif avec les valeurs de la table.
*/
function getDetails() : array{
  require 'db-config.php';

  try {
    $PDO = new PDO($DB_DSN,$DB_USER,$DB_PASS, $OPTIONS);
    $request;
    $request = $PDO->prepare('SELECT patients.Nom, patients.Prenom, Sexe.libelle AS libelle, date_format(patients.DateNaissance, "%d/%m/%Y")AS DateNaissance,
                                     patients.NumeroSecSoc, motifs.Libelle AS motif, date_format(patients.Date1Entree, "%d/%m/%Y")AS Date1Entree, pays.Libelle as pays
                              FROM patients
                              inner Join motifs ON patients.CodeMotif = motifs.CodeMotifs
                              inner Join pays ON patients.CodePays = pays.codePays
                              inner Join Sexe ON patients.Sexe = Sexe.CodeSexe
                              WHERE CodePatients = ?
                              ');

    if (isset($_GET['var1']) && !empty($_GET['var1'])) {
      $request->bindParam(1, $_GET['var1']);
      $request -> execute();
      return $request -> fetchAll(PDO::FETCH_ASSOC);
    }

  } catch (PDOException $pe) {
    echo 'ERREUR : '.$pe->getMessage();
  }
}

/*
  Vérification qu'une recherche à été lancée.

  @return vrai si des paramètres on été sélectionné.
*/
function lancerRecherche(): bool {
  $recherche = false;
  if (!empty($_POST) && isset($_POST)) {
    $recherche = true;
  }
  return $recherche;
}

/*
  Lance la recherche selon les paramètres envoyées.

  @return un tableau associatif qui contient le résultat de la recherche.
*/
function getRecherche() : array{
  require 'db-config.php';
  try {
    //Création de l'objet PDO pour instancier une connexion à la base de données.
    $PDO = new PDO($DB_DSN,$DB_USER,$DB_PASS, $OPTIONS);
    $request;
    // Nom de l'utilisateur est renseigné et le reste des paramètres est vide.
    if (!empty($_POST['user']) && isset($_POST['user']) && empty($_POST['motif']) && empty($_POST['pays']) && empty($_POST['date_debut']) && empty($_POST['date_fin'])) {
      $request = $PDO->prepare('SELECT * FROM patients inner join documents on patients.CodePatients = documents.CodePatients WHERE Nom = ? ORDER BY Nom, Prenom ASC');
      $request->bindParam(1, $_POST['user']);
    // Motif d'admission est renseigné et le reste des paramètres est vide.
    }elseif (!empty($_POST['motif']) && isset($_POST['motif']) && empty($_POST['user']) && empty($_POST['pays']) && empty($_POST['date_debut']) && empty($_POST['date_fin'])) {
      $request = $PDO->prepare('SELECT * FROM patients inner join documents on patients.CodePatients = documents.CodePatients WHERE patients.CodeMotif = ? ORDER BY Nom, Prenom ASC');
      $request->bindParam(1, $_POST['motif']);
    // Pays est renseigné et le reste des paramètres est vide.
    }elseif (!empty($_POST['pays']) && isset($_POST['pays']) && empty($_POST['user']) && empty($_POST['motif']) && empty($_POST['date_debut']) && empty($_POST['date_fin'])) {
      $request = $PDO->prepare('SELECT * FROM patients inner join documents on patients.CodePatients = documents.CodePatients WHERE CodePays = ? ORDER BY Nom, Prenom ASC');
      $request->bindParam(1, $_POST['pays']);
    // Date de naissance est renseigné et le reste des paramètres est vide.
    }elseif (!empty($_POST['date_debut']) && isset($_POST['date_debut']) && !empty($_POST['date_fin']) && isset($_POST['date_fin']) && empty($_POST['user']) && empty($_POST['pays']) && empty($_POST['date_debut'])) {
      $request = $PDO->prepare('SELECT * FROM patients inner join documents on patients.CodePatients = documents.CodePatients WHERE DateNaissance BETWEEN ? AND ? ORDER BY Nom, Prenom ASC');
      $request->bindParam(1, $_POST['date_debut']);
      $request->bindParam(2, $_POST['date_fin']);
    // Nom utilisateur et le motif d'admission sont renseignés et le reste des paramètres est vide.
    }elseif (!empty($_POST['user']) && isset($_POST['user']) && !empty($_POST['motif']) && isset($_POST['motif']) && empty($_POST['pays']) && empty($_POST['date_debut'] && empty($_POST['date_fin']))) {
      $request = $PDO->prepare('SELECT * FROM patients inner join documents on patients.CodePatients = documents.CodePatients WHERE Nom = ? AND patients.CodeMotif = ? ORDER BY Nom, Prenom ASC');
      $request->bindParam(1, $_POST['user']);
      $request->bindParam(2, $_POST['motif']);
    // Nom utilisateur et le pays sont renseignés et le reste des paramètres est vide.
    }elseif (!empty($_POST['user']) && isset($_POST['user']) && !empty($_POST['pays']) && isset($_POST['pays']) && empty($_POST['motif']) && empty($_POST['date_debut'] && empty($_POST['date_fin']))) {
      $request = $PDO->prepare('SELECT * FROM patients inner join documents on patients.CodePatients = documents.CodePatients WHERE Nom = ? AND CodePays = ? ORDER BY Nom, Prenom ASC');
      $request->bindParam(1, $_POST['user']);
      $request->bindParam(2, $_POST['pays']);
      // Nom utilisateur et la date d'anniversaire sont renseignés et le reste des paramètres est vide.
    }elseif (!empty($_POST['user']) && isset($_POST['user']) && !empty($_POST['date_debut']) && isset($_POST['date_debut']) && !empty($_POST['date_fin']) && isset($_POST['date_fin']) && empty($_POST['motif']) && empty($_POST['pays'] )) {
      $request = $PDO->prepare('SELECT * FROM patients inner join documents on patients.CodePatients = documents.CodePatients WHERE Nom = ? AND DateNaissance BETWEEN ? AND ? ORDER BY Nom, Prenom ASC');
      $request->bindParam(1, $_POST['user']);
      $request->bindParam(2, $_POST['date_debut']);
      $request->bindParam(3, $_POST['date_fin']);
    // le motif d'admission et la date de naissance sont renseignés et le reste des paramètres est vide.
    }elseif (!empty($_POST['motif']) && isset($_POST['motif']) && !empty($_POST['date_debut']) && isset($_POST['date_debut']) && !empty($_POST['date_fin']) && isset($_POST['date_fin']) && empty($_POST['user']) && empty($_POST['pays'] )) {
      $request = $PDO->prepare('SELECT * FROM patients inner join documents on patients.CodePatients = documents.CodePatients WHERE patients.CodeMotif = ? AND DateNaissance BETWEEN ? AND ? ORDER BY Nom, Prenom ASC');
      $request->bindParam(1, $_POST['motif']);
      $request->bindParam(2, $_POST['date_debut']);
      $request->bindParam(3, $_POST['date_fin']);
    // le motif d'admission et le pays sont renseignés et le reste des paramètres est vide.
    }elseif (!empty($_POST['motif']) && isset($_POST['motif']) && !empty($_POST['pays']) && isset($_POST['pays']) && empty($_POST['date_debut']) && empty($_POST['date_fin']) && empty($_POST['user'])) {
      $request = $PDO->prepare('SELECT * FROM patients inner join documents on patients.CodePatients = documents.CodePatients WHERE patients.CodeMotif = ? AND CodePays = ? ORDER BY Nom, Prenom ASC');
      $request->bindParam(1, $_POST['motif']);
      $request->bindParam(2, $_POST['pays']);
    // le pays et la date de naissance sont renseignés et le reste des paramètres est vide.
    }elseif (!empty($_POST['pays']) && isset($_POST['pays']) && !empty($_POST['date_debut']) && isset($_POST['date_debut']) && !empty($_POST['date_fin']) && isset($_POST['date_fin']) && empty($_POST['user']) && empty($_POST['motif'] )) {
      $request = $PDO->prepare('SELECT * FROM patients inner join documents on patients.CodePatients = documents.CodePatients WHERE CodePays = ? AND DateNaissance BETWEEN ? AND ? ORDER BY Nom, Prenom ASC');
      $request->bindParam(1, $_POST['pays']);
      $request->bindParam(2, $_POST['date_debut']);
      $request->bindParam(3, $_POST['date_fin']);
    // le pays et le motif d'admission et le nom du patient sont renseignés et le reste des paramètres est vide.
    }elseif (!empty($_POST['user']) && isset($_POST['user']) && !empty($_POST['motif']) && isset($_POST['motif']) && !empty($_POST['pays']) && isset($_POST['pays']) && empty($_POST['date_debut']) && empty($_POST['date_fin'] )) {
      $request = $PDO->prepare('SELECT * FROM patients inner join documents on patients.CodePatients = documents.CodePatients WHERE Nom = ? AND CodePays = ? AND patients.CodeMotif = ? ORDER BY Nom, Prenom ASC');
      $request->bindParam(1, $_POST['user']);
      $request->bindParam(2, $_POST['pays']);
      $request->bindParam(3, $_POST['motif']);
    // le pays et le motif d'admission et le nom du patient sont renseignés et le reste des paramètres est vide.
    }elseif (!empty($_POST['user']) && isset($_POST['user']) && !empty($_POST['motif']) && isset($_POST['motif']) && !empty($_POST['date_debut']) && isset($_POST['date_debut']) && !empty($_POST['date_fin']) && isset($_POST['date_fin']) && empty($_POST['pays'])) {
      $requete .='WHERE Nom = ? AND DateNaissance BETWEEN ? AND ? AND CodeMotif = ? ORDER BY Nom, Prenom ASC';
      $request = $PDO->prepare('SELECT * FROM patients inner join documents on patients.CodePatients = documents.CodePatients WHERE Nom = ? AND DateNaissance BETWEEN ? AND ? AND patients.CodeMotif = ? ORDER BY Nom, Prenom ASC');
      $request->bindParam(1, $_POST['user']);
      $request->bindParam(2, $_POST['date_debut']);
      $request->bindParam(3, $_POST['date_fin']);
      $request->bindParam(3, $_POST['motif']);
    // le pays et le motif d'admission et le nom du patient sont renseignés et le reste des paramètres est vide.
    }elseif (!empty($_POST['user']) && isset($_POST['user']) && !empty($_POST['pays']) && isset($_POST['pays']) && !empty($_POST['date_debut']) && isset($_POST['date_debut']) && !empty($_POST['date_fin']) && isset($_POST['date_fin']) && empty($_POST['motif'])) {
      $request = $PDO->prepare('SELECT * FROM patients inner join documents on patients.CodePatients = documents.CodePatients WHERE Nom = ? AND DateNaissance BETWEEN ? AND ? AND CodePays = ? ORDER BY Nom, Prenom ASC');
      $request->bindParam(1, $_POST['user']);
      $request->bindParam(2, $_POST['date_debut']);
      $request->bindParam(3, $_POST['date_fin']);
      $request->bindParam(3, $_POST['pays']);
    // le pays et le motif d'admission et le nom du patient sont renseignés et le reste des paramètres est vide.
    }elseif (!empty($_POST['motif']) && isset($_POST['motif']) && !empty($_POST['pays']) && isset($_POST['pays']) && !empty($_POST['date_debut']) && isset($_POST['date_debut']) && !empty($_POST['date_fin']) && isset($_POST['date_fin']) && empty($_POST['user'])) {
      $request = $PDO->prepare('SELECT * FROM patients inner join documents on patients.CodePatients = documents.CodePatients WHERE patients.CodeMotif = ? AND DateNaissance BETWEEN ? AND ? AND CodePays = ? ORDER BY Nom, Prenom ASC');
      $request->bindParam(1, $_POST['motif']);
      $request->bindParam(2, $_POST['date_debut']);
      $request->bindParam(3, $_POST['date_fin']);
      $request->bindParam(3, $_POST['pays']);
    // Tous les paramètres ont été renseignés.
    }elseif (!empty($_POST['motif']) && isset($_POST['motif']) && !empty($_POST['pays']) && isset($_POST['pays']) && !empty($_POST['date_debut']) && isset($_POST['date_debut']) && !empty($_POST['date_fin']) && isset($_POST['date_fin']) && !empty($_POST['user']) && isset($_POST['user'])) {
      $request = $PDO->prepare('SELECT * FROM patients inner join documents on patients.CodePatients = documents.CodePatients WHERE Nom = ? AND DateNaissance BETWEEN ? AND ? AND CodePays = ? AND patients.CodeMotif = ? ORDER BY Nom, Prenom ASC');
      $request->bindParam(1, $_POST['user']);
      $request->bindParam(2, $_POST['date_debut']);
      $request->bindParam(3, $_POST['date_fin']);
      $request->bindParam(4, $_POST['pays']);
      $request->bindParam(5, $_POST['motif']);
    // Sinon on affiche la liste complète.
    }else {
      $request = $PDO->prepare('SELECT * FROM patients inner join documents on patients.CodePatients = documents.CodePatients ORDER BY Nom, Prenom ASC');
    }
    $request -> execute();
    return $request -> fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $pe) {
    echo 'ERREUR : '.$pe->getMessage();
  }
}

/*
  enregistre un document en base de données.
*/
function enregistreDocument($namePatient,$nameDocument,$pathDocument,$contenu,$typeDocument,$codePatient,$codeMotif):bool{
  require 'db-config.php';
  $isenregistrer;
  try {
    $PDO = new PDO($DB_DSN,$DB_USER,$DB_PASS, $OPTIONS);
    $request;
    $request = $PDO->prepare('insert into documents (namePatient,name, path,contenu,typeDocument,CodePatients,CodeMotif) values(?,?,?,?,?,?,?)');
    $request->bindParam(1, $namePatient);
    $request->bindParam(2, $nameDocument);
    $request->bindParam(3, $pathDocument);
    $request->bindParam(4, $contenu);
    $request->bindParam(5, $typeDocument);
    $request->bindParam(6, $codePatient);
    $request->bindParam(7, $codeMotif);
    $request -> execute();
    return $isenregistrer = true;
  } catch (PDOException $pe) {
    echo 'Document : existe déjà en base !!!! ';
    return $isenregistrer = false;
  }
}

/**
 * Récupération de l'id du client via son nom.
 */
function getIdPatientByName($name):int{
  require 'db-config.php';
  try {
    $PDO = new PDO($DB_DSN,$DB_USER,$DB_PASS, $OPTIONS);
    $request;
    $request = $PDO->prepare('SELECT CodePatients FROM patients WHERE Nom = ?');
    $request->bindParam(1, $name);
    $request -> execute();
    $resultat = $request -> fetch(PDO::FETCH_ASSOC);
    return $resultat['CodePatients'];
  } catch (PDOException $pe) {
    echo 'ERREUR : '.$pe->getMessage();
  }
}

/**
 * Récupère les documents d'un patient.
 */
function getDocument($name):array{
  require 'db-config.php';
  $id = getIdPatientByName($name);
  try {
    $PDO = new PDO($DB_DSN,$DB_USER,$DB_PASS, $OPTIONS);
    $request;
    $request = $PDO->prepare('SELECT * FROM documents WHERE CodePatients = ?');
    $request->bindParam(1, $id);
    $request -> execute();
    return $request -> fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $pe) {
    echo 'ERREUR : '.$pe->getMessage();
  }
}


function getDocumentHorsPatient():array{
      require 'db-config.php';
      try {
        $PDO = new PDO($DB_DSN,$DB_USER,$DB_PASS, $OPTIONS);
        $request;
        if(!empty($_POST['user']) && isset($_POST['user']) 
        && !empty($_POST['typDocu']) && isset($_POST['typDocu']) 
        && !empty($_POST['motif']) && isset($_POST['motif'])
        && !empty($_POST['Contenu']) && isset($_POST['Contenu'])){
        $request = $PDO->prepare('SELECT * FROM documents WHERE name = ? and contenu = ? AND typeDocument = ? AND CodeMotif = ?');
        $request->bindParam(1, $_POST['user']);
        $request->bindParam(2, $_POST['Contenu']);
        $request->bindParam(3, $_POST['typDocu']);
        $request->bindParam(4, $_POST['motif']);
        $request -> execute();
        return $request -> fetchAll(PDO::FETCH_ASSOC);
        }
        return array('<p class="alert alert-danger" style="padding-left:350px;">Vous n\'avez pas rempli tous les champs.</p>');
      } catch (PDOException $pe) {
        echo 'ERREUR : '.$pe->getMessage();
      }
}

/**
 * Récupération de le nom du client via son nom.
 */
function verifNomPatient($name):bool{
  require 'db-config.php';
  $is_exist = $false;
  try {
    $PDO = new PDO($DB_DSN,$DB_USER,$DB_PASS, $OPTIONS);
    $request;
    $request = $PDO->prepare('SELECT Nom FROM patients WHERE Nom = ?');
    $request->bindParam(1, $name);
    $request -> execute();
    $resultat = $request -> fetch(PDO::FETCH_ASSOC);
    if(!empty($resultat) && isset($resultat)){
      $is_exist = $true;
    }
    return $is_exist;
  } catch (PDOException $pe) {
    echo 'ERREUR : '.$pe->getMessage();
  }
}