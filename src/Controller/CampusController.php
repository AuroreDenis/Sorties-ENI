<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/admin")
 */
class CampusController extends AbstractController
{
    /**
     * @Route("/campus", name="gerer_campus")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        //creation du formulaire
        $campus=new Campus();
        $campusRepo = $this->getDoctrine()->getRepository(Campus::class);
        $allcampus = $campusRepo->findAll();
        dump($allcampus);

        $CampusForm=$this->createForm(CampusType::class, $campus);
        $CampusForm->handleRequest($request);
        if ($CampusForm->isSubmitted() and $CampusForm->isValid()) {
            $em->persist($campus);
            $em->flush();
            $campusRepo = $this->getDoctrine()->getRepository(Campus::class);
            $allcampus = $campusRepo->findAll();





        }
        return $this->render('campus/index.html.twig', [ 'allcampus'=>$allcampus , 'CampusForm'=>$CampusForm->createView(), ]);
    }

    /**
     * @Route("/campus/delete/{id}", name="delete_campus", requirements={"id":"\d+"}, methods={"GET"})
     **/
    public function delete ($id, EntityManagerInterface $em,Request $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $campusRepo = $this->getDoctrine()->getRepository(Campus::class);
        $campus = $campusRepo->find($id);
        $em->remove($campus);
        $em->flush();
        return $this->redirectToRoute('gerer_campus');
    }

    /**
     * @Route("/campus/modifier/{id}/{nom}", name="modifier_campus", methods={"GET"})
     **/
    public function modifier ($id, $nom, EntityManagerInterface $em,Request $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $campusRepo = $this->getDoctrine()->getRepository(Campus::class);
        $campus = $campusRepo->find($id);
        //************
        $campus->setNomCampus($nom);
        // formulaire, update

            //sauvegarde en BDD ssi formulaire est renseigné
            $em->persist($campus);
            $em->flush();






        //***************

        return $this->redirectToRoute('gerer_campus');
    }
}
