<?php

namespace App\Controller\Admin;

use App\Entity\Attack;
use App\Form\Admin\AttackType;
use App\Repository\AttackRepository;
use App\Repository\UnicornRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/attack', name: "app_admin_attack_")]
class AttackController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(AttackRepository $attackRepository): Response
    {
        return $this->render('admin/attack/index.html.twig', [
            'attacks' => $attackRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        AttackRepository $attackRepository,
        UnicornRepository $unicornRepository
    ): Response {
        $attack = new Attack();
        $form = $this->createForm(AttackType::class, $attack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attackRepository->save($attack, true);

            return $this->redirectToRoute('app_admin_attack_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/attack/new.html.twig', [
            'attack' => $attack,
            'form' => $form,
            'unicorns' => $unicornRepository->findAll()
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Attack $attack): Response
    {
        return $this->render('admin/attack/show.html.twig', [
            'attack' => $attack,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Attack $attack,
        AttackRepository $attackRepository,
        UnicornRepository $unicornRepository
    ): Response {
        $form = $this->createForm(AttackType::class, $attack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attackRepository->save($attack, true);

            return $this->redirectToRoute('app_admin_attack_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/attack/edit.html.twig', [
            'attack' => $attack,
            'form' => $form,
            'unicorns' => $unicornRepository->findAll()
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Attack $attack, AttackRepository $attackRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $attack->getId(), $request->request->get('_token'))) {
            $attackRepository->remove($attack, true);
        }

        return $this->redirectToRoute('app_admin_attack_index', [], Response::HTTP_SEE_OTHER);
    }
}
