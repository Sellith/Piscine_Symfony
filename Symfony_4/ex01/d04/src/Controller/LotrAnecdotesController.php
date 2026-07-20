<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LotrAnecdotesController extends AbstractController
{
    private const CATEGORIES = [
        'broken-toe',
        'text-not-known',
        'height-difference',
    ];

    #[Route('/e01', name: 'app_lotr_anecdotes-summary')]
    public function index(): Response
    {
        return $this->render('lotr_anecdotes/index.html.twig', [
            'categories' => self::CATEGORIES
        ]);
    }

    #[Route('/e01/broken-toe', name: 'app_lotr_anecdotes-broken-toe')]
    public function brokenToe(): Response
    {
        return $this->render('lotr_anecdotes/brokenToe.html.twig');
    }

    #[Route('/e01/text-not-known', name: 'app_lotr_anecdotes-text-not-known')]
    public function textNotKnown(): Response
    {
        return $this->render('lotr_anecdotes/textNotKnown.html.twig');
    }

    #[Route('/e01/height-difference', name: 'app_lotr_anecdotes-height-difference')]
    public function heightDifference(): Response
    {
        return $this->render('lotr_anecdotes/heightDifference.html.twig');
    }
    
    #[Route('/e01/{path}', name: 'app_lotr_anecdotes-catch-all')]
    public function catchAll(): RedirectResponse
    {
        return $this->redirectToRoute('app_lotr_anecdotes-summary');
    }

}
