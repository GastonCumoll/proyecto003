<?php

namespace App\Controller;

use DateTime;
use DateTimeInterface;
use App\Entity\Publicacion;
use App\Entity\Suscripcion;
use App\Form\SuscripcionType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PublicacionRepository;
use App\Repository\SuscripcionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/{id}, newsuscripcion", name="nueva_suscripcion", methods={"GET", "POST"})
     */
    public function newSuscripcion(SuscripcionRepository $suscripcionRepository,PublicacionRepository $publicacionRepository, Request $request, EntityManagerInterface $entityManager,$id): Response
    {
        $suscripcion=new Suscripcion();
        $publicacion=$this->getDoctrine()->getRepository(Publicacion::class)->findOneBy(['id'=>$id]);

        $today=new DateTime();
        $suscripcion->setTipo($publicacion->getTipoPublicacion());
        $suscripcion->setFechaSuscripcion($today);
        $suscripcion->setUsuario($publicacion->getUsuarioCreador());
        $suscripcion->setPublicacion($publicacion);

        $entityManager->persist($suscripcion);
        $entityManager->flush();



        return $this->renderForm('suscripcion/index.html.twig', [
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
