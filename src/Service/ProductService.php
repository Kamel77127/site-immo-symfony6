<?php

namespace App\Service;

use App\Data\SearchData;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;


class ProductService
{

public function __construct(
private RequestStack $requestStack,
private ProductRepository $productRepository,
private PaginatorInterface $paginator
)
{
    
}


public function getPaginatedProduct(SearchData $data)
{
$request = $this->requestStack->getMainRequest();
$page = $request->query->getInt('page', 1);
$limit = 8;
$productQuery = $this->productRepository->findSearch($data);

return $this->paginator->paginate($productQuery, $page, $limit);
}





}