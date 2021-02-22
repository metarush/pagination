<?php

declare(strict_types=1);

\error_reporting(E_ALL);
\ini_set('display_errors', '1');

require __DIR__ . '/../vendor/autoload.php';

use MetaRush\Pagination\Builder;

// ------------------------------------------------

$data = \file('sample-data.txt');
$currentPage = $_GET['page'] ? (int) $_GET['page'] : 1;
$path = '/demo.php?page=';
$totalItems = \count($data);
$itemsPerPage = 5;

// Uncut pagination minimum config
$pMinUncut = (new Builder)
    ->setTotalItems($totalItems)
    ->setItemsPerPage($itemsPerPage)
    ->setCurrentPage($currentPage)
    ->setPath($path)
    ->build();

// Uncut pagination display as dropdown
$pUncutDropdown = (new Builder)
    ->setTotalItems($totalItems)
    ->setItemsPerPage($itemsPerPage)
    ->setCurrentPage($currentPage)
    ->setPath($path)
    ->setPageLink('<option>{{page}}</option>')
    ->setActiveLink('<option selected="selected">{{page}}</option>')
    ->build();

// Auto cut pagination minimum config
$pMinAutoCut = (new Builder)
    ->setTotalItems($totalItems)
    ->setItemsPerPage($itemsPerPage)
    ->setCurrentPage($currentPage)
    ->setPath($path)
    ->setPagesCutoff(5)
    ->build();

// Auto cut pagination with additional settings
$pAutoCutCustom = (new Builder)
    ->setTotalItems($totalItems)
    ->setItemsPerPage($itemsPerPage)
    ->setCurrentPage($currentPage)
    ->setPath($path)
    ->setPagesCutoff(5)
    ->setPageLink('<li class="page-item"><a class="page-link" href="{{path}}{{page}}">{{page}}</a></li>')
    ->setActiveLink('<li class="page-item active"><span class="page-link">{{page}}</span></li>')
    ->setDisabledPrevLink('<li class="page-item disabled"><span class="page-link">Prev</span></li>')
    ->setDisabledNextLink('<li class="page-item disabled"><span class="page-link">Next</span></li>')
    ->setEllipsis('<li class="page-item"><span class="page-link">...</span></li>')
    ->setPrevLink('<li class="page-item"><a class="page-link" href="{{path}}{{page}}">Prev</a></li>')
    ->setNextLink('<li class="page-item"><a class="page-link" href="{{path}}{{page}}">Next</a></li>')
    ->build();

?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta2/css/bootstrap.min.css" integrity="sha512-aqT9YD5gLuLBr6ipQAS+72o5yHKzgZbGxEh6iY8lW/r6gG14e2kBTAJb8XrxzZrMOgSmDqtLaF76T0Z6YY2IHg==" crossorigin="anonymous" />
    </head>
    <body>

        <div class="container-fluid">

            <h1>metarush/pagination demo</h1>
            <hr />
            <br />

            <div class="row">

                <div class="col-8">

                    <h3>Default config</h3>
                    <br />
                    <?=$pMinUncut->prevLink() . ' ' . $pMinUncut->pageLinksUncut() . ' ' . $pMinUncut->nextLink()?>

                    <br />
                    <br />
                    <hr />
                    <br />

                    <h3>Display as dropdown</h3>
                    <br />
                    <?=$pUncutDropdown->prevLink()?>
                    <select id="myDropdown">
                        <?=$pUncutDropdown->pageLinksUncut()?>
                    </select>
                    <?=$pUncutDropdown->nextLink()?>

                    <br />
                    <br />
                    <hr />
                    <br />

                    <h3>Auto-cut pagination</h3>
                    <br />
                    <?=$pMinAutoCut->prevLink() . ' ' . $pMinAutoCut->pageLinksAutoCut() . ' ' . $pMinAutoCut->nextLink()?>

                    <br />
                    <br />
                    <hr />
                    <br />

                    <h3>Custom look</h3>
                    Use custom HTML/CSS or frameworks like Bootstrap/Materialize/etc.
                    <br />
                    <br />
                    <ul class="pagination">
                        <?=$pAutoCutCustom->prevLink() . ' ' . $pAutoCutCustom->pageLinksAutoCut() . ' ' . $pAutoCutCustom->nextLink()?>
                    </ul>

                    <br />
                    <br />
                    <br />

                </div>

                <div class="col">

                    <h2>Sample data</h2>
                    <br />

                    <?php

                    // simulate a database query
                    $chunks = \array_chunk($data, $itemsPerPage);
                    foreach ($chunks[$currentPage - 1] as $v)
                        echo $v . '<br />';

                    ?>

                </div>

            </div>

        </div>

        <script>
            // this is only needed by the dropdown menu
            document.getElementById('myDropdown').addEventListener('change', (event) => {
                location.href = `<?=$path?>${event.target.value}`;
            });
        </script>

    </body>
</html>