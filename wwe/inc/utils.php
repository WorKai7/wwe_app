<?php
function buildPaginatedUrl($page, $currentParams) {
    $params = $currentParams;
    $params['page'] = $page;
    return '?' . http_build_query($params);
}
?>