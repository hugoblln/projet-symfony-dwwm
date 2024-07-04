<?php 

namespace App\Controller\Backend\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route('admin/index', 'admin.index', methods: ['GET'] )]
    public function index() : Response 
    {
        return $this->render('backend/Admin/index/index.html.twig');
    }
}