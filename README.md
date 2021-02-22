# metarush/pagination

Standalone pagination module that is not tied to any frameworks

## Install

Install via composer as `metarush/pagination`

## Sample usage

```php
use MetaRush\Pagination\Builder;

// define minimum required vars

$currentPage = $_GET['page'] ? (int) $_GET['page'] : 1;
$path = '/demo.php?page=';
$totalItems = 50;
$itemsPerPage = 5;
```

### Default config

```php
$p = (new Builder)
    ->setTotalItems($totalItems)
    ->setItemsPerPage($itemsPerPage)
    ->setCurrentPage($currentPage)
    ->setPath($path)
    ->build();
```

Display:

```php
echo $p->prevLink() . ' ' . $p->pageLinksUncut() . ' ' . $p->nextLink();
```

![default config screenshot](public/screenshots/default-config.png?raw=true)

### Display as dropdown

Remove `->build();` from previous example then append the ff.

```php
    ->setPageLink('<option>{{page}}</option>')
    ->setActiveLink('<option selected="selected">{{page}}</option>')
    ->build();
```

Note: You need the ff. sample Javascript code for the dropdown to work

```js
<script>
    document.getElementById('myDropdown').addEventListener('change', (event) => {
        location.href = `<?=$path?>${event.target.value}`;
    });
</script>
```

Display:

```php
echo $p->prevLink() . ' <select id="myDropdown">' . $p->pageLinksUncut() . '</select> ' . $p->nextLink();
```

![display as dropdown screenshot](public/screenshots/display-as-dropdown.png?raw=true)

### Auto-cut pagination

Remove `->setPageLink()`, `->setActiveLink()`, and `->build();` from previous example then append the ff.

```php
    ->setPagesCutoff(5) // Estimated max number of page links to display (default: 7)
    ->build();
```

Display:

```php
echo $p->prevLink() . ' ' . $p->pageLinksAutoCut() . ' ' . $p->nextLink();
```

![auto-cut pagination screenshot](public/screenshots/auto-cut-pagination.png?raw=true)

### Custom look

Use custom HTML/CSS or frameworks like Bootstrap/Materialize/etc.

Remove `->build();` from previous example then append the ff.

```php
    ->setPageLink('<li class="page-item"><a class="page-link" href="{{path}}{{page}}">{{page}}</a></li>')
    ->setActiveLink('<li class="page-item active"><span class="page-link">{{page}}</span></li>')
    ->setDisabledPrevLink('<li class="page-item disabled"><span class="page-link">Prev</span></li>')
    ->setDisabledNextLink('<li class="page-item disabled"><span class="page-link">Next</span></li>')
    ->setEllipsis('<li class="page-item"><span class="page-link">...</span></li>')
    ->setPrevLink('<li class="page-item"><a class="page-link" href="{{path}}{{page}}">Prev</a></li>')
    ->setNextLink('<li class="page-item"><a class="page-link" href="{{path}}{{page}}">Next</a></li>')
    ->build();
```

Display:

```php
echo '<ul class="pagination">' . $p->prevLink() . ' ' . $p->pageLinksAutoCut() . ' ' . $p->nextLink().' </ul>';
```

![custom look screenshot](public/screenshots/custom-look.png?raw=true)

## Querying data from database

Code for querying of data from a database is intentionally not included in this module.
This is best implemented in userland. Below are examples on how to do this:

First, determine `$limit` and `$offset`

```php
$limit = $itemsPerPage;
$offset = ($itemsPerPage * $currentPage) - $itemsPerPage;
```

### Raw SQL

```php
$sql = "SELECT * FROM your_table LIMIT $limit OFFSET $offset";
````

### Laravel query builder

```php
$result = DB::table('your_table')
            ->offset($offset)
            ->limit($limit)
            ->get();
```

### Doctrine DBAL query builder
```php
$queryBuilder
    ->select('*')
    ->from('your_table')
    ->setFirstResult($offset)
    ->setMaxResults($limit);
```

## Working demo

Check the demo in `public/demo.php`