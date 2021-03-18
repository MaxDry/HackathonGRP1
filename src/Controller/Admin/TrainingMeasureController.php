<?php

namespace App\Controller\Admin;

use App\Entity\TrainingMeasure;
use App\Form\TrainingMeasureType;
use App\Repository\TrainingMeasureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/training/measure")
 */
class TrainingMeasureController extends AbstractController
{
    /**
     * @Route("/", name="training_measure_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, TrainingMeasureRepository $trainingMeasureRepository): Response
    {
        $training_measures = $trainingMeasureRepository->findAll();

        $training_measuresPaginate = $paginator->paginate(
            $training_measures,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('admin/training_measure/index.html.twig', [
            'training_measures' => $training_measuresPaginate,
        ]);
    }

    /**
     * @Route("/new", name="training_measure_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $trainingMeasure = new TrainingMeasure();
        $form = $this->createForm(TrainingMeasureType::class, $trainingMeasure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($trainingMeasure);
            $entityManager->flush();

            return $this->redirectToRoute('admin_training_measure_index');
        }

        return $this->render('admin/training_measure/new.html.twig', [
            'training_measure' => $trainingMeasure,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="training_measure_show", methods={"GET"})
     */
    public function show(TrainingMeasure $trainingMeasure): Response
    {
        return $this->render('admin/training_measure/show.html.twig', [
            'training_measure' => $trainingMeasure,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="training_measure_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TrainingMeasure $trainingMeasure): Response
    {
        $form = $this->createForm(TrainingMeasureType::class, $trainingMeasure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_training_measure_index');
        }

        return $this->render('admin/training_measure/edit.html.twig', [
            'training_measure' => $trainingMeasure,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="training_measure_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TrainingMeasure $trainingMeasure): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trainingMeasure->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trainingMeasure);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_training_measure_index');
    }
}
