<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    /**
     * @Route("/module", name="module")
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager(); //Recuperation de la doctrine

        $module = new Module();
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request); //analyse la requete http
        if($form->isSubmitted() && $form->isvalid()) {
            $em->persist($module); //preparer la sauvegarde
            $em->flush(); //executer la sauvegarde
        }

        $modules = $em->getRepository(Module::class)->findAll();

        return $this->render('module/index.html.twig', [
            'modules' => $modules,
            'ajout' => $form->createView()
        ]);
    }
}
