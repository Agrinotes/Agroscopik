<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\FertilizerPrice;
use AppBundle\Form\FertilizerPriceType;

/**
 * FertilizerPrice controller.
 *
 * @Route("/fertilizerprice")
 */
class FertilizerPriceController extends Controller
{
    /**
     * Lists all FertilizerPrice entities.
     *
     * @Route("/", name="fertilizerprice_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fertilizerPrices = $em->getRepository('AppBundle:FertilizerPrice')->findAll();

        return $this->render('fertilizerprice/index.html.twig', array(
            'fertilizerPrices' => $fertilizerPrices,
        ));
    }

    /**
     * Creates a new FertilizerPrice entity.
     *
     * @Route("/new", name="fertilizerprice_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fertilizerPrice = new FertilizerPrice();
        $form = $this->createForm('AppBundle\Form\FertilizerPriceType', $fertilizerPrice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fertilizerPrice);
            $em->flush();

            return $this->redirectToRoute('fertilizerprice_show', array('id' => $fertilizerPrice->getId()));
        }

        return $this->render('fertilizerprice/new.html.twig', array(
            'fertilizerPrice' => $fertilizerPrice,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FertilizerPrice entity.
     *
     * @Route("/{id}", name="fertilizerprice_show")
     * @Method("GET")
     */
    public function showAction(FertilizerPrice $fertilizerPrice)
    {
        $deleteForm = $this->createDeleteForm($fertilizerPrice);

        return $this->render('fertilizerprice/show.html.twig', array(
            'fertilizerPrice' => $fertilizerPrice,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FertilizerPrice entity.
     *
     * @Route("/{id}/edit", name="fertilizerprice_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FertilizerPrice $fertilizerPrice)
    {
        $deleteForm = $this->createDeleteForm($fertilizerPrice);
        $editForm = $this->createForm('AppBundle\Form\FertilizerPriceType', $fertilizerPrice);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fertilizerPrice);
            $em->flush();

            return $this->redirectToRoute('fertilizerprice_edit', array('id' => $fertilizerPrice->getId()));
        }

        return $this->render('fertilizerprice/edit.html.twig', array(
            'fertilizerPrice' => $fertilizerPrice,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FertilizerPrice entity.
     *
     * @Route("/{id}", name="fertilizerprice_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FertilizerPrice $fertilizerPrice)
    {
        $form = $this->createDeleteForm($fertilizerPrice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fertilizerPrice);
            $em->flush();
        }

        return $this->redirectToRoute('fertilizerprice_index');
    }

    /**
     * Creates a form to delete a FertilizerPrice entity.
     *
     * @param FertilizerPrice $fertilizerPrice The FertilizerPrice entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FertilizerPrice $fertilizerPrice)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fertilizerprice_delete', array('id' => $fertilizerPrice->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
