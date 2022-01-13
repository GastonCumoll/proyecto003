<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();


        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
    
    
    /**
     * @Route("/logedIn", name="loged_in")
     */
    public function logedIn(AuthenticationUtils $authenticationUtils,Request $request):Response{
        $lastUsername = $authenticationUtils->getLastUsername();

        $repository=$this->getDoctrine()->getRepository(User::class);
        $min = $repository->findOneBy(['email'=>$lastUsername]); 
        $session=$request->getSession();
        $session->set('name',$lastUsername);
        $session->set('id',$min->getId());
        
        

        
        //dd($min);
        // $nombre = $this->getDoctrine()->getRepository(Usuario::class);
        // $usuario=$nombre-findBy(array('email'=>$lastUsername));
        $paginaActiva=1;

        return $this->render('login/logedIn.html.twig', [
            'user' => $lastUsername,
            'usuario' =>$min,
            'paginaActiva' => $paginaActiva,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): response
    {
        return $this->render('login/index.html.twig', [
        ]);
    }
}

?>