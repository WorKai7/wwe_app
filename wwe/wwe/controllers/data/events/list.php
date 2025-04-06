<?php
include __DIR__.'/../../../class/event.class.php';

$title = "Évènements";

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
            $events = Event::findWithPagination($db, $filters, $itemsPerPage, $offset);
            $totalEvents = Event::countWithFilters($db, $filters);
        } else {
            if (!empty($filters)) {
                $events = Event::findWithPagination($db, $filters, $itemsPerPage, $offset);
                $totalEvents = Event::countWithFilters($db, $filters);
            } else {
                $events = Event::fetchPaginated($db, $itemsPerPage, $offset);
                $totalEvents = Event::countAll($db);
            }
        }
    } else {
        $events = Event::fetchPaginated($db, $itemsPerPage, $offset);
        $totalEvents = Event::countAll($db);
    }

    $totalPages = ceil($totalEvents / $itemsPerPage);
} catch (Exception $e) {
    $_SESSION["mesgs"]["errors"][] = "Erreur base de données : " . $e->getMessage();
}