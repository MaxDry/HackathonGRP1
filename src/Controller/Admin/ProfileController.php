<?php

namespace App\Controller\Admin;

use App\Entity\Profile;
use App\Form\ProfileType;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="profile_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, ProfileRepository $profileRepository): Response
    {
        $this->denyAccessUnlessGranted('list', new Profile());

        $profiles = $profileRepository->findAll();

        $profilesPaginate = $paginator->paginate(
            $profiles,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('admin/profile/index.html.twig', [
            'profiles' => $profilesPaginate,
        ]);
    }

    /**
     * @Route("/new", name="profile_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $profile = new Profile();

        $this->denyAccessUnlessGranted('create', $profile);

        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roles = [];
            foreach ($request->request->get('profile') as $key => $field) {
                if (substr($key, 0, 4) === 'ROLE') {
                    array_push($roles,$key);
                }
            }
            $profile->setRoles($roles);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profile);
            $entityManager->flush();

            $this->addFlash('success', 'Ajout d\'une profil réussi');

            return $this->redirectToRoute('admin_profile_index');
        }

        return $this->render('admin/profile/new.html.twig', [
            'profile' => $profile,
            'form' => $form->createView(),
            'roleTypes' => Profile::ROLES,
        ]);
    }

    /**
     * @Route("/{slug}", name="profile_show", methods={"GET"})
     */
    public function show(Profile $profile): Response
    {
        $this->denyAccessUnlessGranted('show', $profile);

        return $this->render('admin/profile/show.html.twig', [
            'profile' => $profile,
            'roleTypes' => Profile::ROLES,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="profile_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Profile $profile): Response
    {
        $this->denyAccessUnlessGranted('edit', $profile);

        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roles = [];
            foreach ($request->request->get('profile') as $key => $field) {
                if (substr($key, 0, 4) === 'ROLE') {
                    array_push($roles,$key);
                }
            }
            $profile->setRoles($roles);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Modification d\'une profil réussi');

            return $this->redirectToRoute('admin_profile_index');
        }

        return $this->render('admin/profile/edit.html.twig', [
            'profile' => $profile,
            'form' => $form->createView(),
            'roleTypes' => Profile::ROLES
        ]);
    }

    /**
     * @Route("/{id}", name="profile_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Profile $profile): Response
    {
        $this->denyAccessUnlessGranted('delete', $profile);

        if ($this->isCsrfTokenValid('delete'.$profile->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($profile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_profile_index');
    }
}
