<?php
include __DIR__.'/../../../class/wrestler.class.php';

$title = "Catcheurs";

// Paramètres de pagination et filtres
$itemsPerPage = 20; 
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$withTeams = isset($_GET['with_teams']) ? filter_var($_GET['with_teams'], FILTER_VALIDATE_BOOLEAN) : false;

// Récupération des filtres
$filters = [];
if (!empty($_GET['name'])) {
    $filters['name'] = '%'.$_GET['name'].'%'; // Pour une recherche partielle
}
if (!empty($_GET['id'])) {
    $filters['id'] = (int)$_GET['id'];
}

// Récupération des données
$offset = ($currentPage - 1) * $itemsPerPage;

if (!empty($filters)) {
    // Utilisation de find() avec pagination personnalisée
    $wrestlers = Wrestler::findWithPagination($db, $filters, $withTeams, $itemsPerPage, $offset);
    $totalWrestlers = Wrestler::countWithFilters($db, $filters, $withTeams);
} else {
    // Mode normal sans filtres
    $wrestlers = Wrestler::fetchPaginated($db, $withTeams, $itemsPerPage, $offset);
    $totalWrestlers = Wrestler::countAll($db, $withTeams);
}

$totalPages = ceil($totalWrestlers / $itemsPerPage);