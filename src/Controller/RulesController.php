<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RulesController extends AbstractController
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }
    #[Route('/rules', name: 'app_rules_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $loginForm = $this->createForm(LoginType::class, $user);
        $loginForm->handleRequest($request);
        return $this->renderForm('rules/index.html.twig', [
            'user' => $user,
            'form' => $form,
            'loginForm' => $loginForm,
        ]);
    }

    #[Route('/newuser', name: 'app_newuser', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        UserPasswordHasherInterface $pswdHasher,
        UserRepository $userRepository
    ): Response {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $request->request->all("user")["password"]["first"];
            $user->setPassword($this->hasher->hashPassword($user, $password));
            $userRepository->save($user, true);
            $login = $this->createForm(LoginType::class, $user);
        } else {
            $login = $this->createForm(LoginType::class, $user);
        }
        return $this->renderForm('rules/index.html.twig', [
            'user' => $user,
            'form' => $form,
            'loginForm' => $login,
        ]);
    }

    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(Request $request): Response
    {
        $user = new User();
        $loginForm = $this->createForm(LoginType::class, $user);
        $form = $this->createForm(userType::class, $user);
        $loginForm->handleRequest($request);
        return $this->renderForm('rules/index.html.twig', [
            'user' => $user,
            'loginForm' => $loginForm,
            'form' => $form,
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET', 'POST'])]
    public function logout(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(LoginType::class, $user);
        $form->handleRequest($request);

        return $this->renderForm('rules/index.html.twig', [
            'user' => $user,
            'loginForm' => $form,
        ]);
    }
}
