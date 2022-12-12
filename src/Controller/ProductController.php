<?php

namespace App\Controller;

use App\Data\SendEmail;
use App\Entity\User;
use App\Form\SendEmailFormType;
use App\Repository\ImageRepository;
use App\Repository\LieuxRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Service\SendMailService;
use PhpParser\Builder\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $mailer;

    public function __construct(SendMailService $sendMail)
    {
        $this->mailer = $sendMail;
    }
    #[Route('/product_page/{id}', name: 'product_page', methods:['GET' , 'POST'])]
    public function product_page(ProductRepository $repository,ImageRepository $imgRepository, $id , LieuxRepository $villeRepo, Request $request, UserRepository $userRepo): Response
    {
        $mailToSend = new SendEmail();
        $product= $repository->find($id);
        $firstImage = $imgRepository->firstImage($id);
        $secondImage = $imgRepository->secondImage($id);
        $images = $imgRepository->findBy(['product' => $id]);
        $ville = $product->getVille()->getVille();
        $departement = $product->getDepartement()->getCode();
        $region = $product->getRegion()->getName();
      
        $form = $this->createForm(SendEmailFormType::class,$mailToSend);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $this->prepareEmail($userRepo,$product, $mailToSend);
            $this->addFlash('success' , 'un message a était envoyé, un agent vous recontactera sous 48h');

            return $this->redirectToRoute('index');

        }

    
        return $this->render('product/product_page.html.twig', [
           'product' => $product,
           'firstImage' => $firstImage,
           'secondImage' => $secondImage,
           'ville' => $ville,
           'departement' => $departement,
           'region' => $region,
           'images' => $images,
           'form' => $form->createView()
        ]);
    }



    public function prepareEmail($userRepo , $product ,  $mailToSend) {

        $email = $mailToSend->getEmail();
      
        //find the creator of the product to send him the mail
        $sendTo = $product->getUserId();
        $user = $userRepo->findBy(['id' => $sendTo]);
        $sendEmailTo =  $user[0]->getEmail();
        $subject = $product->getTitle();
        $template = 'send_mail_product';
 
        $this->mailer->send($email , $sendEmailTo , $subject , $template , ['user' => $user , 'product' => $product, 'mailToSend'=> $mailToSend]);

   
    }


}
