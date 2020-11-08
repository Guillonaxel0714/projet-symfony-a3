<?php

namespace App\Controller;

use App\Entity\Semaine;
use App\Form\SemaineType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SemaineController extends AbstractController
{
    /**
     * @Route("/semaine", name="semaine")
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $semaine = new Semaine();
        $form = $this->createForm(SemaineType::class, $semaine);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em->persist($semaine);
            $em->flush();

            $this->addFlash('success', 'Semaine ajoutée');
        }
    
        $semaines = $em->getRepository(Semaine::class)->findAll();

        return $this->render('semaine/index.html.twig', [
            'semaines' => $semaines,
            'ajout' => $form->createView()
        ]);
    }

    /**
     * @Route("/semaine/{id}", name="show_semaine")
     */
    public function show(Semaine $semaine = null){
        if($semaine == null){
            $this->addFlash('error', 'semaine introuvable');
            return $this->redirectToRoute('semaine');
        }

        return $this->render('semaine/show.html.twig', [
            'semaine' => $semaine
        ]);
    }
}

