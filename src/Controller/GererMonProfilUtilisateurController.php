<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Participants;
use App\Form\ParticipantsType;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class GererMonProfilUtilisateurController extends AbstractController
{
    /**
     * @Route("/gerer/mon/profil/utilisateur", name="gerer_mon_profil_utilisateur")
     */
    public function index(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $encoder): Response
    {    $participant=$this->getUser();
        $registerForm = $this->createForm(ParticipantsType::class, $participant);
        $registerForm->handleRequest($request);

        //$participant->setCampus($campus);$campus = new Campus();
        if ($registerForm->isSubmitted() and $registerForm->isValid()) {

            //hasher le mot de passe avec class passwordEncoderInterface
            $hashed=$encoder->encodePassword($participant,$participant->getPassword());
            $participant->setPassword($hashed);

            //sauvegarder mon utilsateur
            //try{

            $em->persist($participant);
            $em->flush();
            $this->addFlash('success', 'le compte a été modifié avec succès');
            return $this->redirectToRoute('home', [
                'controller_name' => 'HomeController',
            ]);

            //} catch (\Doctrine\DBAL\Exception $e) {
            //    $errorMessage = $e->getMessage();
            //   echo ($errorMessage);
            //  $this->addFlash('error', 'Nous n\' avons pas pu créer le compte (email existant...etc)');
            // return $this->redirectToRoute('home', [
            //   'controller_name' => 'HomeController',
            //  ]);
            // }

        }
        return $this->render('user/register.html.twig', [
            'controller_name' => 'UserController', "registerForm"=>$registerForm->createView()
        ]);

    }
}
