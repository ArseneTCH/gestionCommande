<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Form\Burger1Type;
use App\Repository\BurgerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/burger')]
class BurgerController extends AbstractController
{
    #[Route('/', name: 'app_burger_index', methods: ['GET'])]
    public function index(BurgerRepository $burgerRepository): Response
    {
        return $this->render('burger/index.html.twig', [
            'burgers' => $burgerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_burger_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BurgerRepository $burgerRepository): Response
    {
        $burger = new Burger();
        $form = $this->createForm(Burger1Type::class, $burger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $burgerRepository->save($burger, true);

            return $this->redirectToRoute('app_burger_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('burger/new.html.twig', [
            'burger' => $burger,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_burger_show', methods: ['GET'])]
    public function show(Burger $burger): Response
    {
        return $this->render('burger/show.html.twig', [
            'burger' => $burger,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_burger_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Burger $burger, BurgerRepository $burgerRepository): Response
    {
        $form = $this->createForm(Burger1Type::class, $burger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $burgerRepository->save($burger, true);

            return $this->redirectToRoute('app_burger_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('burger/edit.html.twig', [
            'burger' => $burger,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_burger_delete', methods: ['POST'])]
    public function delete(Request $request, Burger $burger, BurgerRepository $burgerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$burger->getId(), $request->request->get('_token'))) {
            $burgerRepository->remove($burger, true);
        }

        return $this->redirectToRoute('app_burger_index', [], Response::HTTP_SEE_OTHER);
    }
}
