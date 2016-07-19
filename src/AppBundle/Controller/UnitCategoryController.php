<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\UnitCategory;
use AppBundle\Form\UnitCategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * UnitCategory controller.
 *
 * @Route("/unitcategory")
 * @Security("has_role('ROLE_ADMIN')")
 */
class UnitCategoryController extends Controller
{
    /**
     * Lists all UnitCategory entities.
     *
     * @Route("/", name="unitcategory_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $unitCategories = $em->getRepository('AppBundle:UnitCategory')->findAll();

        return $this->render('unitcategory/index.html.twig', array(
            'unitCategories' => $unitCategories,
        ));
    }

    /**
     * Creates a new UnitCategory entity.
     *
     * @Route("/new", name="unitcategory_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $unitCategory = new UnitCategory();
        $form = $this->createForm('AppBundle\Form\UnitCategoryType', $unitCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($unitCategory);
            $em->flush();

            return $this->redirectToRoute('unitcategory_show', array('id' => $unitCategory->getId()));
        }

        return $this->render('unitcategory/new.html.twig', array(
            'unitCategory' => $unitCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a UnitCategory entity.
     *
     * @Route("/{id}", name="unitcategory_show")
     * @Method("GET")
     */
    public function showAction(UnitCategory $unitCategory)
    {
        $deleteForm = $this->createDeleteForm($unitCategory);

        return $this->render('unitcategory/show.html.twig', array(
            'unitCategory' => $unitCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing UnitCategory entity.
     *
     * @Route("/{id}/edit", name="unitcategory_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UnitCategory $unitCategory)
    {
        $deleteForm = $this->createDeleteForm($unitCategory);
        $editForm = $this->createForm('AppBundle\Form\UnitCategoryType', $unitCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($unitCategory);
            $em->flush();

            return $this->redirectToRoute('unitcategory_edit', array('id' => $unitCategory->getId()));
        }

        return $this->render('unitcategory/edit.html.twig', array(
            'unitCategory' => $unitCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a UnitCategory entity.
     *
     * @Route("/{id}", name="unitcategory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UnitCategory $unitCategory)
    {
        $form = $this->createDeleteForm($unitCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($unitCategory);
            $em->flush();
        }

        return $this->redirectToRoute('unitcategory_index');
    }

    /**
     * Creates a form to delete a UnitCategory entity.
     *
     * @param UnitCategory $unitCategory The UnitCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UnitCategory $unitCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('unitcategory_delete', array('id' => $unitCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
