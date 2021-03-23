<?php

namespace App\Controller\Api;

use App\Entity\Lieu;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class ApiLieux extends AbstractController
{
    /**
     * liste des lieux
     * @Route("/lieux", name="api_liste_lieux", methods={"GET"})
     */
    public function liste(SerializerInterface $serializer){


        $lieux = $this->getDoctrine()->getRepository(Lieu::class)->findAll();


        $json = $serializer->serialize($lieux, 'json', ['groups'=>["liste_lieux","liste_ville"]]);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
}