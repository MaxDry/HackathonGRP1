<?php

namespace App\Controller\Admin;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/formation")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/", name="formation_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, FormationRepository $formationRepository): Response
    {
        $this->denyAccessUnlessGranted('list', new Formation());

        $formations = $formationRepository->findAll();

        $formationsPaginate = $paginator->paginate(
            $formations,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('admin/formation/index.html.twig', [
            'formations' => $formationsPaginate,
        ]);
    }

    /**
     * @Route("/new", name="formation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('create', new Formation());

        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formation);
            $entityManager->flush();

            $this->addFlash('success', 'Ajout d\'une formation réussie');

            return $this->redirectToRoute('admin_formation_index');
        }

        return $this->render('admin/formation/new.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="formation_show", methods={"GET"})
     */
    public function show(Formation $formation): Response
    {
        $this->denyAccessUnlessGranted('show', new Formation());

        return $this->render('admin/formation/show.html.twig', [
            'formation' => $formation,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="formation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Formation $formation): Response
    {
        $this->denyAccessUnlessGranted('edit', new Formation());

        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Modification d\'une formation réussie');

            return $this->redirectToRoute('admin_formation_index');
        }

        return $this->render('admin/formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="formation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Formation $formation): Response
    {
        $this->denyAccessUnlessGranted('delete', new Formation());

        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($formation);
            $entityManager->flush();

            $this->addFlash('success', 'Suppression d\'une formation réussie');
        }

        return $this->redirectToRoute('admin_formation_index');
    }
}
