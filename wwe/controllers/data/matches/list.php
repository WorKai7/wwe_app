<?php
include __DIR__.'/../../../class/wrestling_match.class.php';

$title = "Matches";
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
            $matches = WrestlingMatch::findWithPaginationWithOffset($db, $filters, $itemsPerPage, $offset);
            $totalMatches = WrestlingMatch::countWithFilters($db, $filters);
        } else {
            if (!empty($filters)) {
                $matches = WrestlingMatch::findWithPagination($db, $filters, $itemsPerPage, $offset);
                $totalMatches = WrestlingMatch::countWithFilters($db, $filters);
            } else {
                $matches = WrestlingMatch::fetchPaginated($db, $itemsPerPage, $offset);
                $totalMatches = WrestlingMatch::countAll($db);
            }
        }

    } else {
        $matches = WrestlingMatch::fetchPaginated($db, $itemsPerPage, $offset);
        $totalMatches = WrestlingMatch::countAll($db);
    }
    
    $totalPages = ceil($totalMatches / $itemsPerPage);
} catch (Exception $e) {
    $_SESSION["mesgs"]["errors"][] = "Erreur base de données : " . $e->getMessage();
}