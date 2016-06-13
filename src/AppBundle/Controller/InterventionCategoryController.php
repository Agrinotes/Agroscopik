<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\InterventionCategory;
use AppBundle\Form\InterventionCategoryType;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * InterventionCategory controller.
 *
 * @Route("/interventioncategory")
 */
class InterventionCategoryController extends Controller
{
    /**
     * Lists all InterventionCategory entities.
     *
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/", name="interventioncategory_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $interventionCategories = $em->getRepository('AppBundle:InterventionCategory')->findAll();

        return $this->render('@App/interventioncategory/index.html.twig', array(
            'interventionCategories' => $interventionCategories,
        ));
    }

    /**
     * Creates a new InterventionCategory entity.
     *
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/new", name="interventioncategory_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $interventionCategory = new InterventionCategory();
        $form = $this->createForm('AppBundle\Form\InterventionCategoryType', $interventionCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($interventionCategory);
            $em->flush();

            return $this->redirectToRoute('interventioncategory_show', array('id' => $interventionCategory->getId()));
        }

        return $this->render('@App/interventioncategory/new.html.twig', array(
            'interventionCategory' => $interventionCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a InterventionCategory entity.
     *
     * @Security("is_granted('ROLE_USER)")
     * @Route("/{id}", name="interventioncategory_show")
     * @Method("GET")
     */
    public function showAction(InterventionCategory $interventionCategory)
    {
        $deleteForm = $this->createDeleteForm($interventionCategory);

        return $this->render('@App/interventioncategory/show.html.twig', array(
            'interventionCategory' => $interventionCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing InterventionCategory entity.
     *
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}/edit", name="interventioncategory_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, InterventionCategory $interventionCategory)
    {
        $deleteForm = $this->createDeleteForm($interventionCategory);
        $editForm = $this->createForm('AppBundle\Form\InterventionCategoryType', $interventionCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($interventionCategory);
            $em->flush();

            return $this->redirectToRoute('interventioncategory_show', array('id' => $interventionCategory->getId()));
        }

        return $this->render('@App/interventioncategory/edit.html.twig', array(
            'interventionCategory' => $interventionCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a InterventionCategory entity.
     *
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}", name="interventioncategory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, InterventionCategory $interventionCategory)
    {
        $form = $this->createDeleteForm($interventionCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($interventionCategory);
            $em->flush();
        }

        return $this->redirectToRoute('interventioncategory_index');
    }

    /**
     * Creates a form to delete a InterventionCategory entity.
     *
     * @param InterventionCategory $interventionCategory The InterventionCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(InterventionCategory $interventionCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('interventioncategory_delete', array('id' => $interventionCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
