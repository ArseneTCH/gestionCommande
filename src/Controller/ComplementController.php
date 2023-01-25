<?php

namespace App\Controller;

use App\Entity\Complement;
use App\Form\Complement1Type;
use App\Repository\ComplementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/complement')]
class ComplementController extends AbstractController
{
    #[Route('/', name: 'app_complement_index', methods: ['GET'])]
    public function index(ComplementRepository $complementRepository): Response
    {
        return $this->render('complement/index.html.twig', [
            'complements' => $complementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_complement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ComplementRepository $complementRepository): Response
    {
        $complement = new Complement();
        $form = $this->createForm(Complement1Type::class, $complement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $complementRepository->save($complement, true);

            return $this->redirectToRoute('app_complement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('complement/new.html.twig', [
            'complement' => $complement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_complement_show', methods: ['GET'])]
    public function show(Complement $complement): Response
    {
        return $this->render('complement/show.html.twig', [
            'complement' => $complement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_complement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Complement $complement, ComplementRepository $complementRepository): Response
    {
        $form = $this->createForm(Complement1Type::class, $complement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $complementRepository->save($complement, true);

            return $this->redirectToRoute('app_complement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('complement/edit.html.twig', [
            'complement' => $complement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_complement_delete', methods: ['POST'])]
    public function delete(Request $request, Complement $complement, ComplementRepository $complementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$complement->getId(), $request->request->get('_token'))) {
            $complementRepository->remove($complement, true);
        }

        return $this->redirectToRoute('app_complement_index', [], Response::HTTP_SEE_OTHER);
    }
}
