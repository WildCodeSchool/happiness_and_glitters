<?php

namespace App\Controller;

use App\Service\FightManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoundController extends AbstractController
{
    #[Route('/round', name: 'app_round')]
    public function fight(
        RequestStack $requestStack,
        FightManager $fightManager,
        EntityManagerInterface $entityManager
    ): Response {
        $session = $requestStack->getSession();
        $continue = $fightManager->buildRoundUser();
        if ($continue) {
            $continue = $fightManager->buildRoundOpponent();
            if ($continue) {
                $session->set('round', $session->get('round') + 1);
                return $this->redirectToRoute('app_fight_attack');
            }
        }

        $user = $session->get('sessionUser');
        $opponent = $session->get('opponentUser');
        if ($session->get('userScore') > $session->get('opponentScore')) {
            $user->setScore($user->getScore() + (int) ($opponent->getScore() / 10));
            $entityManager->persist($user);
        } else {
            $opponent->setScore($opponent->getScore() + (int) ($user->getScore() / 10));
            $entityManager->persist($opponent);
        }
        $entityManager->flush();
        $session->set('round', 0);
        return $this->redirectToRoute('app_fight_attack');
    }
}
