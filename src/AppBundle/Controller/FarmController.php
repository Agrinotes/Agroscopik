<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Farm;
use AppBundle\Form\FarmType;

/**
 * Farm controller.
 *
 * @Route("/farm")
 */
class FarmController extends Controller
{
    /**
     * Lists all Farm entities.
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/list", name="farm_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $farms = $em->getRepository('AppBundle:Farm')->findAll();

        return $this->render('farm/index.html.twig', array(
            'farms' => $farms,
        ));
    }

    /**
     * Creates a new Farm entity.
     *
     * @Security("has_role('ROLE_USER')")
     * @Route("/new", name="farm_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $farm = new Farm();

        $user = $this->getUser();
        $user->addRole('ROLE_FARMER');

        $form = $this->createForm('AppBundle\Form\FarmType', $farm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($farm);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('farm_show', array('id' => $farm->getId()));
        }

        return $this->render('farm/new.html.twig', array(
            'farm' => $farm,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Farm entity.
     *
     * @Route("/{id}", name="farm_show")
     * @Method("GET")
     */
    public function showAction(Farm $farm)
    {
        $deleteForm = $this->createDeleteForm($farm);

        return $this->render('farm/show.html.twig', array(
            'farm' => $farm,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Farm entity.
     *
     * @Route("/{id}/edit", name="farm_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Farm $farm)
    {
        $deleteForm = $this->createDeleteForm($farm);
        $editForm = $this->createForm('AppBundle\Form\FarmType', $farm);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($farm);
            $em->flush();

            return $this->redirectToRoute('farm_edit', array('id' => $farm->getId()));
        }

        return $this->render('farm/edit.html.twig', array(
            'farm' => $farm,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Farm entity.
     *
     * @Route("/{id}", name="farm_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Farm $farm)
    {
        $form = $this->createDeleteForm($farm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($farm);
            $em->flush();
        }

        return $this->redirectToRoute('farm_index');
    }

    /**
     * Creates a form to delete a Farm entity.
     *
     * @param Farm $farm The Farm entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Farm $farm)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('farm_delete', array('id' => $farm->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
