<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\FarmSpecialityMvt;
use AppBundle\Form\FarmSpecialityMvtType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * FarmSpecialityMvt controller.
 *
 * @Route("/farmspecialitymvt")
 */
class FarmSpecialityMvtController extends Controller
{
    /**
     * Lists all FarmSpecialityMvt entities.
     *
     * @Route("/", name="farmspecialitymvt_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $farmSpecialityMvts = $em->getRepository('AppBundle:FarmSpecialityMvt')->findAll();

        return $this->render('farmspecialitymvt/index.html.twig', array(
            'farmSpecialityMvts' => $farmSpecialityMvts,
        ));
    }

    /**
     * Creates a new FarmSpecialityMvt entity.
     *
     * @Route("/new", name="farmspecialitymvt_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $farmSpecialityMvt = new FarmSpecialityMvt();
        $form = $this->createForm('AppBundle\Form\FarmSpecialityMvtType', $farmSpecialityMvt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($farmSpecialityMvt);
            $em->flush();

            return $this->redirectToRoute('farmspecialitymvt_show', array('id' => $farmSpecialityMvt->getId()));
        }

        return $this->render('farmspecialitymvt/new.html.twig', array(
            'farmSpecialityMvt' => $farmSpecialityMvt,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FarmSpecialityMvt entity.
     *
     * @Route("/{id}", name="farmspecialitymvt_show")
     * @Method("GET")
     */
    public function showAction(FarmSpecialityMvt $farmSpecialityMvt)
    {
        $deleteForm = $this->createDeleteForm($farmSpecialityMvt);

        return $this->render('farmspecialitymvt/show.html.twig', array(
            'farmSpecialityMvt' => $farmSpecialityMvt,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FarmSpecialityMvt entity.
     *
     * @Route("/{id}/edit", name="farmspecialitymvt_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FarmSpecialityMvt $farmSpecialityMvt)
    {
        $deleteForm = $this->createDeleteForm($farmSpecialityMvt);
        $editForm = $this->createForm('AppBundle\Form\FarmSpecialityMvtType', $farmSpecialityMvt);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($farmSpecialityMvt);
            $em->flush();

            return $this->redirectToRoute('farmspecialitymvt_edit', array('id' => $farmSpecialityMvt->getId()));
        }

        return $this->render('farmspecialitymvt/edit.html.twig', array(
            'farmSpecialityMvt' => $farmSpecialityMvt,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FarmSpecialityMvt entity.
     *
     * @Route("/{id}", name="farmspecialitymvt_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FarmSpecialityMvt $farmSpecialityMvt)
    {
        $form = $this->createDeleteForm($farmSpecialityMvt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($farmSpecialityMvt);
            $em->flush();
        }

        return $this->redirectToRoute('farmspecialitymvt_index');
    }

    /**
     * Creates a form to delete a FarmSpecialityMvt entity.
     *
     * @param FarmSpecialityMvt $farmSpecialityMvt The FarmSpecialityMvt entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FarmSpecialityMvt $farmSpecialityMvt)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('farmspecialitymvt_delete', array('id' => $farmSpecialityMvt->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
