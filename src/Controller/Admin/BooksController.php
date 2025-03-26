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
            // Récupération de la donnée associée au champ "cover" du formulaire
            $file = $form->get('cover')->getData();

            if ($file) // Vérifie si un fichier a été téléchargé
            {
                // Génération d'un nom de fichier unique en utilisant l'ID du livre
                // suivi de l'extension d'origine du fichier téléchargé
                $filename = $book->getTitle() . '.' . $file->getClientOriginalExtension();

                // Déplacement du fichier téléchargé vers le dossier de destination
                $file->move
                (
                    $this->getParameter('kernel.project_dir') . '/public/images/cover/',
                    $filename
                );

                // Mise à jour de la propriété "cover" de l'objet Book avec le chemin ou le nom du fichier pour un usage ultérieur
                $book->setCover($filename);
            }
            
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
            // Récupération de la donnée associée au champ "cover" du formulaire
            $file = $form->get('cover')->getData();

            if ($file) // Vérifie si un fichier a été téléchargé
            {
                // Génération d'un nom de fichier unique en utilisant l'ID du livre
                // suivi de l'extension d'origine du fichier téléchargé
                $filename = $book->getTitle() . '.' . $file->getClientOriginalExtension();

                // Déplacement du fichier téléchargé vers le dossier de destination
                $file->move
                (
                    $this->getParameter('kernel.project_dir') . '/public/images/cover/',
                    $filename
                );

                // Mise à jour de la propriété "cover" de l'objet Book avec le chemin ou le nom du fichier pour un usage ultérieur
                $book->setCover($filename);
            }
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
        if ($this->isCsrfTokenValid('delete' . $book->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_books_index', [], Response::HTTP_SEE_OTHER);
    }
}