<?php

namespace App\Controller;

use App\Repository\UnicornRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/unicorn', name: 'app_unicorn_')]
class UnicornController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(RequestStack $requestStack, UnicornRepository $unicornRepository): Response
    {
        $session = $requestStack->getSession();
        if ($session->has('opponent')) {
            $unicorns = $unicornRepository->find3ByRand(0);
            return $this->render('fight/select-unicorn.html.twig', ['unicorns' => $unicorns]);
        } else {
            return $this->render('home/index.html.twig');
        }
    }

    #[Route('/select', name: 'select', methods: ['GET', 'POST'])]
    public function addSelectedUnicornToSession(
        Request $request,
        RequestStack $requestStack,
        UnicornRepository $unicornRepository
    ): Response {
        $unicornUser = $unicornRepository->findOneBy(['id' => $request->get('userUnicorn')]);
        $unicornOpponent = $unicornRepository->findOneBy(['id' => $request->get('opponentUnicorn')]);

        $session = $requestStack->getSession();
        $session->set('userUnicorn', $unicornUser);
        $session->set('opponentUnicorn', $unicornOpponent);
        return $this->redirectToRoute('app_fight_attack');
    }
}
