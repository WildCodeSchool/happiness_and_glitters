<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UnicornController extends AbstractController
{
    #[Route('/index', name: 'app_fight')]
    public function index(): Response
    {
        if (!empty($_SESSION)) {
            return $this->twig->render('Fight/select-unicorn.html.twig', ['post' => $_POST]);
        } else {
            return $this->twig->render('Home/index.html.twig');
        }
    }

    public function addSelectedUnicornToSession(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $cleanValue = htmlentities(trim($_POST["userUnicorn"]));
            $cleanIdUnicorn = intval($cleanValue);
            if (filter_var($cleanIdUnicorn, FILTER_VALIDATE_INT)) {
                $unicornManager = new UnicornManager();
                $unicorn = $unicornManager->selectOneById($cleanIdUnicorn);
                $_SESSION['userUnicornId'] = $unicorn["id"];
            }
            $cleanValue = htmlentities(trim($_POST["opponentUnicorn"]));
            $cleanIdUnicorn = intval($cleanValue);
            if (filter_var($cleanIdUnicorn, FILTER_VALIDATE_INT)) {
                $unicornManager = new UnicornManager();
                $unicorn = $unicornManager->selectOneById($cleanIdUnicorn);
                $_SESSION['opponentUnicornId'] = $unicorn["id"];
                header("location: /selectattack"); // will be changed to the "select the attack" page when it's ready
            }
        } else {
            header("location: /");
        }
    }
}
