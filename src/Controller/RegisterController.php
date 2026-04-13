<?php

namespace App\Controller;

use App\Entity\CandidateProfile;
use App\Entity\User;
use App\Form\CandidateProfileType;
use App\Form\UserType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

final class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(
        Request $request,
        EntityManagerInterface $em,
        UserAuthenticatorInterface $userAuthenticator,
        AppAuthenticator $authenticator
    ): Response {
        /** @var User|null $currentUser */
        $currentUser = $this->getUser();

        if ($currentUser instanceof User) {
            if ($currentUser->getCandidateProfile() !== null) {
                return $this->redirectToRoute('app_home');
            }

            $profileForm = $this->createForm(CandidateProfileType::class, new CandidateProfile());

            return $this->render('register/index.html.twig', [
                'userForm' => null,
                'profileForm' => $profileForm->createView(),
                'currentStep' => 2,
            ]);
        }

        $user = new User();
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted()) {
            if ($userForm->isValid()) {
                $user->setCreateAt(new \DateTimeImmutable());
                $user->setRoles(['ROLE_USER']);

                $em->persist($user);
                $em->flush();

                $response = $userAuthenticator->authenticateUser(
                    $user,
                    $authenticator,
                    $request
                );

                if ($request->isXmlHttpRequest()) {
                    $profileForm = $this->createForm(CandidateProfileType::class, new CandidateProfile());

                    return new JsonResponse([
                        'success' => true,
                        'html' => $this->renderView('register/_profile_step.html.twig', [
                            'form' => $profileForm->createView(),
                        ]),
                    ]);
                }

                return $response ?? $this->redirectToRoute('app_candidate_profile_create');
            }

            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'success' => false,
                    'html' => $this->renderView('register/_user_step.html.twig', [
                        'form' => $userForm->createView(),
                    ]),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return $this->render('register/index.html.twig', [
            'userForm' => $userForm->createView(),
            'profileForm' => null,
            'currentStep' => 1,
        ]);
    }
}
