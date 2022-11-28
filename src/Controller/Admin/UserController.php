<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/user', name: 'app_admin_user_')]
class UserController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/toggle_admin', name: 'toggle_admin', methods: ["GET"])]
    public function toggleAdmin(User $user, UserRepository $userRepository): Response
    {
        if (in_array("ROLE_ADMIN", $user->getRoles())) {
            $user->setRoles(array_filter($user->getRoles(), function ($role) {
                return $role !== "ROLE_ADMIN";
            }));
        } else {
            $roles = $user->getRoles();
            $roles[] = "ROLE_ADMIN";
            $user->setRoles($roles);
        }

        $userRepository->save($user, true);
        return $this->redirectToRoute('app_admin_user_index');
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
