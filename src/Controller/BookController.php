<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Books;
use App\Repository\BooksRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book_index')]
    public function index(BooksRepository $booksRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Utiliser une requête Doctrine ou une QueryBuilder pour la pagination
        $query = $booksRepository->createQueryBuilder('b')->getQuery();

        // Paginer les résultats
        $books = $paginator->paginate
        (
            $query, // La requête ou QueryBuilder à paginer
            $request->query->getInt('page', 1), // Page actuelle, par défaut 1
            4 // Nombre d'éléments par page
        );

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Books $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }
}