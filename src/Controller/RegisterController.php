<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $user = new User();
        $form =$this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            try {
                $user->setCreateAt(new \DateTimeImmutable());
                $user->setRoles(['ROLE_USER']);
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('app_home');
            } catch (EntityNotFoundException $e) {
                echo $e;
            }

        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
