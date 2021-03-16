<?php

namespace App\Controller;

use App\Entity\Sorties;
use App\Form\SortiesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortiesController extends AbstractController
{


    /**
     * @Route("/sorties", name="sorties_list")
     */
    public function list()
    {
        $sortieRepo = $this->getDoctrine()->getRepository(Sorties::class);
        $sorties = $sortieRepo->findAll();

        return $this->render('sortie/list.html.twig', [
            "sorties" => $sorties
        ]);
    }


    /**
     * @Route("/sorties/add", name="sortie_add")
     */
    public function add(EntityManagerInterface $em, Request $request)
    {
        $sortie = new Sorties();
        //l'organisateur est l'utilisateur connecté
       $orga = $this->getUser();

        $sortieForm = $this->createForm(SortiesType::class, $sortie);

        //hydrate le formulaire
        $sortieForm->handleRequest($request);
        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            //sauvegarde en BDD ssi formulaire est renseigné
            $em->persist($sortie);
            $em->flush();

//renvoie dans la page de detail en affichant un message flash
            $this->addFlash('success', 'la sortie a été enregistrée');
            return $this->redirectToRoute('sortie_detail', [
                'id' => $sortie->getId()
            ]);
        }

        return $this->render('sortie/add.html.twig',[
            "SortiesType"=>  $sortieForm->createView()
        ]);
    }


    /**
     * @Route("/sorties/{id}", name="sortie_detail", requirements={"id": "\d+"})
     */
    public function detail($id): Response
    {
        $sortiesRepo = $this->getDoctrine()->getRepository(Sorties::class);
        $sortie = $sortiesRepo->find($id);
        return $this->render('sortie/detail.html.twig', [
            "sortie" => $sortie
        ]);
    }


}
