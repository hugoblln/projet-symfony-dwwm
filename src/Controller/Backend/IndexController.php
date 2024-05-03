<?php 

namespace App\Controller\Backend;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route('admin/index', 'admin.index', ['GET'] )]
    public function index() : Response 
    {
        return $this->render('backend/index/index.html.twig');
    }
}