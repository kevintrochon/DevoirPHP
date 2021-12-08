<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>e-mail</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <p style="padding-left:25px;"><a href="recherche_patient.php" class="navbar-brand">Retour au formulaire</a></p>
        <p><a href="formDepot.php" title="Téléverser-documents" class="navbar-brand">Téléverser</a></p>
        <p><a href="recherche_document.php" title="Recherche-documents" class="navbar-brand">Recherche des documents</a></p>
    </nav>
    <h1 class="text-center">Saisie d'informations</h1>
    <form method="post" action="envoie_email.php">
      <!-- champ d'entrée adresse e-mail. -->
    <div  class="h4" style="padding-left:350px;">
        <input type="email" class="form-control" name="user" autofocus style="width: 250px;height:35px;" placeholder="votre adresse e-mail" />
    </div>
    <p style="padding-left:350px;">
        <?php
        echo '<input name="filePath" type="hidden" value = "'.$_POST['filePath'].'"/>';
        ?>
        <input type="submit" class="btn btn-outline-info" id="email" name="email" value="envoyer">
    </p>
    <?php
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['filePath']) && !empty($_POST['user']) && isset($_POST['user']))
        {
            require_once 'email.php';
            envoieMail($_POST['user'],$_POST['filePath']);
        }    
    ?>
  </form>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>