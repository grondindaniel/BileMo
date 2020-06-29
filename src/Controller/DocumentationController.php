<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DocumentationController extends AbstractController
{
    /**
     * @Route("/documentation", name="documentation")
     */
    public function index()
    {
        return $this->redirect('https://127.0.0.1:8027/documentation/index.html');
    }
}
