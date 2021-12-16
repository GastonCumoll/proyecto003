<?php

namespace App\Controller;

use App\Entity\Suscripcion;
use App\Form\SuscripcionType;
use App\Repository\SuscripcionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/suscripcion")
 */
class SuscripcionController extends AbstractController
{
    /**
     * @Route("/", name="suscripcion_index", methods={"GET"})
     */
    public function index(SuscripcionRepository $suscripcionRepository): Response
    {
        return $this->render('suscripcion/index.html.twig', [
            'suscripcions' => $suscripcionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="suscripcion_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $suscripcion = new Suscripcion();
        $form = $this->createForm(SuscripcionType::class, $suscripcion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($suscripcion);
            $entityManager->flush();

            return $this->redirectToRoute('suscripcion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('suscripcion/new.html.twig', [
            'suscripcion' => $suscripcion,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="suscripcion_show", methods={"GET"})
     */
    public function show(Suscripcion $suscripcion): Response
    {
        return $this->render('suscripcion/show.html.twig', [
            'suscripcion' => $suscripcion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="suscripcion_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Suscripcion $suscripcion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SuscripcionType::class, $suscripcion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('suscripcion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('suscripcion/edit.html.twig', [
            'suscripcion' => $suscripcion,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="suscripcion_delete", methods={"POST"})
     */
    public function delete(Request $request, Suscripcion $suscripcion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$suscripcion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($suscripcion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('suscripcion_index', [], Response::HTTP_SEE_OTHER);
    }
}
