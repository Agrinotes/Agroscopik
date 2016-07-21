<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\HarvestProduct;
use AppBundle\Form\HarvestProductType;

/**
 * HarvestProduct controller.
 *
 * @Route("/harvestproduct")
 */
class HarvestProductController extends Controller
{
    /**
     * Lists all HarvestProduct entities.
     *
     * @Route("/", name="harvestproduct_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $harvestProducts = $em->getRepository('AppBundle:HarvestProduct')->findAll();

        return $this->render('harvestproduct/index.html.twig', array(
            'harvestProducts' => $harvestProducts,
        ));
    }

    /**
     * Creates a new HarvestProduct entity.
     *
     * @Route("/new", name="harvestproduct_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $harvestProduct = new HarvestProduct();
        $form = $this->createForm('AppBundle\Form\HarvestProductType', $harvestProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($harvestProduct);
            $em->flush();

            return $this->redirectToRoute('harvestproduct_show', array('id' => $harvestProduct->getId()));
        }

        return $this->render('harvestproduct/new.html.twig', array(
            'harvestProduct' => $harvestProduct,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a HarvestProduct entity.
     *
     * @Route("/{id}", name="harvestproduct_show")
     * @Method("GET")
     */
    public function showAction(HarvestProduct $harvestProduct)
    {
        $deleteForm = $this->createDeleteForm($harvestProduct);

        return $this->render('harvestproduct/show.html.twig', array(
            'harvestProduct' => $harvestProduct,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing HarvestProduct entity.
     *
     * @Route("/{id}/edit", name="harvestproduct_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, HarvestProduct $harvestProduct)
    {
        $deleteForm = $this->createDeleteForm($harvestProduct);
        $editForm = $this->createForm('AppBundle\Form\HarvestProductType', $harvestProduct);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($harvestProduct);
            $em->flush();

            return $this->redirectToRoute('harvestproduct_edit', array('id' => $harvestProduct->getId()));
        }

        return $this->render('harvestproduct/edit.html.twig', array(
            'harvestProduct' => $harvestProduct,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a HarvestProduct entity.
     *
     * @Route("/{id}", name="harvestproduct_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, HarvestProduct $harvestProduct)
    {
        $form = $this->createDeleteForm($harvestProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($harvestProduct);
            $em->flush();
        }

        return $this->redirectToRoute('harvestproduct_index');
    }

    /**
     * Creates a form to delete a HarvestProduct entity.
     *
     * @param HarvestProduct $harvestProduct The HarvestProduct entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(HarvestProduct $harvestProduct)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('harvestproduct_delete', array('id' => $harvestProduct->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
