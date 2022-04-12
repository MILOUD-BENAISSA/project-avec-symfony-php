<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
	#[Route('/admin/livres', name: 'app_admin_book_list', methods: ['GET'])]
	public function list(BookRepository $repository): Response
	{
		return $this->render('admin/book/list.html.twig', [
			'books' => $repository->findAll(),
		]);
	}

	#[Route('/admin/livres/nouveau', name: 'app_admin_book_create', methods: ['GET', 'POST'])]
	public function create(Request $request, BookRepository $repository): Response
	{
		$form = $this->createForm(BookType::class, new Book());

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$repository->add($form->getData());

			return $this->redirectToRoute('app_admin_book_list');
		}

		return $this->render('admin/book/create.html.twig', [
			'form' => $form->createView(),
		]);
	}
}
