<?php
if(isset($_POST['download']) && ! empty($_POST['download']) && $_POST['filePath'] && ! empty($_POST['filePath']) && isset($_POST['patient']) && ! empty($_POST['patient']))
{
    require_once 'utilitaire.php';
    download($_POST['filePath']);
    header('location:recherche_patient.php');
}else if (isset($_POST['download']) && ! empty($_POST['download']) && $_POST['filePath'] && ! empty($_POST['filePath']) && isset($_POST['document']) && ! empty($_POST['document'])) {
    require_once 'utilitaire.php';
    download($_POST['filePath']);
    header('location:recherche_document.php');
}
