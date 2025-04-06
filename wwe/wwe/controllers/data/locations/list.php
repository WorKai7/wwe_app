<?php
include __DIR__.'/../../../class/location.class.php';

$title = "Lieux";

// Paramètres de pagination et filtres
$itemsPerPage = 20; 
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $itemsPerPage;
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
            $locations = Location::findWithPagination($db, $filters, $itemsPerPage, $offset);
            $totalLocations = Location::countWithFilters($db, $filters);
        } else {
            if (!empty($filters)) {
                $locations = Location::findWithPagination($db, $filters, $itemsPerPage, $offset);
                $totalLocations = Location::countWithFilters($db, $filters);
            } else {
                $locations = Location::fetchPaginated($db, $itemsPerPage, $offset);
                $totalLocations = Location::countAll($db);
            }
        }
    } else {
        $locations = Location::fetchPaginated($db, $itemsPerPage, $offset);
        $totalLocations = Location::countAll($db);
    }

    $totalPages = ceil($totalLocations / $itemsPerPage);
} catch (Exception $e) {
    $_SESSION["mesgs"]["errors"][] = "Erreur base de données : " . $e->getMessage();
}