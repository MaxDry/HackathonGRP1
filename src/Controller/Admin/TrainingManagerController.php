<?php

namespace App\Controller\Admin;

use App\Entity\TrainingManager;
use App\Form\TrainingManagerType;
use App\Repository\TrainingManagerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/training/manager")
 */
class TrainingManagerController extends AbstractController
{
    /**
     * @Route("/", name="training_manager_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, TrainingManagerRepository $trainingManagerRepository): Response
    {
        $this->denyAccessUnlessGranted('list', new TrainingManager());

        $training_managers = $trainingManagerRepository->findAll();

        $training_managersPaginate = $paginator->paginate(
            $training_managers,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('admin/training_manager/index.html.twig', [
            'training_managers' => $training_managersPaginate,
        ]);
    }

    /**
     * @Route("/new", name="training_manager_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $trainingManager = new TrainingManager();

        $this->denyAccessUnlessGranted('create', $trainingManager);

        $form = $this->createForm(TrainingManagerType::class, $trainingManager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($trainingManager);
            $entityManager->flush();

            return $this->redirectToRoute('admin_training_manager_index');
        }

        return $this->render('admin/training_manager/new.html.twig', [
            'training_manager' => $trainingManager,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="training_manager_show", methods={"GET"})
     */
    public function show(TrainingManager $trainingManager): Response
    {
        $this->denyAccessUnlessGranted('show', $trainingManager);

        return $this->render('admin/training_manager/show.html.twig', [
            'training_manager' => $trainingManager,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="training_manager_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TrainingManager $trainingManager): Response
    {
        $this->denyAccessUnlessGranted('edit', $trainingManager);

        $form = $this->createForm(TrainingManagerType::class, $trainingManager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_training_manager_index');
        }

        return $this->render('admin/training_manager/edit.html.twig', [
            'training_manager' => $trainingManager,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="training_manager_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TrainingManager $trainingManager): Response
    {
        $this->denyAccessUnlessGranted('delete', $trainingManager);

        if ($this->isCsrfTokenValid('delete'.$trainingManager->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trainingManager);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_training_manager_index');
    }
}
