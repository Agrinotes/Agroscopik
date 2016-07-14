<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\SpecialityUsage;
use AppBundle\Form\SpecialityUsageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * SpecialityUsage controller.
 *
 * @Route("/specialityusage")
 * @Security("has_role('ROLE_USER')")
 */
class SpecialityUsageController extends Controller
{
    /**
     * Lists all SpecialityUsage entities.
     *
     * @Route("/", name="specialityusage_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $specialityUsages = $em->getRepository('AppBundle:SpecialityUsage')->findAll();

        return $this->render('specialityusage/index.html.twig', array(
            'specialityUsages' => $specialityUsages,
        ));
    }

    /**
     * Creates a new SpecialityUsage entity.
     *
     * @Route("/new", name="specialityusage_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $specialityUsage = new SpecialityUsage();
        $form = $this->createForm('AppBundle\Form\SpecialityUsageType', $specialityUsage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($specialityUsage);
            $em->flush();

            return $this->redirectToRoute('specialityusage_show', array('id' => $specialityUsage->getId()));
        }

        return $this->render('specialityusage/new.html.twig', array(
            'specialityUsage' => $specialityUsage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SpecialityUsage entity.
     *
     * @Route("/{id}", name="specialityusage_show")
     * @Method("GET")
     */
    public function showAction(SpecialityUsage $specialityUsage)
    {
        $deleteForm = $this->createDeleteForm($specialityUsage);

        return $this->render('specialityusage/show.html.twig', array(
            'specialityUsage' => $specialityUsage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SpecialityUsage entity.
     *
     * @Route("/{id}/edit", name="specialityusage_edit")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SpecialityUsage $specialityUsage)
    {
        $deleteForm = $this->createDeleteForm($specialityUsage);
        $editForm = $this->createForm('AppBundle\Form\SpecialityUsageType', $specialityUsage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($specialityUsage);
            $em->flush();

            return $this->redirectToRoute('specialityusage_edit', array('id' => $specialityUsage->getId()));
        }

        return $this->render('specialityusage/edit.html.twig', array(
            'specialityUsage' => $specialityUsage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a SpecialityUsage entity.
     *
     * @Route("/{id}", name="specialityusage_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, SpecialityUsage $specialityUsage)
    {
        $form = $this->createDeleteForm($specialityUsage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($specialityUsage);
            $em->flush();
        }

        return $this->redirectToRoute('specialityusage_index');
    }

    /**
     * Creates a form to delete a SpecialityUsage entity.
     *
     * @param SpecialityUsage $specialityUsage The SpecialityUsage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SpecialityUsage $specialityUsage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('specialityusage_delete', array('id' => $specialityUsage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
