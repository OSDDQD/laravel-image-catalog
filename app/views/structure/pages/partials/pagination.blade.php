<?php
$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>

@if ($paginator->getLastPage() > 1)
    <div class="pagination">
        {{ getFirst($paginator->getCurrentPage(), $paginator->getUrl(1)) }}
        {{ getPrevious($paginator->getCurrentPage(), $paginator->getUrl($paginator->getCurrentPage() - 1)) }}
        <nav>
            {{ getRange($paginator, 3) }}
        </nav>
        {{ getNext($paginator->getCurrentPage(), $paginator->getLastPage(), $paginator->getUrl($paginator->getCurrentPage() + 1)) }}
        {{ getLast($paginator->getCurrentPage(), $paginator->getLastPage(), $paginator->getUrl($paginator->getLastPage())) }}
    </div>
@endif

<?php
function getFirst($currentPage, $url) {
    if ($currentPage <= 1)
        return '<a href="javascript:void(0);" class="disabled">&#8612;</a>';
    else
        return '<a href="' . $url . '">&#8612;</a>';
}

function getPrevious($currentPage, $url)
{
    if ($currentPage <= 1)
        return '<a href="javascript:void(0);" class="disabled">&larr;</a>';
    else
       return '<a href="' . $url . '">&larr;</a>';
}

function getRange($paginator, $maxPages) {
    $currentPage = $paginator->getCurrentPage();
    $prevPage = $currentPage - 1;
    $nextPage = $currentPage + 1;
    $lastPage = $paginator->getLastPage();

    $pages = [];
    $pages[$currentPage] = '<a href="' . $paginator->getUrl($currentPage) . '" class="current">' . $currentPage . '</a>';
    while(count($pages) < $maxPages) {
        $bool = isset($bool) ? !$bool : true;
        if ($prevPage < 1 and $nextPage > $lastPage)
            break;
        if ($bool and $prevPage > 0)
            $pages[$prevPage] = '<a href="' . $paginator->getUrl($prevPage) . '">' . $prevPage-- . '</a>';
        elseif($nextPage <= $lastPage)
            $pages[$nextPage] = '<a href="' . $paginator->getUrl($nextPage) . '">' . $nextPage++ . '</a>';
    }
    ksort($pages);
    return implode('', $pages);
}

function getNext($currentPage, $lastPage, $url) {
    if ($currentPage >= $lastPage)
        return '<a href="javascript:void(0);" class="disabled">&rarr;</a>';
    else
        return '<a href="' . $url . '" class="navA3">&rarr;</a>';
}

function getLast($currentPage, $lastPage, $url) {
    if ($currentPage >= $lastPage)
        return '<a href="javascript:void(0);" class="disabled">&#8614;</a>';
    else
        return '<a href="' . $url . '" class="navA4">&#8614;</a>';
}
?>