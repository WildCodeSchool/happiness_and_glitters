<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\FightManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class RoundController extends AbstractController
{
    #[Route('/round', name: 'app_round')]
    public function fight(
        RequestStack $requestStack,
        #[CurrentUser] $user,
        FightManager $fightManager,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ): Response {
        $session = $requestStack->getSession();
        $continue = $fightManager->buildRoundUser();
        if ($continue) {
            $continue = $fightManager->buildRoundOpponent();
            if ($continue) {
                $session->set('round', $session->get('round') + 1);
                return $this->redirectToRoute('app_fight_round');
            }
        }

        $opponent = $session->get('opponent');
        $opponent = $userRepository->findOneBy(['id' => $opponent->getId()]);
        if ($session->get('userScore') > $session->get('opponentScore')) {
            $user->setScore($user->getScore() + (int) ($opponent->getScore() / 10));
            $entityManager->persist($user);
        } else {
            $opponent->setScore($opponent->getScore() + (int) ($user->getScore() / 10));
            $entityManager->persist($opponent);
        }
        $entityManager->flush();
        $session->set('round', 0);
        return $this->redirectToRoute('app_user_index');
    }
}
