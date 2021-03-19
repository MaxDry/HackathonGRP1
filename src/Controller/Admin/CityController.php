<?php

namespace App\Controller\Admin;

use App\Entity\City;
use App\Form\CityType;
use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/city")
 */
class CityController extends AbstractController
{
    /**
     * @Route("/", name="city_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, CityRepository $cityRepository): Response
    {
        $this->denyAccessUnlessGranted('list', new City());

        $cities = $cityRepository->findAll();

        $citiesPaginate = $paginator->paginate(
            $cities,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('admin/city/index.html.twig', [
            'cities' => $citiesPaginate,
        ]);
    }

    /**
     * @Route("/new", name="city_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $city = new City();

        $this->denyAccessUnlessGranted('create', $city);

        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($city);
            $entityManager->flush();

            $this->addFlash('success', 'Ajout d\'une ville réussie');

            return $this->redirectToRoute('admin_city_index');
        }

        return $this->render('admin/city/new.html.twig', [
            'city' => $city,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="city_show", methods={"GET"})
     */
    public function show(City $city): Response
    {
        $this->denyAccessUnlessGranted('show', $city);

        return $this->render('admin/city/show.html.twig', [
            'city' => $city,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="city_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, City $city): Response
    {
        $this->denyAccessUnlessGranted('edit', $city);

        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Modification d\'une ville réussie');

            return $this->redirectToRoute('admin_city_index');
        }

        return $this->render('admin/city/edit.html.twig', [
            'city' => $city,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="city_delete", methods={"DELETE"})
     */
    public function delete(Request $request, City $city): Response
    {
        $this->denyAccessUnlessGranted('delete', $city);

        if ($this->isCsrfTokenValid('delete'.$city->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($city);
            $entityManager->flush();

            $this->addFlash('success', 'Suppression d\'une ville réussie');
        }

        return $this->redirectToRoute('admin_city_index');
    }
}
