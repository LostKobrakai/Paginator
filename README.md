# Paginator

This is mostly meant to allow for multiple selectors to be paginated in processwire, but feel free to repurpose it to other use-cases.

```php
include 'src/Paginator.php';
include 'src/PagesPaginator.php';

$paginator = new PagesPaginator();

$result = $paginator(array(
	'template=basic-page',
	'template=post'
), $input->pageNum, 15);
```

**Disclaimer**

Only the base class is currently tested :)