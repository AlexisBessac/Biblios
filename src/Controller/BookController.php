<?php

namespace App\Controller;

use App\Entity\Books;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BooksRepository;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book_index')]
    public function index(BooksRepository $bookRepository, Request $request): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', requirements: [ 'id' => '\d+' ], methods: ['GET'])]
    public function show(?Books $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book
        ]);
    }
}