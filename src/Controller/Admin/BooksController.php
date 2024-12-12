<?php

namespace App\Controller\Admin;

use App\Entity\Books;
use App\Form\BooksType;
use App\Repository\BooksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/books')]
final class BooksController extends AbstractController
{
    #[Route(name: 'app_admin_books_index', methods: ['GET'])]
    public function index(BooksRepository $booksRepository): Response
    {
        return $this->render('admin/books/index.html.twig', [
            'books' => $booksRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_books_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $book = new Books();
        $form = $this->createForm(BooksType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_books_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/books/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_books_show', methods: ['GET'])]
    public function show(Books $book): Response
    {
        return $this->render('admin/books/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_books_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Books $book, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BooksType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_books_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/books/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_books_delete', methods: ['POST'])]
    public function delete(Request $request, Books $book, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_books_index', [], Response::HTTP_SEE_OTHER);
    }
}
