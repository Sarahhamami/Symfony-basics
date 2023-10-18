<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
    #[Route('/addProduct', name: 'add_product')]
    public function addProductt(Request $req, ManagerRegistry $manager): Response
    {
        
       $product= new Product();
       
        $m= $manager->getManager();
        $form= $this->createForm(ProductType::class, $product);
        $form= $form->handleRequest($req);
      
        if ($form->isSubmitted()){
            $m->persist($product);
            $m->flush();
            return $this->redirectToRoute("list_product");
        }
        
        return $this->renderForm('product/addProduct.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/listProduct', name: 'list_product')]
    public function listProduct(ProductRepository $repo): Response
    {
        return $this->render('product/listProduct.html.twig', [
            'list' => $repo->findAll(),
        ]);
    }
    #[Route('/editProduct/{id}', name: 'edit_product')]
    public function editProduct($id, ManagerRegistry $manager , Request $req, ProductRepository $repo): Response
    {
        $newproduct = $repo->find($id);
        $em = $manager->getManager();

        $form = $this->createForm(ProductType::class, $newproduct);


        $form->handleRequest($req);
        if ($form->isSubmitted()) {


            $em->persist($newproduct);
            $em->flush();

            return $this->redirectToRoute("list_product");
        }

        return $this->renderForm("product/updateProduct.html.twig", ["form" => $form]);
    }
   
    #[Route('/deleteProduct/{id}', name: 'delete_product')]
    public function deleteProduct(ManagerRegistry $manager, $id, ProductRepository $repo): Response
    {
        $product= $repo->find($id);
        $em= $manager->getManager(); 
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute("list_product");
    }
    
}
