<?php
// src/Controller/ReservationController.php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ReservationController extends AbstractController
{

    #[Route('/reservation', name: 'reservation')]
    public function reservation(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Traiter la soumission du formulaire
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('confirmation_reservation');
        }

        return $this->render('reservation/reservation.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/confirmation', name: 'confirmation_reservation')]
    public function confirmation(): Response
    {
        return $this->render('reservation/confirmation.html.twig');
    }
}
