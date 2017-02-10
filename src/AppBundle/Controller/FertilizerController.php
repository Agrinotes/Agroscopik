<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FarmFertilizer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Fertilizer;
use AppBundle\Form\FertilizerType;

/**
 * Fertilizer controller.
 *
 * @Route("/fertilizer")
 */
class FertilizerController extends Controller
{
    /**
     * Lists all Fertilizer entities.
     *
     * @Route("/", name="fertilizer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fertilizers = $em->getRepository('AppBundle:Fertilizer')->findAll();

        return $this->render('fertilizer/index.html.twig', array(
            'fertilizers' => $fertilizers,
        ));
    }

    /**
     * Creates a new Fertilizer entity.
     *
     * @Route("/new_from_index", name="fertilizer_new_from_index")
     * @Method({"GET", "POST"})
     */
    public function newFromIndexAction(Request $request)
    {
        $fertilizer = new Fertilizer();
        $form = $this->createForm('AppBundle\Form\FertilizerType', $fertilizer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fertilizer);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'L\'engrais ou amendement '.$fertilizer->getName().' a été ajouté avec succès ! Vous pouvez désormais l\'ajouter dans votre stock d\'engrais.');

            return $this->redirectToRoute('fertilizer_index');
        }

        return $this->render('fertilizer/new.html.twig', array(
            'fertilizer' => $fertilizer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new Fertilizer entity.
     *
     * @Route("/new", name="fertilizer_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fertilizer = new Fertilizer();
        $form = $this->createForm('AppBundle\Form\FertilizerType', $fertilizer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fertilizer);
            $em->flush();

            // Add a farmSpeciality automatically
            $farm = $this->getUser()->getFarm();
            if(is_object($farm)){
                $farmFertilizer = new FarmFertilizer();
                $farmFertilizer->setFarm($farm);
                $farmFertilizer->setFertilizer($fertilizer);
                $em->persist($farmFertilizer);
                $em->flush();
            };

            $request->getSession()->getFlashBag()->add('success', 'L\'engrais ou amendement '.$fertilizer->getName().' a été ajouté avec succès ! Vous pouvez désormais l\'ajouter dans votre stock d\'engrais.');

            return $this->redirectToRoute('farmfertilizer_index');
        }

        return $this->render('fertilizer/new.html.twig', array(
            'fertilizer' => $fertilizer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Fertilizer entity.
     *
     * @Route("/{id}", name="fertilizer_show")
     * @Method("GET")
     */
    public function showAction(Fertilizer $fertilizer)
    {
        $deleteForm = $this->createDeleteForm($fertilizer);

        return $this->render('fertilizer/show.html.twig', array(
            'fertilizer' => $fertilizer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a Fertilizer entity.
     *
     * @Route("/{id}/composition", name="fertilizer_composition_show")
     * @Method("GET")
     */
    public function showCompositionAction(Fertilizer $fertilizer)
    {
        $deleteForm = $this->createDeleteForm($fertilizer);

        return $this->render('fertilizer/show_composition.html.twig', array(
            'fertilizer' => $fertilizer,
        ));
    }

    /**
     * Displays a form to edit an existing Fertilizer entity.
     *
     * @Route("/{id}/edit", name="fertilizer_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Fertilizer $fertilizer)
    {
        $deleteForm = $this->createDeleteForm($fertilizer);
        $editForm = $this->createForm('AppBundle\Form\FertilizerType', $fertilizer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fertilizer);
            $em->flush();

            return $this->redirectToRoute('fertilizer_edit', array('id' => $fertilizer->getId()));
        }

        return $this->render('fertilizer/edit.html.twig', array(
            'fertilizer' => $fertilizer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Fertilizer entity.
     *
     * @Route("/{id}", name="fertilizer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Fertilizer $fertilizer)
    {
        $form = $this->createDeleteForm($fertilizer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fertilizer);
            $em->flush();
        }

        return $this->redirectToRoute('fertilizer_index');
    }

    /**
     * Creates a form to delete a Fertilizer entity.
     *
     * @param Fertilizer $fertilizer The Fertilizer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fertilizer $fertilizer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fertilizer_delete', array('id' => $fertilizer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
