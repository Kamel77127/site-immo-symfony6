<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchFormType;
use App\Service\ProductService;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{



    public function __construct(private ProductRepository $productRepository, private ProductService $productService , private PaginatorInterface $paginator)
    {}



    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $data = new SearchData;
        $form = $this->createForm(SearchFormType::class, $data);

        $data = new SearchData;
        $form = $this->createForm(SearchFormType::class, $data);
     
        if ($request->get('ajax')) {
            if ($request->get('cookie') == 'accepted') {
                setcookie('cookies', 'true', time() + 60 * 60 * 30, '/');
            } else if ($request->get('cookie') == 'rejected') {
                setcookie('cookies', 'false', null, '/');
            }
        }
        $form->handleRequest($request);
     
        if ($form->isSubmitted()) {
     
     
            return $this->recherche($data , $request);
        }
     
        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }




    #[Route('/recherche', name: 'recherche', methods: ['GET'])]
    public function recherche($data, $request): Response
    {

     
        $query = $this->productRepository->findSearch($data);

        $products = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            8
        );
        
        return $this->render('index/recherche.html.twig', [
            'products' => $products,


        ]);
    }
}
