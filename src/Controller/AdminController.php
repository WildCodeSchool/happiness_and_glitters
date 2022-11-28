<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/admin', name: 'app_admin_')]
class AdminController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ["GET", "POST"])]
    public function login(
        Request $request,
        AuthenticationUtils $authenticationUtils
    ): Response {
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        $accessDeniedQuery = $request->get('access_denied');

        return $this->renderForm('admin/login.html.twig', [
            'form' => $form,
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'access_denied' => $accessDeniedQuery === "1"
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
