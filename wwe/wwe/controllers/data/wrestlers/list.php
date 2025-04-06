<?php
include __DIR__.'/../../../class/wrestler.class.php';

$title = "Catcheurs";

// Paramètres de pagination et filtres
$itemsPerPage = 20; 
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $itemsPerPage;
$withTeams = isset($_GET['with_teams']) ? filter_var($_GET['with_teams'], FILTER_VALIDATE_BOOLEAN) : false;
$filtered_page = false;

try {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $filters = $_GET;

        if (isset($filters["confirm_envoyer"]) && isset($filters["page"])) {
            $filtered_page = true;
        }

        unset($filters["confirm_envoyer"]);
        unset($filters["page"]);


        foreach ($filters as $key => $val) {
            if (empty($val)) {
                unset($filters[$key]);
            }
        }

        if ($filtered_page) {
            $wrestlers = Wrestler::findWithPagination($db, $filters, $withTeams, $itemsPerPage, $offset);
            $totalWrestlers = Wrestler::countWithFilters($db, $filters, $withTeams);
        } else {
            if (!empty($filters)) {
                $wrestlers = Wrestler::findWithPagination($db, $filters, $withTeams, $itemsPerPage, $offset);
                $totalWrestlers = Wrestler::countWithFilters($db, $filters, $withTeams);
            } else {
                $wrestlers = Wrestler::fetchPaginated($db, $withTeams, $itemsPerPage, $offset);
                $totalWrestlers = Wrestler::countAll($db, $withTeams);
            }
        }
    } else {
        $wrestlers = Wrestler::fetchPaginated($db, $withTeams, $itemsPerPage, $offset);
        $totalWrestlers = Wrestler::countAll($db, $withTeams);
    }

    $totalPages = ceil($totalWrestlers / $itemsPerPage);
} catch (Exception $e) {
    $_SESSION["mesgs"]["errors"][] = "Erreur base de données : " . $e->getMessage();
}