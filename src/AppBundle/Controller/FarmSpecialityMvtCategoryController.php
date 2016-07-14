<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\FarmSpecialityMvtCategory;
use AppBundle\Form\FarmSpecialityMvtCategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * FarmSpecialityMvtCategory controller.
 *
 * @Route("/farmspecialitymvtcategory")
 * @Security("has_role('ROLE_ADMIN')")
 *
 */
class FarmSpecialityMvtCategoryController extends Controller
{
    /**
     * Lists all FarmSpecialityMvtCategory entities.
     *
     * @Route("/", name="farmspecialitymvtcategory_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $farmSpecialityMvtCategories = $em->getRepository('AppBundle:FarmSpecialityMvtCategory')->findAll();

        return $this->render('farmspecialitymvtcategory/index.html.twig', array(
            'farmSpecialityMvtCategories' => $farmSpecialityMvtCategories,
        ));
    }

    /**
     * Creates a new FarmSpecialityMvtCategory entity.
     *
     * @Route("/new", name="farmspecialitymvtcategory_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $farmSpecialityMvtCategory = new FarmSpecialityMvtCategory();
        $form = $this->createForm('AppBundle\Form\FarmSpecialityMvtCategoryType', $farmSpecialityMvtCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($farmSpecialityMvtCategory);
            $em->flush();

            return $this->redirectToRoute('farmspecialitymvtcategory_show', array('id' => $farmSpecialityMvtCategory->getId()));
        }

        return $this->render('farmspecialitymvtcategory/new.html.twig', array(
            'farmSpecialityMvtCategory' => $farmSpecialityMvtCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FarmSpecialityMvtCategory entity.
     *
     * @Route("/{id}", name="farmspecialitymvtcategory_show")
     * @Method("GET")
     */
    public function showAction(FarmSpecialityMvtCategory $farmSpecialityMvtCategory)
    {
        $deleteForm = $this->createDeleteForm($farmSpecialityMvtCategory);

        return $this->render('farmspecialitymvtcategory/show.html.twig', array(
            'farmSpecialityMvtCategory' => $farmSpecialityMvtCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FarmSpecialityMvtCategory entity.
     *
     * @Route("/{id}/edit", name="farmspecialitymvtcategory_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FarmSpecialityMvtCategory $farmSpecialityMvtCategory)
    {
        $deleteForm = $this->createDeleteForm($farmSpecialityMvtCategory);
        $editForm = $this->createForm('AppBundle\Form\FarmSpecialityMvtCategoryType', $farmSpecialityMvtCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($farmSpecialityMvtCategory);
            $em->flush();

            return $this->redirectToRoute('farmspecialitymvtcategory_edit', array('id' => $farmSpecialityMvtCategory->getId()));
        }

        return $this->render('farmspecialitymvtcategory/edit.html.twig', array(
            'farmSpecialityMvtCategory' => $farmSpecialityMvtCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FarmSpecialityMvtCategory entity.
     *
     * @Route("/{id}", name="farmspecialitymvtcategory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FarmSpecialityMvtCategory $farmSpecialityMvtCategory)
    {
        $form = $this->createDeleteForm($farmSpecialityMvtCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($farmSpecialityMvtCategory);
            $em->flush();
        }

        return $this->redirectToRoute('farmspecialitymvtcategory_index');
    }

    /**
     * Creates a form to delete a FarmSpecialityMvtCategory entity.
     *
     * @param FarmSpecialityMvtCategory $farmSpecialityMvtCategory The FarmSpecialityMvtCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FarmSpecialityMvtCategory $farmSpecialityMvtCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('farmspecialitymvtcategory_delete', array('id' => $farmSpecialityMvtCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
