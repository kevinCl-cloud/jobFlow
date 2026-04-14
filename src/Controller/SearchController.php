<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(): Response
    {
        $user = $this->getUser();
        // verifier que $user est bien une instance de User
        if (!$user instanceof User){
            throw $this->createAccessDeniedException();
            }
            
        // reucperer le profile du candidat
        $candidateProfile = $user->getCandidateProfile();

        return $this->render('search/index.html.twig', [
            'candidateProfile' => $candidateProfile,
        ]);
    }
}
