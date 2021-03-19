<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Ville;
use App\Form\CampusType;
use App\Form\VilleType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/admin")
 */
class VilleController extends AbstractController
{
    /**
     * @Route("/ville", name="gerer_ville")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        //creation du formulaire
        $ville=new Ville();
        $villeRepo = $this->getDoctrine()->getRepository(Ville::class);
        $allville = $villeRepo->findAll();


        $VilleForm=$this->createForm(VilleType::class, $ville);
        $VilleForm->handleRequest($request);
        if ($VilleForm->isSubmitted() and $VilleForm->isValid()) {
            $em->persist($ville);
            $em->flush();
            $villeRepo = $this->getDoctrine()->getRepository(Ville::class);
            $allville = $villeRepo->findAll();





        }
        return $this->render('ville/index.html.twig', [ 'allville'=>$allville , 'VilleForm'=>$VilleForm->createView(), ]);
    }

    /**
     * @Route("/ville/delete/{id}", name="delete_ville", requirements={"id":"\d+"}, methods={"GET"})
     **/
    public function delete ($id, EntityManagerInterface $em,Request $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $villeRepo = $this->getDoctrine()->getRepository(Ville::class);
        $ville = $villeRepo->find($id);
        $em->remove($ville);
        $em->flush();
        return $this->redirectToRoute('gerer_ville');
    }


}
