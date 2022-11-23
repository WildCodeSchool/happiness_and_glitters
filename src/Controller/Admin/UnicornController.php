<?php

namespace App\Controller\Admin;

use App\Entity\Unicorn;
use App\Form\Admin\UnicornType;
use App\Repository\AttackRepository;
use App\Repository\UnicornRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/unicorn', name: 'app_admin_unicorn_')]
class UnicornController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(UnicornRepository $unicornRepository): Response
    {
        return $this->render('admin/unicorn/index.html.twig', [
            'unicorns' => $unicornRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        UnicornRepository $unicornRepository,
        AttackRepository $attackRepository
    ): Response {
        $unicorn = new Unicorn();
        $form = $this->createForm(UnicornType::class, $unicorn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $unicornRepository->save($unicorn, true);

            return $this->redirectToRoute('app_admin_unicorn_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/unicorn/new.html.twig', [
            'unicorn' => $unicorn,
            'form' => $form,
            'attacks' => $attackRepository->findAll()
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Unicorn $unicorn): Response
    {
        return $this->render('admin/unicorn/show.html.twig', [
            'unicorn' => $unicorn,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Unicorn $unicorn,
        UnicornRepository $unicornRepository,
        AttackRepository $attackRepository
    ): Response {
        $form = $this->createForm(UnicornType::class, $unicorn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $unicornRepository->save($unicorn, true);

            return $this->redirectToRoute('app_admin_unicorn_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/unicorn/edit.html.twig', [
            'unicorn' => $unicorn,
            'form' => $form,
            'attacks' => $attackRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Unicorn $unicorn, UnicornRepository $unicornRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $unicorn->getId(), $request->request->get('_token'))) {
            $unicornRepository->remove($unicorn, true);
        }

        return $this->redirectToRoute('app_admin_unicorn_index', [], Response::HTTP_SEE_OTHER);
    }
}
