<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/admin")
 */
class InactiverSupprimerUtilisateurController extends AbstractController
{
    /**
     * @Route("supprimer-inactiver/utilisateur", name="inactiver_supprimer_utilisateur")
     */
    public function inactiverSupprimer(): Response
    {
        // récupérer lES PARTICIPANTS à modifier
        $participantRepo = $this->getDoctrine()->getRepository(Participants::class);
        $participant = $participantRepo->findAll();
        return $this->render('inactiver_supprimer_utilisateur/index.html.twig', [
                'participants'=>$participant,
        ]);
    }

    /**
     * @Route("supprimer-inactiver/supprimer/utilisateur/{id}", name="supprimer_utilisateur", requirements={"id": "\d+"})
     */
    public function supprimerUtilisateur($id, EntityManagerInterface $em, Request $request)
    {
        // récupérer lE PARTICIPANTS à supprimer
        $participantRepo = $this->getDoctrine()->getRepository(Participants::class);
        $participant = $participantRepo->find($id);
        // recuperer les sorties
        $sortieRepo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $sortieRepo->findAll();

        foreach ($sortie as $sort){
            $lorganisateur=$sort->getOrganisateur();
            $idorganisateur=$lorganisateur->getId();
            if ($idorganisateur==$id){

                $em->remove($sort);
                $em->flush();
            }
        }
        ////SUPPRIMER EN en bdd
        //$participant = $participantRepo->find($id);
        $em->remove($participant);
        $em->flush();



        return $this->redirectToRoute('inactiver_supprimer_utilisateur', [

        ]);
    }
    /**
     * @Route("supprimer-inactiver/inactiver/utilisateur/{id}", name="inactiver_utilisateur", requirements={"id": "\d+"} )
     */
    public function inactiverUtilisateur($id, EntityManagerInterface $em, Request $request)
    {
        // récupérer lE PARTICIPANTS à inactiver
        $participantRepo = $this->getDoctrine()->getRepository(Participants::class);
        $participant = $participantRepo->find($id);
        $participant->setActif(0);
        ////SUPPRIMER EN en bdd
        $em->persist($participant);
        $em->flush();
        return $this->redirectToRoute('inactiver_supprimer_utilisateur', [

        ]);




    }

    /**
     * @Route("supprimer-inactiver/activer/utilisateur/{id}", name="activer_utilisateur", requirements={"id": "\d+"})
     */
    public function activerUtilisateur($id, EntityManagerInterface $em, Request $request)
    {
        // récupérer lE PARTICIPANTS à inactiver
        $participantRepo = $this->getDoctrine()->getRepository(Participants::class);
        $participant = $participantRepo->find($id);
        $participant->setActif(1);
        ////SUPPRIMER EN en bdd
        $em->persist($participant);
        $em->flush();
        return $this->redirectToRoute('inactiver_supprimer_utilisateur', [

        ]);




    }
}
