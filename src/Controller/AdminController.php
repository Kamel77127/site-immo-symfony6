<?php

namespace App\Controller;

use App\Entity\Image;
use DateTime;
use App\Entity\Lieux;
use App\Entity\Region;
use App\Entity\Product;
use App\Form\ProductFormType;
use App\Repository\ImageRepository;
use App\Repository\LieuxRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class AdminController extends AbstractController
{



    #[Route('/admin/create_product', name: 'create_product', methods: ['POST', 'GET'])]
    public function createProduct(EntityManagerInterface $em, SluggerInterface $slugger, Request $request, LieuxRepository $villeRepo, SerializerInterface $serializer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $product = new Product;
        $ville = new Lieux;
        $form = $this->createForm(ProductFormType::class, $product);
        $list = $villeRepo->findAll();




        ////////// partie recherche ajax
        $query = $request->get('text');
        // if ($request->get('ajax')) {

        //     return $this->json(
        //         json_decode(
        //             $serializer->serialize(
        //                 $villeRepo->handleSearch($query),
        //                 'json',
        //                 [AbstractNormalizer::IGNORED_ATTRIBUTES => ['region', 'departement', 'products']]
        //             ),
        //             JSON_OBJECT_AS_ARRAY
        //         )
        //     );
        // } ///////              fin

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product->setCreatedat(new DateTime());
            $product->setUpdatedAt(new DateTime());
            $product->setUserId($this->getUser());

            $em->persist($product);
            foreach ($form->get('image') as $key) {

                $img = new Image;
                $img->setCreatedAt(new DateTime());
                $img->setUpdatedAt(new DateTime());
                $formData = $key->get('name')->getData();

                $image = $this->handleFile($formData[0], $slugger);

                $img->setName($image);
                $product->addImage($img);
                $em->persist($img);

            }


            $em->flush();
        }

        return $this->render(
            'admin/create_product.html.twig',
            ['form' => $form->createView(),
              ]
        );
    }



    public function handleFile($file, $slugger)
    {

        $extension = "." . $file->guessExtension();
        $originalFileName = $slugger->slug($file->getClientOriginalName());
        $newFileName = $originalFileName . uniqid() . $extension;

        try {
            $file->move($this->getParameter('uploads_directory'), $newFileName);
        } catch (FileException $th) {
            //throw $th;
        }

        return $newFileName;
    }







    #[Route('/admin/show_product', name: 'show_product')]
    public function show_product(ProductRepository $productRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
      $products = $productRepository->findBy(['deletedAt' => null]);

        
      

   
        return $this->render('admin/show_product.html.twig', [
            'products' => $products,
        ]);
      
       
    }



#[Route('/admin/update_product/{id}', name:'update_product', methods:['GET'])]
public function update_product(
ProductRepository $productRepo , $id , 
LieuxRepository $villeRepo, Request $request, 
EntityManagerInterface $em, 
SluggerInterface $slugger,
ImageRepository $imageRepo

):Response
{
 

    $this->denyAccessUnlessGranted('ROLE_ADMIN');
    $product = $productRepo->find($id);
    $ville = new Lieux;
    $form = $this->createForm(ProductFormType::class, $product);
    $list = $villeRepo->findAll();




    ////////// partie recherche ajax
    $query = $request->get('text');
    // if ($request->get('ajax')) {

    //     return $this->json(
    //         json_decode(
    //             $serializer->serialize(
    //                 $villeRepo->handleSearch($query),
    //                 'json',
    //                 [AbstractNormalizer::IGNORED_ATTRIBUTES => ['region', 'departement', 'products']]
    //             ),
    //             JSON_OBJECT_AS_ARRAY
    //         )
    //     );
    // } ///////              fin

    if($request->get('ajax'))
    {
        $imageId =(int)$request->get('idImage');
        $image = $imageRepo->find($imageId);
        if ($image){
            // Pour supprimer un fichier dans le système, on utilise la fonction native de PHP unlink().
            unlink($this->getParameter('uploads_directory') . '/' . $image->getName());
        }
        $imageRepo->remove($image , true);

    }
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $product->setCreatedat(new DateTime());
        $product->setUpdatedAt(new DateTime());
        $product->setUserId($this->getUser());

        $em->persist($product);
        foreach ($form->get('image') as $key) {

            $img = new Image;
            $img->setCreatedAt(new DateTime());
            $img->setUpdatedAt(new DateTime());
            $formData = $key->get('name')->getData();

            $image = $this->handleFile($formData[0], $slugger);

            $img->setName($image);
            $product->addImage($img);
            $em->persist($img);

        }


        $em->flush();
    }

    return $this->render(
        'admin/update_product.html.twig',
        ['form' => $form->createView(),
        'product' => $product
          ]
    );


}




    #[Route('/admin/archived_product', name: 'archived_product', methods: ['GET'])]
    public function archived_product(ProductRepository $productRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $product = $productRepository->findArchived();
        return $this->render('admin/archived_product.html.twig', [
            'product' => $product,
        ]);
    }



    #[Route('/admin/delete_product/{id}', name: 'delete_product', methods: ['GET'])]
    public function deleteProduct(ProductRepository $productRepo, Product $product): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $product->setDeletedAt(new DateTime());
        $productRepo->add($product, true);

        $this->addFlash('success', 'votre produit a bien était archivé');
        return $this->redirectToRoute('show_product');
    }

}

