<?php

namespace App\Controller;

use App\Entity\Visiteur;
use App\Entity\Fiche;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/login/mobile/{login}/{mdp}", name="connexion")
     */
    public function connexionMobile($login, $mdp, UserPasswordEncoderInterface $encoder): JsonResponse
    {
        $fiche=[];
      
        $visiteur=$this->getDoctrine()->getRepository(Visiteur::class)->findOneByUsername($login);
        if($encoder->isPasswordValid($visiteur, $mdp)){
            $fiche[]=[
                "id"=>$visiteur->getId(),
                "nom"=>$visiteur->getNom(),
                "prenom"=>$visiteur->getPrenom(),
                "login"=>$visiteur->getusername(),
                "mdp"=>$visiteur->getPassword(),
                "adresse"=>$visiteur->getAdresse(),
                "cp"=>$visiteur->getCp(),
                "ville"=>$visiteur->getVille()

        ];
            return new JsonResponse($fiche, Response::HTTP_OK);
        }
        return new JsonResponse($fiche, Response::HTTP_OK);
    }
    /** 
     * @Route("/login/AjouterCompte", name="ajouterCompte")
     **/
    public function addCompte(Request $request): Response
    { 
	    $entityManager = $this->getDoctrine()->getManager();
        $compte = new Visiteur();
        
        $encoded = password_hash("P@ssw0rd",PASSWORD_BCRYPT);
        $compte->setPassword($encoded);
        $compte->setUsername("DeGaulle1");
	    $entityManager->persist($compte);
        $entityManager->flush(); 
        dump($compte);
        //return $this->redirectToRoute('app_login');
        return $this->render('test.html.twig');
    }

    /**
     * @Route("/menu/{id}", name="menu")
     */
    public function menu($id): Response
    {
        // On cherche le visiteur
        $repositoryVis = $this->getDoctrine()->getRepository(Visiteur::class);
        $visiteur = $repositoryVis->findOneByUsername($id);

        //Appel de la fonction pour trouver le mois en cours en Francais
        $mois=$this->getNameMonth();

        //Collection de fiches du visiteur
        $fiches = $visiteur->getFiches();

        //
        $repositoryFiche = $this->getDoctrine()->getRepository( Fiche::class);
        $laFiche=$repositoryFiche->findLastFiche($id);

        return $this->render('home/menu.html.twig', ['lesFiches' => $fiches,'mois' => $mois,'laFiche' => $laFiche]);
    }

    /**
     * @Route("/menuJSON/{id}", name="menuJSON")
     */
    public function menuJSON($id): JsonResponse
    {
        // On cherche le visiteur
        $repositoryVis = $this->getDoctrine()->getRepository(Visiteur::class);
        $visiteur = $repositoryVis->find($id);

        //Collection de fiches du visiteur
        $fiches = $visiteur->getFiches();
        $data = [];

        foreach ($fiches as $uneFiche ) {
            $data[] = [
                
                'id' => $uneFiche ->getId(),
                'mois' => $this->getNameMonth($uneFiche ->getMois()->format("m")),
                'idEtat' => $uneFiche ->getEtat()->getLibelle(),
                'idVisit' => $uneFiche ->getVisiteur()->getNom()
            ];
        }

       return new JsonResponse($data, Response::HTTP_OK);
    }
    
    /**
     * @Route("/rechercheFiche/{mois}/{annee}/{idV}", name="menuJSON")
     */
    public function recherche($mois, $annee, $idV): JsonResponse
    {
        // On cherche le visiteur
        $repositoryVis = $this->getDoctrine()->getRepository(Visiteur::class);
        $visiteur = $repositoryVis->find($idV);
        $Mois=$annee."-".$mois;

        //Collection de fiches du visiteur
        $fiches = $this->getDoctrine()->getRepository(Fiche::class)->findUneFiche($idV,$Mois);
        $data = [];

        $data[] = [ 
            'id' => $fiches->getId(),
            'mois' => $this->getNameMonth($fiches->getMois()->format("m")),
            'idEtat' => $fiches->getEtat()->getLibelle(),
            'idVisit' => $fiches->getVisiteur()->getNom()
            ];

       return new JsonResponse($data, Response::HTTP_OK);
    }

    

    public function getNameMonth($i)
    {
        $name="Janvier";
        switch ($i) 
        {
            case "01":
                break;
            case "02":
                $name="Février";
                break;
            case "03":
                $name="Mars";
                break;
            case "04":
                $name="Avril";
                break;
            case "05":
                $name="Mai";
            break;
            case "06":
                $name="Juin";
            break;
            case "07":
                $name="Juillet";
            break;
            case "08":
                $name="Août";
            break;
            case "09":
                $name="Septembre";
            break;
            case "10":
                $name="Octobre";
            break;
            case "11":
                $name="Novembre";
            break;
            case "12":
                $name="Décembre";
            break;
        }
        return $name;
    }
    /**
     * @Route("/test", name="test")
     */
    public function test()
    {
        return $this->render('test.html.twig');
    }

}
