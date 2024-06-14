<?php

namespace App\Controller;

use App\Entity\UserAvatar;
use App\Form\ProfileEditFormType;
use App\Form\UserAvatarFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProfileController extends AbstractController
{
  #[Route('/profile', name: 'app_profile')]
  #[isGranted('ROLE_USER')]
  public function show(Request $request, EntityManagerInterface $em): Response
  {
    $user = $this->getUser();
    $form = $this->createForm(ProfileEditFormType::class, $user, [
      'attr' => [
        'class' => 'flex flex-col gap-2',
      ]
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $user = $form->getData();
      $em->flush();

      $this->addFlash('succès', 'Profil mis à jour avec succès.');
      return $this->redirectToRoute('app_profile');
    }

    $userAvatar = $user->getUserAvatar();

    if (!$userAvatar) {
      $userAvatar = new UserAvatar();
      $userAvatar->setUser($user);
      $em->persist($userAvatar);
      $em->flush();
    }

    $avatarForm = $this->createForm(UserAvatarFormType::class, $userAvatar, [
      'attr' => [
        'class' => 'flex flex-col gap-2',
      ]
    ]);

    $avatarForm->handleRequest($request);

    if ($avatarForm->isSubmitted() && $avatarForm->isValid()) {
      $avatar = $avatarForm->getData();
      $avatar->setUser($user);

      $em->persist($avatar);
      $em->flush();

      $this->addFlash('succès', 'Avatar mis à jour avec succès.');
      return $this->redirectToRoute('app_profile');
    }

    return $this->render('profile/show.html.twig', [
      'user' => $user,
      'userAvatar' => $userAvatar,
      'form' => $form,
      'avatarForm' => $avatarForm,
    ]);
  }
}
