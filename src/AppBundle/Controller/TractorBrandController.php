<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TractorBrand;
use AppBundle\Form\TractorBrandType;

/**
 * TractorBrand controller.
 *
 * @Route("/tractorbrand")
 */
class TractorBrandController extends Controller
{
    /**
     * Lists all TractorBrand entities.
     *
     * @Route("/", name="tractorbrand_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tractorBrands = $em->getRepository('AppBundle:TractorBrand')->findAll();

        return $this->render('tractorbrand/index.html.twig', array(
            'tractorBrands' => $tractorBrands,
        ));
    }

    /**
     * Creates a new TractorBrand entity.
     *
     * @Route("/new", name="tractorbrand_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tractorBrand = new TractorBrand();
        $form = $this->createForm('AppBundle\Form\TractorBrandType', $tractorBrand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tractorBrand);
            $em->flush();

            return $this->redirectToRoute('tractorbrand_show', array('id' => $tractorBrand->getId()));
        }

        return $this->render('tractorbrand/new.html.twig', array(
            'tractorBrand' => $tractorBrand,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TractorBrand entity.
     *
     * @Route("/{id}", name="tractorbrand_show")
     * @Method("GET")
     */
    public function showAction(TractorBrand $tractorBrand)
    {
        $deleteForm = $this->createDeleteForm($tractorBrand);

        return $this->render('tractorbrand/show.html.twig', array(
            'tractorBrand' => $tractorBrand,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TractorBrand entity.
     *
     * @Route("/{id}/edit", name="tractorbrand_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TractorBrand $tractorBrand)
    {
        $deleteForm = $this->createDeleteForm($tractorBrand);
        $editForm = $this->createForm('AppBundle\Form\TractorBrandType', $tractorBrand);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tractorBrand);
            $em->flush();

            return $this->redirectToRoute('tractorbrand_edit', array('id' => $tractorBrand->getId()));
        }

        return $this->render('tractorbrand/edit.html.twig', array(
            'tractorBrand' => $tractorBrand,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TractorBrand entity.
     *
     * @Route("/{id}", name="tractorbrand_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TractorBrand $tractorBrand)
    {
        $form = $this->createDeleteForm($tractorBrand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tractorBrand);
            $em->flush();
        }

        return $this->redirectToRoute('tractorbrand_index');
    }

    /**
     * Creates a form to delete a TractorBrand entity.
     *
     * @param TractorBrand $tractorBrand The TractorBrand entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TractorBrand $tractorBrand)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tractorbrand_delete', array('id' => $tractorBrand->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
