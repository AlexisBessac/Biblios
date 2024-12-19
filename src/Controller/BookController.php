<?php

namespace App\Controller;

use App\Entity\Books;
use App\Repository\BooksRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book_index')]
    public function index(BooksRepository $bookRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Récupère le numéro de page depuis la requête (par défaut : 1)
        $page = $request->query->getInt('page', 1);
        $limit = 4; // Nombre d'éléments par page

        // Utilise la méthode du repository pour paginer
        $books = $bookRepository->paginateBooks($page, $limit);

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/book/{id}', name: 'app_book_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Books $book): Response
    {
        // Vérifie si le livre existe
        if (!$book) {
            throw $this->createNotFoundException('Le livre demandé n\'existe pas.');
        }

        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }
}