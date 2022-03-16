<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/creer-livre')]
    public function createBook(EntityManagerInterface $manager): Response
    {
        $book = new Book();
        $book->setTitle('Mon premier livre');
        $book->setPrice(12.5);
        $book->setDescription('Description de mon livre');

        // On demande au manager de doctrine de prendre en compte
        // le nouveau livre. Cette instruction n'enregistre dans
        // la base.
        $manager->persist($book);

        // On demande au manager de doctrine de mettre à jour
        // la base de données
        $manager->flush();

        return new Response('Le nouveau livre à bien été créé: ' . $book->getTitle());
    }


    #[Route('/hello/{nom}', name: 'app_hello_hello', methods: ['GET'])]
    public function hello(Request $request, string $nom): Response
    {
        // Création d'un objet Response correspondant
        // au fichier text de la réponse
        $response = new Response("Hello $nom :)");

        // Changement du status code de la response
        $response->setStatusCode(200);

        // Affiche la méthode HTTP que le client utilisé
        $request->getMethod(); // GET

        // Récupére l'url compléte rentré par l'utilisateur
        $request->getUri();

        // Récupére un en tête http
        $request->headers->get('User-Agent');

        // Récupére un filtre (une query string)
        $request->query->get('taille');

        // Récupére un cookie
        $request->cookies->get('Nom du cookie');

        return $response;
    }

    #[Route('/bonjour/{nom}', name: 'app_hello_bonjour')]
    public function bonjour(string $nom): Response
    {
        return new Response("Bonjour $nom, comment allez-vous ?");
    }
}
