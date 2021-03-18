<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Filtre;
use App\Entity\Lieu;
use App\Entity\Participants;
use App\Entity\Sortie;

use App\Form\FiltreType;
use App\Form\SortiesType;
use DateInterval;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortiesController extends AbstractController
{

/********************************************* liste des sorties **********************************************/
    /**
     * @Route("/sorties", name="sorties_list")
     */
    public function list(Request $request)
    {
        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sorties = $sortieRepo->findAll();

        $campusRepo = $this->getDoctrine()->getRepository(Campus::class);
        $campus = $campusRepo->findAll();

        $filtre = new Filtre();

        $filtreForm = $this->createForm(FiltreType::class, $filtre);

        //hydrate le formulaire
        $filtreForm->handleRequest($request);

        if ($filtreForm->isSubmitted() && $filtreForm->isValid()) { // si le formulaire est envoyé

            $campusF=$filtre->getCampus();
            $dateFin = $filtre->getDateFin();

            return $this->render('sortie/list.html.twig', [
                "sorties" => $sorties,
                "campusFin" => $campusF,
            "dateFin" => $dateFin,
            "filtreForm" => $filtreForm->createView()
            ]);
        }
        // initialiser les values des dates
        $dateClot=new \DateTime('now');
        $dateClot ->add(new DateInterval('P180D'));
        $dateJour=new \DateTime('now');
        $dateJour ->sub(new DateInterval('P31D'));
        $dateJb=new \DateTime('now');

        return $this->render('sortie/list.html.twig', [
            "dateJb" => $dateJb,
            "sorties" => $sorties,
            "campus" => $campus,
            "campusFin" => 'bien',
            "dateClot" => $dateClot,
            "dateJour" => $dateJour,
            "filtreForm" => $filtreForm->createView()
//|date('dd-MM-yyyy'),
        ]);
    }

/********************************************** Création d'une sortie *****************************************/
    /**
     * @Route("/sorties/add", name="sortie_add")
     */
    public function add(EntityManagerInterface $em, Request $request)
    {
        $sortie = new Sortie();


        /******************* récupération de l'orga ********************/
        //l'organisateur est l'utilisateur connecté
        $orga =  $this->getUser();
       $sortie->setOrganisateur($orga);




        $sortieForm = $this->createForm(SortiesType::class, $sortie);

        //hydrate le formulaire
        $sortieForm->handleRequest($request);

        $flashMessage = 'problème ';

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            //sauvegarde en BDD ssi formulaire est renseigné

            /************************* récupération de état *************/
            $etatRepo = $this->getDoctrine()->getRepository(Etat::class);

            if($sortieForm->getClickedButton() === $sortieForm->get('creer')) {//gestion selon le bouton utilisé
            $etat = $etatRepo->findOneBy(['libelle' => 'En création']);
            $flashMessage = 'nouvelle sortie créée';
        }
            elseif ($sortieForm->getClickedButton() === $sortieForm->get('publier')) {//gestion selon le bouton utilisé
                $etat = $etatRepo->findOneBy(['libelle' => 'Ouvert']);
                $flashMessage = 'nouvelle sortie publiée';
            }

            else{
                $etat = $etatRepo->findOneBy(['libelle' => 'Fermé']);
            }
            $sortie->setEtat($etat);

            /***************** récupération du lieu ****************/

            $lieuRepo = $this->getDoctrine()->getRepository(Lieu::class);
          //  $sortie->getLieu();
         //$lieu = $lieuRepo->findOneBy([])
         //$sortie->setLieu($lieu);

            $em->persist($sortie);
            $em->flush();

//renvoie dans la page de detail en affichant un message flash
            $this->addFlash('success', $flashMessage);


            return $this->redirectToRoute('sortie_detail', [
                'id' => $sortie->getId()
            ]);
        }

        return $this->render('sortie/add.html.twig',[
            "SortiesType"=>  $sortieForm->createView()
        ]);
    }
/********************************** Detail d'une sortie ***************************************/

    /**
     * @Route("/sorties/{id}", name="sortie_detail", requirements={"id": "\d+"})
     */
    public function detail($id): Response
    {
        $sortiesRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $sortiesRepo->find($id);


        return $this->render('sortie/detail.html.twig', [
            "sortie" => $sortie
        ]);
    }

/***************** MODIF ************************************************/

    /**
     * @Route("/sorties/modif/{id}", name="sortie_modif", requirements={"id": "\d+"} )
     */
    public function modif($id, EntityManagerInterface $em, Request $request)
    {
        // récupérer la sortie à modifier
        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $sortieRepo->find($id);

        // formulaire, update
        $sortieForm = $this->createForm(SortiesType::class, $sortie);

        //hydrate le formulaire
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            //sauvegarde en BDD ssi formulaire est renseigné
            $em->persist($sortie);
            $em->flush();

//renvoie dans la page de detail en affichant un message flash
            $this->addFlash('success', 'la sortie a été modifiée');
            return $this->redirectToRoute('sortie_detail', [
                'id' => $sortie->getId()
            ]);
        }

        return $this->render('sortie/modif.html.twig',[
            "SortiesType"=>  $sortieForm->createView()
        ]);
    }
/***********************************s s'inscrire à une sortie**********************************************/

    /**
     * @Route("/sorties/s'inscrire/{id}", name="sinscrire_sortie", requirements={"id": "\d+"} )
     */
    public function sinscrire($id, EntityManagerInterface $em, Request $request)
    {
        // on récupère l'user
        $user=$this->getUser();
        // récupérer la sortie à modifier
        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $sortieRepo->find($id);

        //ajoute le participant à la sortie et la sortie au participant
        $sortie->addParticipants($user);
        $user->addSortie($sortie);


        // enregistrement en bdd
        $em->persist($sortie);
        $em->flush();



        return $this->redirectToRoute('sorties_list', [

        ]);

    }

    /*************************************SE DESISTER***********************************************************/

    /**
     * @Route("/sorties/seDesister/{id}", name="seDesister_sortie", requirements={"id": "\d+"} )
     *
     */
    public function seDesister($id, EntityManagerInterface $em, Request $request)
    {
        // on récupère l'user
        $user=$this->getUser();
        // récupérer la sortie à modifier
        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $sortieRepo->find($id);

        //retirer le participant à la sortie et la sortie au participant

        $sortie->removeParticipants($user);
        $user->removeSortie($sortie);

        //enregister en bdd
        $em->persist($sortie);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('sorties_list', [

        ]);




    }
}
