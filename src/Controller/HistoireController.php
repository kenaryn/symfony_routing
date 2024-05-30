<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoireController extends AbstractController
{
    #[Route('/histoire', name: 'app_histoire_p1')]
    public function page1(): Response
    {
        $histoireJson = file_get_contents('histoire.json');
        $histoire = json_decode($histoireJson);
        return $this->render('pages/page-01.html.twig', ['histoire' => $histoire]);
    }

    #[Route('/histoire/page/{id}', name: 'app_histoire_page')]
    public function showPage($id): Response
    {
        $histoireJson = file_get_contents('histoire.json');
        $histoire = json_decode($histoireJson);

        if ($id < 1 || $id > 14 || !is_numeric($id)) {
            throw $this->createNotFoundException('This page exists not!');
        }

        if ($id == 13) {
            $this->addFlash('notice', 'This history is now ending.');
        } else if ($id > 13) {
            return $this->redirect('/histoire/fin');
        }
        return $this->render('pages/page-base.html.twig', ['page' => $histoire->pages[$id - 2]]);
    }

    #[Route('/histoire/fin', name: 'app_histoire_fin')]
    public function showEndingPage(): Response
    {
        $histoireJson = file_get_contents('histoire.json');
        $histoire = json_decode($histoireJson);
        return $this->render('last-page/last-page.html.twig', ['histoire' => $histoire]);
    }
}
