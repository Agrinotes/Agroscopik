<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\FarmSpeciality;
use AppBundle\Form\FarmSpecialityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;


/**
 * FarmSpeciality controller.
 *
 * @Route("/farmspeciality")
 * @Security("has_role('ROLE_USER')")
 */
class FarmSpecialityController extends Controller
{
    /**
     * Lists all FarmSpeciality entities.
     *
     * @Route("/", name="farmspeciality_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $farm= $this->getUser()->getFarm();

        $farmSpecialities = $em->getRepository('AppBundle:FarmSpeciality')->findAllForCurrentFarm($farm->getId());

        return $this->render('farmspeciality/index.html.twig', array(
            'farmSpecialities' => $farmSpecialities,
        ));
    }

    /**
     * Creates a new FarmSpeciality entity.
     *
     * @Route("/new", name="farmspeciality_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $farmSpeciality = new FarmSpeciality();

        // Get Entity Manager
        $em = $this->getDoctrine()->getManager();

        $farm = $this->getUser()->getFarm();
        $farm->addFarmSpeciality($farmSpeciality);


        $form = $this->createForm('AppBundle\Form\FarmSpecialityType', $farmSpeciality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($farmSpeciality);
            $em->flush();

            // Call ACL service
            $aclProvider = $this->get('security.acl.provider');

            // Create the ACL for current FarmSpeciality $farmSpeciality
            $objectIdentity = ObjectIdentity::fromDomainObject($farmSpeciality);
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

            $request->getSession()->getFlashBag()->add('success', 'Vous avez ajouté le produit '.$farmSpeciality->getSpeciality()->getName().' avec succès !');


            return $this->redirectToRoute('farmspeciality_index');
        }

        return $this->render('farmspeciality/new.html.twig', array(
            'farmSpeciality' => $farmSpeciality,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FarmSpeciality entity.
     *
     * @Route("/{id}", name="farmspeciality_show")
     * @Method("GET")
     */
    public function showAction(FarmSpeciality $farmSpeciality)
    {
        $deleteForm = $this->createDeleteForm($farmSpeciality);

        return $this->render('farmspeciality/show.html.twig', array(
            'farmSpeciality' => $farmSpeciality,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FarmSpeciality entity.
     * @Route("/{id}/edit", name="farmspeciality_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FarmSpeciality $farmSpeciality)
    {
        $deleteForm = $this->createDeleteForm($farmSpeciality);
        $editForm = $this->createForm('AppBundle\Form\FarmSpecialityType', $farmSpeciality);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($farmSpeciality);
            $em->flush();

            return $this->redirectToRoute('farmspeciality_edit', array('id' => $farmSpeciality->getId()));
        }

        return $this->render('farmspeciality/edit.html.twig', array(
            'farmSpeciality' => $farmSpeciality,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FarmSpeciality entity.
     * @Security("is_granted('DELETE', farmSpeciality) or has_role('ROLE_ADMIN')")
     * @Route("/{id}", name="farmspeciality_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FarmSpeciality $farmSpeciality)
    {
        $form = $this->createDeleteForm($farmSpeciality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($farmSpeciality);
            $em->flush();
        }

        return $this->redirectToRoute('farmspeciality_index');
    }

    /**
     * Creates a form to delete a FarmSpeciality entity.
     *
     * @param FarmSpeciality $farmSpeciality The FarmSpeciality entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FarmSpeciality $farmSpeciality)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('farmspeciality_delete', array('id' => $farmSpeciality->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
