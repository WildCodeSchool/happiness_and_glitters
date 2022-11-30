<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Unicorn;
use App\Entity\Attack;
use App\Repository\AttackRepository;
use App\Repository\UnicornRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/fight', name: 'app_fight_')]
class FightController extends AbstractController
{
    #[Route('/', name: 'attack')]
    public function attack(RequestStack $requestStack, UnicornRepository $unicornRepository): Response
    {
        $session = $requestStack->getSession();
        $userUni = $session->get('userUnicorn');
        $userAttacks = $userUni->getAttacks();
        $session->set('round', 1);
        $session->set('userScore', 100);
        $session->set('opponentScore', 100);
        return $this->render('fight/selectAttack.html.twig', ['attacks' => $userAttacks]);
    }

    #[Route('/round/', name: 'round')]
    public function loopInRound(RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $userUni = $session->get("userUnicornId");
        $attacks = $userUni->getAttacks();
        return $this->render('fight/selectAttack.html.twig', ['attacks' => $attacks]);
    }

    #[Route('/attackConfirm/{id}', name: 'attackConfirm')]
    public function confirmAttack(
        Attack $userAttack,
        RequestStack $requestStack,
        UnicornRepository $unicornRepository
    ): Response {
        $session = $requestStack->getSession();
        $session->set('userAttack', $userAttack);
        $oppoUni = $session->get('userUnicorn');
        $attacks = $oppoUni->getAttacks();
        $count = count($attacks);
        $rnd = rand(0, $count - 1);
        $attack = $attacks[$rnd];
        $session->set("opponentAttack", $attack);
        return $this->redirectToRoute('app_round');
    }

    #[Route('/{id}', name: 'indexUsers', methods: ['GET'])]
    public function indexRandomUsers(int $id, #[CurrentUser] $user, UserRepository $userRepository): Response
    {
        $users = $userRepository->find5ByRand($user->getId());
        $opponent = new User();
        if ($id > -1) {
            $opponent = $userRepository->findOneBy(['id' => $id]);
        }
        return $this->render('fight/index.html.twig', [
            'users' => $users,
            'opponent' => $opponent
        ]);
    }

    #[Route('/confirm/{id}', name: 'confirmOpponent', methods: ['Post'])]
    public function confirmOpponent(User $user, RequestStack $requestStack): Response
    {
        if ($user != null) {
            $session = $requestStack->getSession();
            $session->set('opponent', $user);
            return $this->redirectToRoute('app_unicorn_index');
        }
        return $this->redirectToRoute('app_fight_indexUsers');
    }
}
