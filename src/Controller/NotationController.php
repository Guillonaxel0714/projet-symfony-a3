<?php

namespace App\Controller;

use App\Entity\Notation;
use App\Form\NotationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotationController extends AbstractController
{
    /**
     * @Route("/notation", name="notation")
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $notation = new Notation();
        $form = $this->createForm(NotationType::class, $notation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em->persist($notation);
            $em->flush();

            $this->addFlash('success', 'Notation ajoutée');
        }
    
        $notations = $em->getRepository(Notation::class)->findAll();

        return $this->render('notation/index.html.twig', [
            'notations' => $notations,
            'ajout' => $form->createView()
        ]);
    }

    /**
     * @Route("/notation/{id}", name="show_notation")
     */
    public function show(Notation $notation = null){
        if($notation == null){
            $this->addFlash('error', 'notation introuvable');
            return $this->redirectToRoute('notation');
        }

        return $this->render('notation/show.html.twig', [
            'notation' => $notation
        ]);
    }

    /**
     * @Route("/notation/delete/{id}", name="delete")
     */
    public function delete(Notation $notation = null){
        if($notation == null){
            $this->addFlash(
                'erreur',
                'Notation introuvable'
            );
            return $this->redirectToRoute('notation');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($notation);
        $em->flush();

        $this->addFlash(
            'success',
            'notation supprimé'
        );

        return $this->redirectToRoute('notation');

    }
}

