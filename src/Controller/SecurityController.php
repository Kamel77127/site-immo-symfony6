<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Service\JwtService;
use App\Form\RegisterFormType;
use App\Service\SendMailService;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class SecurityController extends AbstractController
{

    // ///////////////////////////////////////////     REGISTER            PART


    #[Route('/inscription', name: 'register', methods: ['GET', 'POST'])]
    public function register(Request $request, UserPasswordHasherInterface $hashPassword, UserRepository $userRepo, SendMailService $mail, JwtService $jwt): Response
    {

        $user = new User;
        $form = $this->createForm(RegisterFormType::class, $user);
        $form->handleRequest($request);

    
        if ($form->isSubmitted() && $form->isValid()) {

            
            $email = $form->get('email')->getData();
            if($userRepo->findBy(['email' => $email] ))
            {
                $this->addFlash('danger' , 'Le mail est déjà utilisé');
              return $this->redirectToRoute('register');
            }else{
              
                 
            $user->setCreatedAt(new DateTime());
            $user->setUpdatedAt(new DateTime());
            $user->setRoles(['ROLE_USER']);
            $password = $form->get('password')->getData();
            $user->setPassword($hashPassword->hashPassword($user, $password));
            $userRepo->add($user, true);

            

            }
           

            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];
    
            $payload = [
                'user_id' => $user->getId()
            ];
    
            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));
    
      
            $mail->send(
                'no-reply@monsite.fr',
                 $user->getEmail(),
                'Action de votre compte',
                'confirmation_email',
                compact('user', 'token')
            );

            $this->addFlash('success', 'Le compte a bien était créée');
            return $this->redirectToRoute('register');
        }
        
        /////// envoi de mail pour la vérification
    

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/verification/{token}', name:'verify_user')]
    public function verifyUser($token, JwtService $jwt, UserRepository $userRepository, EntityManagerInterface $em):Response{

        if($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret')));
        {
            $payload = $jwt->getPayload($token);
            $user = $userRepository->find($payload['user_id']);

            if($user && !$user->isIsVerified()){
                $user->setIsverified(true);
                $em->persist($user);
                $em->flush();
                $this->addFlash('success' , 'utilisateur activé');

                return $this->redirectToRoute('index');
            }
        }
        $this->addFlash('danger' , 'le token est invalide ou a expiré');
        return $this->redirectToRoute('index');
    }



    #[Route('resendverif', name:'resend_verif')]
    public function resendVerif(User $user, JwtService $jwt, SendMailService $mail, UserRepository $userRepo): Response{

      $anon=$user->getEmail();
        if(!$anon) {
            $this->addFlash('danger', 'vous devez être connecté');
            return $this->redirectToRoute('index');
        }

        if($user->isIsverified()){
            $this->addFlash('warning', 'cette utilisateur est déjà activé');
            return $this->redirectToRoute('index');
        }

        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        $payload = [
            'user_id' => $user->getId()
        ];

        $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

        $mail->send(
            'no-reply@monsite.fr',
            $user->getEmail(),
            'Action de votre compte',
            'confirmation_email',
            compact('user', $token)
        );

        $this->addFlash('success', 'un e-mail a été renvoyé');
        return $this->redirectToRoute('index');

    }
    ////////////////////////////////// LOGIN                         PART







    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils , Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('index');
        }
      
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
