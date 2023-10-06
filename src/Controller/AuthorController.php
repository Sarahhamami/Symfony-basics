<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    public $authors = array(
        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
        'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
        ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
        array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
        'taha.hussein@gmail.com', 'nb_books' => 300),
        );
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
    #[Route('/showAuthor/{name}', name: 'show_author')]
    public function showAuthor($name): Response
    {
        return $this->render('author/show.html.twig', [
            'name' => $name,
        ]);
    }
    #[Route('/list', name: 'app_author')]
    public function list(): Response
    {

       
          $nb= count($this->authors);
          $sum = array_sum(array_column($this->authors, 'nb_books'));
        return $this->render('author/list.html.twig', [
            'list' => $this->authors, 'sum'=>$sum
        ]);
    }
    
    #[Route('/authorDetail/{id}', name: 'author_detail')]
    public function authorDetail($id): Response
    {
        
        $authById=null;
            foreach ($this->authors as $auth) {
                if ($auth['id'] == $id) {
                    $authById = $auth;
                    break;
                }
            }
        return $this->render('author/showAuthor.html.twig', [
            'authById' => $authById,
        ]);
    }
    #[Route('/listAuthor', name: 'list')]
    public function listAuthors(AuthorRepository $repo): Response
    {
        return $this->render('author/listAuthors.html.twig', [
            'list' => $repo->findAll(),
        ]);
    }
    #[Route('/add', name: 'addAuthor')]
    public function AddAuthor(ManagerRegistry $manager, Request $req): Response
    {
        
        $em= $manager->getManager(); //Doctrine manager
        $auth = new Author(); 
        $form= $this->createForm(AuthorType::class,$auth );
        // $auth->setUsername("Emna");
        // $auth->setEmail("Emna@gmail.com");
        $form->handleRequest($req);
        if ($form->isSubmitted()){
            $em->persist($auth);//Enregistrement 
            $em->flush(); // pour executer
            return $this->redirectToRoute("list");
        }
        return $this->renderForm("author/add.html.twig", ["form"=>$form]);
    }
    #[Route('/edit/{id}', name: 'editAuthor')]
    public function editAuthor(ManagerRegistry $manager, Request $req, Author $author): Response
    {  
        $em= $manager->getManager(); //Doctrine manager
        $form= $this->createForm(AuthorType::class,$author);
        // $auth->setUsername("Emna");
        // $auth->setEmail("Emna@gmail.com");
        $form->handleRequest($req);
        if ($form->isSubmitted()){
            $em->persist($author);//Enregistrement 
            $em->flush(); // pour executer
            return $this->redirectToRoute("list");
        }
        return $this->renderForm("author/edit.html.twig", ["form"=>$form]);
    }
    #[Route('/delete/{id}', name: 'deleteAuthor')]
    public function deleteAuthor(ManagerRegistry $manager, Request $req, Author $author): Response
    {  
        $em= $manager->getManager(); //Doctrine manager
        $em->remove($author);
        $em->flush(); // pour executer
        return $this->renderForm("author/delete.html.twig", []);
    }
}