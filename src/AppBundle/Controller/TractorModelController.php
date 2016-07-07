<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TractorModel;
use AppBundle\Form\TractorModelType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * TractorBrand controller.
 *
 * @Route("/tractormodel")
 * @Security("has_role('ROLE_ADMIN')")
 */
class TractorModelController extends Controller
{
    /**
     * Lists all TractorModel entities.
     *
     * @Route("/", name="tractormodel_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tractorModels = $em->getRepository('AppBundle:TractorModel')->findAll();

        return $this->render('@App/tractormodel/index.html.twig', array(
            'tractorModels' => $tractorModels,
        ));
    }

    /**
     * Creates a new TractorModel entity.
     *
     * @Route("/new", name="tractormodel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tractorModel = new TractorModel();
        $form = $this->createForm('AppBundle\Form\TractorModelType', $tractorModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tractorModel);
            $em->flush();

            return $this->redirectToRoute('tractormodel_show', array('id' => $tractorModel->getId()));
        }

        return $this->render('@App/tractormodel/new.html.twig', array(
            'tractorModel' => $tractorModel,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TractorModel entity.
     *
     * @Route("/{id}", name="tractormodel_show")
     * @Method("GET")
     */
    public function showAction(TractorModel $tractorModel)
    {
        $deleteForm = $this->createDeleteForm($tractorModel);

        return $this->render('@App/tractormodel/show.html.twig', array(
            'tractorModel' => $tractorModel,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TractorModel entity.
     *
     * @Route("/{id}/edit", name="tractormodel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TractorModel $tractorModel)
    {
        $deleteForm = $this->createDeleteForm($tractorModel);
        $editForm = $this->createForm('AppBundle\Form\TractorModelType', $tractorModel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tractorModel);
            $em->flush();

            return $this->redirectToRoute('tractormodel_edit', array('id' => $tractorModel->getId()));
        }

        return $this->render('@App/tractor/edit.html.twig', array(
            'tractorModel' => $tractorModel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TractorModel entity.
     *
     * @Route("/{id}", name="tractormodel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TractorModel $tractorModel)
    {
        $form = $this->createDeleteForm($tractorModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tractorModel);
            $em->flush();
        }

        return $this->redirectToRoute('tractormodel_index');
    }

    /**
     * Creates a form to delete a TractorBrand entity.
     *
     * @param TractorModel $tractorModel The TractorModelentity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TractorModel $tractorModel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tractormodel_delete', array('id' => $tractorModel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
