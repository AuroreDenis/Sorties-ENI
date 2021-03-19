<?php

namespace App\Controller;

use PhpParser\Node\Stmt\ElseIf_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class HomeController extends AbstractController
{
    /**
     * @Route("/home/", name="home")
     */
    public function index(): Response
    {
        $user=$this->getUser()->getActif();// si actif=0 deconnexion
        if (!$user) {
            $this->addFlash('error', "Compte désactivé (veuillez contacter l'administrateur)");
            return $this->redirectToRoute('logout');
        }
        return $this->redirectToRoute('sorties_list', [

        ]);
    }
}
