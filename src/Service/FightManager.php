<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class FightManager
{
    public const MAX_SCORE = 200;

    public function __construct(private RequestStack $requestStack)
    {
    }

    public function buildRoundUser(): bool
    {
        $session = $this->requestStack->getSession();
        $attack = $session->get('userAttack');
        $score = $session->get("userScore");
        $score -= $attack->getCost();
        $success = rand(0, 100) <= $attack->getsuccessRate();
        if ($success) {
            $score += $attack->getGain();
        }

        $session->set('successRound', $success);
        $session->set('userScore', $score);
        return $score > 0 && $score < self::MAX_SCORE;
    }

    public function buildRoundOpponent(): bool
    {
        $session = $this->requestStack->getSession();
        $attack = $session->get('opponentAttack');
        $score = $session->get("opponentScore");
        $score -= $attack->getCost();
        $success = rand(0, 100) <= $attack->getsuccessRate();
        if ($success) {
            $score += $attack->getGain();
        }
        $session->set('successRound', $success);
        $session->set('opponentScore', $score);
        return $score > 0 && $score < self::MAX_SCORE;
    }
}
