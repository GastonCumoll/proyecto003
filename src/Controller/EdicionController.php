<?php

namespace App\Controller;

use App\Entity\Edicion;
use App\Form\EdicionType;
use App\Repository\EdicionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/edicion")
 */
class EdicionController extends AbstractController
{
    /**
     * @Route("/", name="edicion_index", methods={"GET"})
     */
    public function index(EdicionRepository $edicionRepository): Response
    {
        return $this->render('edicion/index.html.twig', [
            'edicions' => $edicionRepository->findAll(),
        ]);
    }
    
    /**
     * @Route("/new", name="edicion_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
            $session=$request->getSession();
            $token=$session->get('objetoP');
        
            $edicion=new Edicion();
            $form=$this->createForm(EdicionType::class, $edicion,);
            $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($edicion);
            $entityManager->flush();
            
            return $this->redirectToRoute('edicion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('edicion/new.html.twig', [
            'edicion' => $edicion,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="edicion_show", methods={"GET"})
     */
    public function show(Edicion $edicion): Response
    {
        return $this->render('edicion/show.html.twig', [
            'edicion' => $edicion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edicion_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Edicion $edicion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EdicionType::class, $edicion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('edicion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('edicion/edit.html.twig', [
            'edicion' => $edicion,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="edicion_delete", methods={"POST"})
     */
    public function delete(Request $request, Edicion $edicion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$edicion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($edicion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('edicion_index', [], Response::HTTP_SEE_OTHER);
    }
}
