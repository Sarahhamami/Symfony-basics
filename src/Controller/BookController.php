<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/addBook', name: 'addBook')]
    public function addBook(ManagerRegistry $manager,Request $req): Response
    {
        $book= new Book();
        $book->setPublished(true);

        $form=$this->createForm(BookType:: class, $book);
        $em=$manager->getManager();
         $form->handleRequest($req);
        if ($form->isSubmitted()){
            $nb=$book->getAuthor()->getNbBooks()+1;
            $book->getAuthor()->setNbBooks($nb);
            $em->persist($book);
            $em->flush();
        }
       
        return $this->renderForm('book/addBook.html.twig', [
            'form' => $form,
        ]);

    }

    #[Route('/listBook', name: 'list')]
    public function listAuthors(BookRepository $repo): Response
    {
        return $this->render('book/listBook.html.twig', [
            'list' => $repo->findAll(),
        ]);
    }
}
