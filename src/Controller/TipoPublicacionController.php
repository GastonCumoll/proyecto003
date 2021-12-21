<?php

namespace App\Controller;

use App\Entity\TipoPublicacion;
use App\Form\TipoPublicacionType;
use App\Repository\TipoPublicacionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tipo/publicacion")
 */
class TipoPublicacionController extends AbstractController
{
    /**
     * @Route("/", name="tipo_publicacion_index", methods={"GET"})
     */
    public function index(TipoPublicacionRepository $tipoPublicacionRepository): Response
    {
        return $this->render('tipo_publicacion/index.html.twig', [
            'tipo_publicacions' => $tipoPublicacionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tipo_publicacion_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tipoPublicacion = new TipoPublicacion();
        $form = $this->createForm(TipoPublicacionType::class, $tipoPublicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tipoPublicacion);
            $entityManager->flush();

            return $this->redirectToRoute('tipo_publicacion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tipo_publicacion/new.html.twig', [
            'tipo_publicacion' => $tipoPublicacion,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="tipo_publicacion_show", methods={"GET"})
     */
    public function show(TipoPublicacion $tipoPublicacion): Response
    {
        return $this->render('tipo_publicacion/show.html.twig', [
            'tipo_publicacion' => $tipoPublicacion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipo_publicacion_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TipoPublicacion $tipoPublicacion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TipoPublicacionType::class, $tipoPublicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('tipo_publicacion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tipo_publicacion/edit.html.twig', [
            'tipo_publicacion' => $tipoPublicacion,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="tipo_publicacion_delete", methods={"POST"})
     */
    public function delete(Request $request, TipoPublicacion $tipoPublicacion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tipoPublicacion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tipoPublicacion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tipo_publicacion_index', [], Response::HTTP_SEE_OTHER);
    }
}
