<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Form\Admin\AdminType;
use App\Repository\AdminRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/admin', name: 'app_admin_admin_')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(AdminRepository $adminRepository): Response
    {
        return $this->render('admin/admin/index.html.twig', [
            'admins' => $adminRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        AdminRepository $adminRepository,
        UserPasswordHasherInterface $hasher
    ): Response {
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $admin->setPassword($hasher->hashPassword($admin, $admin->getPassword()));
            $adminRepository->save($admin, true);

            return $this->redirectToRoute('app_admin_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin/new.html.twig', [
            'admin' => $admin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Admin $admin): Response
    {
        return $this->render('admin/admin/show.html.twig', [
            'admin' => $admin,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Admin $admin,
        AdminRepository $adminRepository,
        UserPasswordHasherInterface $hasher
    ): Response {
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $admin->setPassword($hasher->hashPassword($admin, $admin->getPassword()));
            $adminRepository->save($admin, true);

            return $this->redirectToRoute('app_admin_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin/edit.html.twig', [
            'admin' => $admin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Admin $admin, AdminRepository $adminRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $admin->getId(), $request->request->get('_token'))) {
            $adminRepository->remove($admin, true);
        }

        return $this->redirectToRoute('app_admin/admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
