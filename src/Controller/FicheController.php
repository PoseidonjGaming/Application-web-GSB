<?php

namespace App\Controller;

use App\Entity\Fiche;
use App\Entity\Forfait;
use App\Entity\HorsForfait;
use App\Entity\TypeFrais;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\ForfaitFormType;
use App\Form\HorsForfaitFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FicheController extends AbstractController
{
    /**
     * @Route("/fiche/", name="creaFiche")
     */
    public function creation(Request $request): Response
    {
        $laFiche=new Fiche();
        

        for ($i = 1; $i = 4; $i++)
        {
            $forfait= new Forfait();
            $repositoryT = $this->getDoctrine()->getRepository(TypeFrais::class);
            $leType = $repositoryT->find($i);
            $forfait->setIdType($leType);
            
        }
        dump($laFiche);
        $laFiche->addLesForfait($forfait);
        $form = $this->createForm(FicheFormType::class,$laFiche);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid())
        {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
            $this->redirectToRoute("menu");
        }
        
        return $this->render('fiche/modifFiche.html.twig',
        [' 
            form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/fiche/{id_Fiche}", name="modFiche")
     */
    public function modifier($id_Fiche,Request $request): Response
    {
        // On cherche la fiche

        $repositoryF = $this->getDoctrine()->getRepository(Fiche::class);
        $laFiche = $repositoryF->find($id_Fiche);

        // On cherche les frais forfaitaires

        $repositoryFo = $this->getDoctrine()->getRepository(Forfait::class);
        $lesForfaits = $repositoryFo->findForfaitByFiche($id_Fiche);
        


        // On cherche les frais hors forfaitaires



        $repositoryH = $this->getDoctrine()->getRepository(HorsForfait::class);
        $lesHorsForfaits = $repositoryH->findHForfaitByFiche($id_Fiche);

        
        // On cherche les type de frais

        $repositoryT = $this->getDoctrine()->getRepository(TypeFrais::class);
        $lesTypes = $repositoryT->findAll();

        // Formulaire des Forfaits

        $formF = $this->createForm(ForfaitFormType::class, ['forfaits' => $lesForfaits]);
        $formF->handleRequest($request);
        if ($formF->isSubmitted() and $formF->isValid())
        {
            $dataF = $formF->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($dataF);
            $em->flush();
            $this->redirectToRoute("menu");
        }


        // Formulaire des  Hors Forfaits

        
        $formH = $this->createForm(HorsForfaitFormType::class);
        $formH->handleRequest($request, $id_Fiche);
        if ($formH->isSubmitted() and $formH->isValid())
        {
            $dataH = $formH->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($dataH);
            $em->flush();
            $this->redirectToRoute("menu");
        }
        
        // Render

        return $this->render('fiche/modifFiche.html.twig',
        ['formF' => $formF->createView(),
        'formH' => $formH->createView(),
        'fiche' => $laFiche,
        'lesHorsForfait' => $lesHorsForfaits ,
        'lesForfaits' => $lesForfaits,
        'types' => $lesTypes,
        ]);
    }


    /**
     * @Route("/fiche/forfait/{id_Fiche}", name="modifForfait")
     */
    public function modifierForfait($id_Fiche,Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Fiche::class);
        $laFiche = $repository->find($id_Fiche);
        $repository = $this->getDoctrine()->getRepository(Forfait::class);
        $lesForfaits = $repository->findForfaitByFiche($id_Fiche);

        $form = $this->createForm(ForfaitFormType::class,$id_Fiche);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid())
        {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
            $this->redirectToRoute("menu");
        }
        return $this->render('fiche/modifForfait.html.twig',['form' => $form->createView(),'fiche' => $laFiche,'lesForfaits' => $lesForfaits]);
    }
    /**
     * @Route("/fiche/Hforfait/{id_Fiche}", name="modifForfait")
     */
    public function modifierHorsForfait($id_Fiche,Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Fiche::class);
        $laFiche = $repository->find($id_Fiche);
        $repository = $this->getDoctrine()->getRepository(HorsForfait::class);
        $lesHorsForfaits = $repository->findHForfaitByFiche($id_Fiche);

        $form = $this->createForm(ForfaitFormType::class,$id_Fiche);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid())
        {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
            $this->redirectToRoute("menu");
        }
        return $this->render('fiche/modifHorsForfait.html.twig',['form' => $form->createView(),'fiche' => $laFiche,'lesForfaits' => $lesHorsForfaits]);
    }
}
