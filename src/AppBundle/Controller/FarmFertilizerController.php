<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\FarmFertilizer;
use AppBundle\Form\FarmFertilizerType;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * FarmFertilizer controller.
 *
 * @Route("/farmfertilizer")
 */
class FarmFertilizerController extends Controller
{
    /**
     * Lists all FarmFertilizer entities.
     *
     * @Route("/", name="farmfertilizer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $farm= $this->getUser()->getFarm();

        $farmFertilizers = $em->getRepository('AppBundle:FarmFertilizer')->findAllForCurrentFarm($farm->getId());

        return $this->render('farmfertilizer/index.html.twig', array(
            'farmFertilizers' => $farmFertilizers,
        ));
    }

    /**
     * Creates a new FarmFertilizer entity.
     *
     * @Route("/new", name="farmfertilizer_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $farmFertilizer = new FarmFertilizer();

        // Get Entity Manager
        $em = $this->getDoctrine()->getManager();

        $farm = $this->getUser()->getFarm();

        $farm->addFarmFertilizer($farmFertilizer);



        $form = $this->createForm('AppBundle\Form\FarmFertilizerType', $farmFertilizer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($farmFertilizer);
            $em->flush();

            // Call ACL service
            $aclProvider = $this->get('security.acl.provider');

            // Create the ACL for current FarmSpeciality $farmSpeciality
            $objectIdentity = ObjectIdentity::fromDomainObject($farmFertilizer);
            $acl = $aclProvider->createAcl($objectIdentity);

            // Retrieve the security identity of the current user
            $securityIdentity = UserSecurityIdentity::fromAccount($this->getUser());

            // Create Access Mask
            $builder = new MaskBuilder();
            $builder
                ->add('view')
                ->add('edit')
                ->add('delete');
            $mask = $builder->get();

            // Insert Object Access Entry
            $acl->insertObjectAce($securityIdentity, $mask);

            // Update ACL
            $aclProvider->updateAcl($acl);

            $request->getSession()->getFlashBag()->add('success', 'Vous avez ajouté l\''.$farmFertilizer->getFertilizer()->getType().' '.$farmFertilizer->getFertilizer()->getName().' avec succès !');



            return $this->redirectToRoute('farmfertilizer_index');
        }

        return $this->render('farmfertilizer/new.html.twig', array(
            'farmFertilizer' => $farmFertilizer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FarmFertilizer entity.
     *
     * @Route("/{id}", name="farmfertilizer_show")
     * @Method("GET")
     */
    public function showAction(FarmFertilizer $farmFertilizer)
    {
        $deleteForm = $this->createDeleteForm($farmFertilizer);

        return $this->render('farmfertilizer/show.html.twig', array(
            'farmFertilizer' => $farmFertilizer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FarmFertilizer entity.
     *
     * @Route("/{id}/edit", name="farmfertilizer_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FarmFertilizer $farmFertilizer)
    {
        $deleteForm = $this->createDeleteForm($farmFertilizer);
        $editForm = $this->createForm('AppBundle\Form\FarmFertilizerEditType', $farmFertilizer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($farmFertilizer);
            $em->flush();

            return $this->redirectToRoute('farmfertilizer_edit', array('id' => $farmFertilizer->getId()));
        }

        return $this->render('farmfertilizer/edit.html.twig', array(
            'farmFertilizer' => $farmFertilizer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FarmFertilizer entity.
     *
     * @Route("/{id}", name="farmfertilizer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FarmFertilizer $farmFertilizer)
    {
        $form = $this->createDeleteForm($farmFertilizer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($farmFertilizer);
            $em->flush();
        }

        return $this->redirectToRoute('farmfertilizer_index');
    }

    /**
     * Creates a form to delete a FarmFertilizer entity.
     *
     * @param FarmFertilizer $farmFertilizer The FarmFertilizer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FarmFertilizer $farmFertilizer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('farmfertilizer_delete', array('id' => $farmFertilizer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
