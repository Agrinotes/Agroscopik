<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\FertilizersPriceUpdate;
use AppBundle\Form\FertilizersPriceUpdateType;

/**
 * FertilizersPriceUpdate controller.
 *
 * @Route("/fertilizerspriceupdate")
 */
class FertilizersPriceUpdateController extends Controller
{
    /**
     * Lists all FertilizersPriceUpdate entities.
     *
     * @Route("/", name="fertilizerspriceupdate_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fertilizersPriceUpdates = $em->getRepository('AppBundle:FertilizersPriceUpdate')->findAll();

        return $this->render('fertilizerspriceupdate/index.html.twig', array(
            'fertilizersPriceUpdates' => $fertilizersPriceUpdates,
        ));
    }

    /**
     * Creates a new FertilizersPriceUpdate entity.
     *
     * @Route("/new", name="fertilizerspriceupdate_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fertilizersPriceUpdate = new FertilizersPriceUpdate();
        $form = $this->createForm('AppBundle\Form\FertilizersPriceUpdateType', $fertilizersPriceUpdate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fertilizersPriceUpdate);
            $em->flush();

            return $this->redirectToRoute('fertilizerspriceupdate_show', array('id' => $fertilizersPriceUpdate->getId()));
        }

        return $this->render('fertilizerspriceupdate/new.html.twig', array(
            'fertilizersPriceUpdate' => $fertilizersPriceUpdate,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FertilizersPriceUpdate entity.
     *
     * @Route("/{id}", name="fertilizerspriceupdate_show")
     * @Method("GET")
     */
    public function showAction(FertilizersPriceUpdate $fertilizersPriceUpdate)
    {
        $deleteForm = $this->createDeleteForm($fertilizersPriceUpdate);

        return $this->render('fertilizerspriceupdate/show.html.twig', array(
            'fertilizersPriceUpdate' => $fertilizersPriceUpdate,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FertilizersPriceUpdate entity.
     *
     * @Route("/{id}/edit", name="fertilizerspriceupdate_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FertilizersPriceUpdate $fertilizersPriceUpdate)
    {
        $deleteForm = $this->createDeleteForm($fertilizersPriceUpdate);
        $editForm = $this->createForm('AppBundle\Form\FertilizersPriceUpdateType', $fertilizersPriceUpdate);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fertilizersPriceUpdate);
            $em->flush();

            return $this->redirectToRoute('fertilizerspriceupdate_edit', array('id' => $fertilizersPriceUpdate->getId()));
        }

        return $this->render('fertilizerspriceupdate/edit.html.twig', array(
            'fertilizersPriceUpdate' => $fertilizersPriceUpdate,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FertilizersPriceUpdate entity.
     *
     * @Route("/{id}", name="fertilizerspriceupdate_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FertilizersPriceUpdate $fertilizersPriceUpdate)
    {
        $form = $this->createDeleteForm($fertilizersPriceUpdate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fertilizersPriceUpdate);
            $em->flush();
        }

        return $this->redirectToRoute('fertilizerspriceupdate_index');
    }

    /**
     * Creates a form to delete a FertilizersPriceUpdate entity.
     *
     * @param FertilizersPriceUpdate $fertilizersPriceUpdate The FertilizersPriceUpdate entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FertilizersPriceUpdate $fertilizersPriceUpdate)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fertilizerspriceupdate_delete', array('id' => $fertilizersPriceUpdate->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
