<?php

namespace App\Controller;

use App\Entity\CandidateProfile;
use App\Entity\User;
use App\Form\CandidateProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;



final class CandidateProfileController extends AbstractController
{
    #[Route('/profile/create', name: 'app_candidate_profile_create')]
    public function create(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var User $user */
        $user = $this->getUser();

        if ($user->getCandidateProfile() !== null) {
            return $this->redirectToRoute('app_home');
        }

        $profile = new CandidateProfile();
        $profile->setUser($user);
        $user->setCandidateProfile($profile);

        $form = $this->createForm(CandidateProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $cvFile = $form->get('cvFile')->getData();

                if ($cvFile instanceof UploadedFile) {
                    $originalFilename = pathinfo($cvFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$cvFile->guessExtension();

                    try {
                        $cvFile->move(
                            $this->getParameter('cv_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        $form->get('cvFile')->addError(new FormError('Impossible de televerser le CV pour le moment. Reessayez.'));

                        if ($request->isXmlHttpRequest()) {
                            return new JsonResponse([
                                'success' => false,
                                'html' => $this->renderView('register/_profile_step.html.twig', [
                                    'form' => $form->createView(),
                                ]),
                            ], Response::HTTP_UNPROCESSABLE_ENTITY);
                        }

                        return $this->render('candidate_profile/index.html.twig', [
                            'form' => $form->createView(),
                        ]);
                    }

                    $profile->setCvPath($newFilename);
                }

                $em->persist($profile);
                $em->flush();

                if ($request->isXmlHttpRequest()) {
                    return new JsonResponse([
                        'success' => true,
                        'redirect' => $this->generateUrl('app_home'),
                    ]);
                }

                return $this->redirectToRoute('app_home');
            }

            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'success' => false,
                    'html' => $this->renderView('register/_profile_step.html.twig', [
                        'form' => $form->createView(),
                    ]),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return $this->render('candidate_profile/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
