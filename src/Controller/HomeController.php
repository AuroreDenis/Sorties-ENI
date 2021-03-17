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
        $user=$this->getUser();
        //$role=$this->getUser()->getActif();
        $role=1;
        if ($role==1) {
            $role="ROLE_ADMIN";
        } else {
            $role="ROLE_USER";
        }
        return $this->render('home/index.html.twig', [
            'user'=>$user, 'role'=>$role
        ]);
    }
}
