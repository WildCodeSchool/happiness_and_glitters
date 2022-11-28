<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'app_admin_')]
class AdminController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ["GET", "POST"])]
    public function login(Request $request, UserRepository $userRepository): Response
    {
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        return $this->renderForm('admin/login.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/logout', name: 'logout', methods: ["GET"])]
    public function logout(): void
    {
    }

    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}
