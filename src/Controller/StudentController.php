<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class StudentController extends AbstractController
{
    #[Route('/test',name: 'student')]
    public function index(): Response
    {

        return new Response(
            'Bonjour mes etudiants'
        );
    }
}