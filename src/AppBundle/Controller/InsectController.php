<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Insect;
use AppBundle\Form\InsectType;

/**
 * Insect controller.
 *
 * @Route("/insect")
 */
class InsectController extends Controller
{
    /**
     * Lists all Insect entities.
     *
     * @Route("/", name="insect_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $insects = $em->getRepository('AppBundle:Insect')->findAll();

        return $this->render('insect/index.html.twig', array(
            'insects' => $insects,
        ));
    }

    /**
     * Creates a new Insect entity.
     *
     * @Route("/new", name="insect_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $insect = new Insect();
        $form = $this->createForm('AppBundle\Form\InsectType', $insect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($insect);
            $em->flush();

            return $this->redirectToRoute('insect_show', array('id' => $insect->getId()));
        }

        return $this->render('insect/new.html.twig', array(
            'insect' => $insect,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Insect entity.
     *
     * @Route("/{id}", name="insect_show")
     * @Method("GET")
     */
    public function showAction(Insect $insect)
    {
        $deleteForm = $this->createDeleteForm($insect);

        return $this->render('insect/show.html.twig', array(
            'insect' => $insect,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Insect entity.
     *
     * @Route("/{id}/edit", name="insect_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Insect $insect)
    {
        $deleteForm = $this->createDeleteForm($insect);
        $editForm = $this->createForm('AppBundle\Form\InsectType', $insect);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($insect);
            $em->flush();

            return $this->redirectToRoute('insect_edit', array('id' => $insect->getId()));
        }

        return $this->render('insect/edit.html.twig', array(
            'insect' => $insect,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Insect entity.
     *
     * @Route("/{id}", name="insect_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Insect $insect)
    {
        $form = $this->createDeleteForm($insect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($insect);
            $em->flush();
        }

        return $this->redirectToRoute('insect_index');
    }

    /**
     * Creates a form to delete a Insect entity.
     *
     * @param Insect $insect The Insect entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Insect $insect)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('insect_delete', array('id' => $insect->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
