<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\FarmFertilizerMvtCategory;
use AppBundle\Form\FarmFertilizerMvtCategoryType;

/**
 * FarmFertilizerMvtCategory controller.
 *
 * @Route("/farmfertilizermvtcategory")
 */
class FarmFertilizerMvtCategoryController extends Controller
{
    /**
     * Lists all FarmFertilizerMvtCategory entities.
     *
     * @Route("/", name="farmfertilizermvtcategory_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $farmFertilizerMvtCategories = $em->getRepository('AppBundle:FarmFertilizerMvtCategory')->findAll();

        return $this->render('farmfertilizermvtcategory/index.html.twig', array(
            'farmFertilizerMvtCategories' => $farmFertilizerMvtCategories,
        ));
    }

    /**
     * Creates a new FarmFertilizerMvtCategory entity.
     *
     * @Route("/new", name="farmfertilizermvtcategory_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $farmFertilizerMvtCategory = new FarmFertilizerMvtCategory();
        $form = $this->createForm('AppBundle\Form\FarmFertilizerMvtCategoryType', $farmFertilizerMvtCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($farmFertilizerMvtCategory);
            $em->flush();

            return $this->redirectToRoute('farmfertilizermvtcategory_show', array('id' => $farmFertilizerMvtCategory->getId()));
        }

        return $this->render('farmfertilizermvtcategory/new.html.twig', array(
            'farmFertilizerMvtCategory' => $farmFertilizerMvtCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FarmFertilizerMvtCategory entity.
     *
     * @Route("/{id}", name="farmfertilizermvtcategory_show")
     * @Method("GET")
     */
    public function showAction(FarmFertilizerMvtCategory $farmFertilizerMvtCategory)
    {
        $deleteForm = $this->createDeleteForm($farmFertilizerMvtCategory);

        return $this->render('farmfertilizermvtcategory/show.html.twig', array(
            'farmFertilizerMvtCategory' => $farmFertilizerMvtCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FarmFertilizerMvtCategory entity.
     *
     * @Route("/{id}/edit", name="farmfertilizermvtcategory_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FarmFertilizerMvtCategory $farmFertilizerMvtCategory)
    {
        $deleteForm = $this->createDeleteForm($farmFertilizerMvtCategory);
        $editForm = $this->createForm('AppBundle\Form\FarmFertilizerMvtCategoryType', $farmFertilizerMvtCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($farmFertilizerMvtCategory);
            $em->flush();

            return $this->redirectToRoute('farmfertilizermvtcategory_edit', array('id' => $farmFertilizerMvtCategory->getId()));
        }

        return $this->render('farmfertilizermvtcategory/edit.html.twig', array(
            'farmFertilizerMvtCategory' => $farmFertilizerMvtCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FarmFertilizerMvtCategory entity.
     *
     * @Route("/{id}", name="farmfertilizermvtcategory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FarmFertilizerMvtCategory $farmFertilizerMvtCategory)
    {
        $form = $this->createDeleteForm($farmFertilizerMvtCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($farmFertilizerMvtCategory);
            $em->flush();
        }

        return $this->redirectToRoute('farmfertilizermvtcategory_index');
    }

    /**
     * Creates a form to delete a FarmFertilizerMvtCategory entity.
     *
     * @param FarmFertilizerMvtCategory $farmFertilizerMvtCategory The FarmFertilizerMvtCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FarmFertilizerMvtCategory $farmFertilizerMvtCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('farmfertilizermvtcategory_delete', array('id' => $farmFertilizerMvtCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
