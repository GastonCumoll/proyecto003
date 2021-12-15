<?php

namespace App\Controller;

use App\Entity\Publicacion;
use App\Form\PublicacionType;
use App\Repository\PublicacionRepository;
use App\Entity\Edicion;
use App\Form\EdicionType;
use App\Repository\EdicionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
/**
 * @Route("/publicacion")
 */
class PublicacionController extends AbstractController
{
    /**
     * @Route("/", name="publicacion_index", methods={"GET"})
     */
    public function index(PublicacionRepository $publicacionRepository): Response
    {
        return $this->render('publicacion/index.html.twig', [
            'publicacions' => $publicacionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="publicacion_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = new Session(new NativeSessionStorage(), new AttributeBag());
        

        
        $publicacion = new Publicacion();
        $form = $this->createForm(PublicacionType::class, $publicacion,);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            //dd($publicacion);
            //dd($form->get('cantidadImpresiones')->getData()); //atributo no mapeado (cant impresiones);
            $edicion= new Edicion();
            $edicion->setFechaDeEdicion($publicacion->getFechaYHora());
            $edicion->setFechaYHoraCreacion($publicacion->getFechaYHora());
            $edicion->setUsuarioCreador($publicacion->getUsuarioCreador());
            $edicion->setCantidadImpresiones($form->get('cantidadImpresiones')->getData());
            $edicion->setPublicacion($publicacion);

            $entityManager->persist($publicacion);
            $entityManager->persist($edicion);
            $entityManager->flush();
            //$id=$publicacion->getId();
            

            

            return $this->redirectToRoute('publicacion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('publicacion/new.html.twig', [
            'publicacion' => $publicacion,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="publicacion_show", methods={"GET"})
     */
    public function show(Publicacion $publicacion): Response
    {
        return $this->render('publicacion/show.html.twig', [
            'publicacion' => $publicacion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="publicacion_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Publicacion $publicacion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PublicacionType::class, $publicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('publicacion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('publicacion/edit.html.twig', [
            'publicacion' => $publicacion,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="publicacion_delete", methods={"POST"})
     */
    public function delete(Request $request, Publicacion $publicacion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicacion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($publicacion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('publicacion_index', [], Response::HTTP_SEE_OTHER);
    }
}
