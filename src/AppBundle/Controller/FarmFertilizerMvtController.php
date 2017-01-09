<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\FarmFertilizerMvt;
use AppBundle\Form\FarmFertilizerMvtType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * FarmFertilizerMvt controller.
 * @Security("has_role('ROLE_USER')")
 * @Route("/")
 */
class FarmFertilizerMvtController extends Controller
{
    /**
     * Lists all FarmFertilizerMvt entities.
     *
     * @Route("/farmfertilizermvt", name="farmfertilizermvt_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $farmFertilizerMvts = $em->getRepository('AppBundle:FarmFertilizerMvt')->findAll();

        return $this->render('farmfertilizermvt/index.html.twig', array(
            'farmFertilizerMvts' => $farmFertilizerMvts,
        ));
    }


    /**
     * Creates a new FarmFertilizerMvt entity.
     *
     * @Route("/farmfertilizer/{id}/mvt/new", name="farmfertilizermvt_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id)
    {
        $farmFertilizerMvt = new FarmFertilizerMvt();

        $em = $this->getDoctrine()->getManager();
        $fertilizer = $em->getRepository('AppBundle:FarmFertilizer')->find($id);
        $farmFertilizerMvt->setFertilizer($fertilizer);

        $form = $this->createForm('AppBundle\Form\FarmFertilizerMvtType', $farmFertilizerMvt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($farmFertilizerMvt);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Le stock de '.$fertilizer->getFertilizer()->getName().' a été mis à jour avec succès !');

            return $this->redirectToRoute('farmfertilizer_show', array('id' => $fertilizer->getId()));
        }

        return $this->render('farmfertilizermvt/new_modal.html.twig', array(
            'farmFertilizerMvt' => $farmFertilizerMvt,
            'farmFertilizer' => $fertilizer,
            'modal_form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FarmFertilizerMvt entity.
     *
     * @Route("/farmfertilizermvt/{id}", name="farmfertilizermvt_show")
     * @Method("GET")
     */
    public function showAction(FarmFertilizerMvt $farmFertilizerMvt)
    {
        $deleteForm = $this->createDeleteForm($farmFertilizerMvt);

        return $this->render('farmfertilizermvt/show.html.twig', array(
            'farmFertilizerMvt' => $farmFertilizerMvt,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FarmFertilizerMvt entity.
     *
     * @Route("/farmfertilizermvt/{id}/edit", name="farmfertilizermvt_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FarmFertilizerMvt $farmFertilizerMvt)
    {
        $deleteForm = $this->createDeleteForm($farmFertilizerMvt);
        $editForm = $this->createForm('AppBundle\Form\FarmFertilizerMvtType', $farmFertilizerMvt);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($farmFertilizerMvt);
            $em->flush();

            return $this->redirectToRoute('farmfertilizermvt_edit', array('id' => $farmFertilizerMvt->getId()));
        }

        return $this->render('farmfertilizermvt/edit.html.twig', array(
            'farmFertilizerMvt' => $farmFertilizerMvt,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FarmFertilizerMvt entity.
     *
     * @Route("/farmfertilizermvt/{id}", name="farmfertilizermvt_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FarmFertilizerMvt $farmFertilizerMvt)
    {
        $form = $this->createDeleteForm($farmFertilizerMvt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($farmFertilizerMvt);
            $em->flush();
        }

        return $this->redirectToRoute('farmfertilizermvt_index');
    }

    /**
     * Creates a form to delete a FarmFertilizerMvt entity.
     *
     * @param FarmFertilizerMvt $farmFertilizerMvt The FarmFertilizerMvt entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FarmFertilizerMvt $farmFertilizerMvt)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('farmfertilizermvt_delete', array('id' => $farmFertilizerMvt->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
