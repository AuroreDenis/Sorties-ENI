<?php

namespace App\Controller;

use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class ImageProfilController extends AbstractController
{
    /**
     * @Route("/image/profil", name="image_profil")
     */
    public function new(Request $request, EntityManagerInterface $em)
    {   $nomfile="";
        $participant=$this->getUser();
        if ($participant->getPhotoFilename()!=null) {
            $nomfile=$participant->getPhotoFilename();
            $participant->setPhotoFilename("");
        }

       //$participant->setPhotoFilename(new File($this->getParameter('brochures_directory').'/'.$participant->getPhotoFilename()));

        $form = $this->createForm(ImageType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PNG file
            ///** @var Symfony\Component\HttpFoundation\File\UploadedFile $file*/
            //$file = $participant->getPhotoFilename();
            $file = $form->get('photoFilename')->getData();

            $fileName = $this->generateUniqueFileName();//.'.'.$file->guessExtension();
            if ($nomfile!=""){$fileName=$nomfile;}
            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            // updates the 'brochure' property to store the PDF file name
            // instead of its contents
            $participant->setPhotoFilename($fileName);

            // ... persist the $product variable or any other work
            $em->persist($participant);
            $em->flush();
            return $this->redirectToRoute('sorties_list');
        }

        return $this->render('image_profil/index.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
