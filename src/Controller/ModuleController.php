<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ModuleController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, TranslatorInterface $trans): Response
    {
        $em = $this->getDoctrine()->getManager(); // accès à la bdd

        $module = new Module(); // objet vide
        $form = $this->createForm(ModuleType::class, $module); // Nouveau formulaire
        $form->handleRequest($request); // Analyse la requete HTTP
        if($form->isSubmitted() && $form->isValid()){ // Si le formulaire a été soumis et qu'il est valide
            $em->persist($module); // prépare la sauvegarde en base
            $em->flush(); // execute la sauvegarde

            $this->addFlash(
                'success',
                $trans->trans('module.ajoutee')
            );
        }

        $modules = $em->getRepository(Module::class)->findAll();

        return $this->render('module/index.html.twig', [
            'modules' => $modules,
            'ajout' => $form->createView(),
        ]);
    }

    /**
     * @Route("/module/{id}", name="show")
     */
    public function show(Module $module = null, Request $request){
        if($module == null){
            // Il n'a pas trouvé de module
            $this->addFlash(
                'erreur',
                'Module introuvable'
            );
            return $this->redirectToRoute('module');
        }

        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($module);
            $em->flush();

            $this->addFlash('success', 'Module modifiée');
        }

        return $this->render('module/show.html.twig', [
            'module' => $module,
            'maj' => $form->createView()
        ]);
    }

}
