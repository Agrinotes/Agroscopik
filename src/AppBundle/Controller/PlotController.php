<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Plot;
use AppBundle\Form\PlotType;

/**
 * Plot controller.
 *
 * @Route("/plot")
 */
class PlotController extends Controller
{
    /**
     * Lists all Plot entities.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/", name="plot_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plots = $em->getRepository('AppBundle:Plot')->findAll();

        return $this->render('plot/index.html.twig', array(
            'plots' => $plots,
        ));
    }

    /**
     * Creates a new Plot entity.
     *
     * @Route("/new", name="plot_new")
     * @Security("has_role('ROLE_FARMER')")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser();
        $farm = $user->getFarm();

        $plot = new Plot();
        $form = $this->createForm('AppBundle\Form\PlotType', $plot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($plot);
            $em->flush();

            return $this->redirectToRoute('plot_show', array('id' => $plot->getId()));
        }

        return $this->render('plot/new.html.twig', array(
            'plot' => $plot,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Plot entity.
     *
     * @Route("/{id}", name="plot_show")
     * @Method("GET")
     */
    public function showAction(Plot $plot)
    {
        $deleteForm = $this->createDeleteForm($plot);

        return $this->render('plot/show.html.twig', array(
            'plot' => $plot,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Plot entity.
     *
     * @Route("/{id}/edit", name="plot_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Plot $plot)
    {
        $deleteForm = $this->createDeleteForm($plot);
        $editForm = $this->createForm('AppBundle\Form\PlotType', $plot);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($plot);
            $em->flush();

            return $this->redirectToRoute('plot_edit', array('id' => $plot->getId()));
        }

        return $this->render('plot/edit.html.twig', array(
            'plot' => $plot,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Plot entity.
     *
     * @Route("/{id}", name="plot_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Plot $plot)
    {
        $form = $this->createDeleteForm($plot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($plot);
            $em->flush();
        }

        return $this->redirectToRoute('plot_index');
    }

    /**
     * Creates a form to delete a Plot entity.
     *
     * @param Plot $plot The Plot entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Plot $plot)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plot_delete', array('id' => $plot->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
