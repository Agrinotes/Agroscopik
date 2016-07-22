<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Crop;
use AppBundle\Entity\CropCycle;
use AppBundle\Entity\InterventionCategory;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Action;
use AppBundle\Form\ActionType;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Action controller.
 *
 * @Security("has_role('ROLE_USER')")
 * @Route("/")
 */
class ActionController extends Controller
{
    /**
     * Lists all Action entities for a specific crop cycle
     *
     * @Route("/cropcycle/{id}/action", name="action_index")
     * @Method("GET")
     */
    public function indexAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $cropCycle = $this->getDoctrine()->getManager()->getRepository('AppBundle:CropCycle')->find($id);

        // Check for edit access
        $authorizationChecker = $this->get('security.authorization_checker');
        if (false === $authorizationChecker->isGranted('VIEW', $cropCycle)) {
            throw new AccessDeniedException();
        }

        // Find actions for current cropCycle
        $actions = $em->getRepository('AppBundle:Action')->findByCropCycle($id);

        return $this->render('@App/action/index.html.twig', array(
            'actions' => $actions,
            'cropCycle' => $cropCycle,
        ));
    }

    /**
     * Lists all Action entities for a specific intervention category
     *
     * @Route("/action/category/{id}", name="action_by_category")
     * @Method("GET")
     */
    public function listByCategoryAction(Request $request, InterventionCategory $id)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $this->getDoctrine()->getManager()->getRepository('AppBundle:InterventionCategory')->find($id);

        // Find actions for current intervention category
        $actions = $em->getRepository('AppBundle:Action')->findByInterventionCategory($id);

        return $this->render('@App/action/listByCategory.html.twig', array(
            'actions' => $actions,
            'category' => $category,
        ));
    }

    /**
     * Lists all Action entities for a specific crop
     *
     * @Route("/action/crop/{id}", name="action_by_crop")
     * @Method("GET")
     */
    public function listByCropAction(Request $request, Crop $id)
    {
        $em = $this->getDoctrine()->getManager();

        $crop = $this->getDoctrine()->getManager()->getRepository('AppBundle:Crop')->find($id);

        // Find actions for current intervention category
        $actions = $em->getRepository('AppBundle:Action')->findByCrop($id);

        return $this->render('@App/action/listByCrop.html.twig', array(
            'actions' => $actions,
            'crop' => $crop,
        ));
    }

    /**
     * Creates a new Action entity.
     *
     * @Route("/cropcycle/{id}/action/new", name="action_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id)
    {
        $action = new Action();

        // Get Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Get current cropCycle
        $cropCycle = $em->getRepository('AppBundle:CropCycle')->find($id);

        // Check for edit access
        $authorizationChecker = $this->get('security.authorization_checker');
        if (false === $authorizationChecker->isGranted('EDIT', $cropCycle)) {
            throw new AccessDeniedException();
        }

        // Link this action to current crop cycle
        $cropCycle->addAction($action); // Which also setCropcycle($this) on $action

        $form = $this->createForm(ActionType::class, $action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($action);

            $em->flush();

            // Remove specialities added to wrong categories
            if($action->getIntervention()->getInterventionCategory()->getSlug() != 'protection-des-cultures'){
                $mvts = $action->getFarmSpecialityMvts();
                foreach($mvts as $mvt){
                    $em->remove($mvt);
                }
                $em->flush();
            }

            // Remove harvest products added to wrong categories
            if($action->getIntervention()->getInterventionCategory()->getSlug() != 'recolte'){
                $products = $action->getHarvestProducts();
                foreach($products as $product){
                    $em->remove($product);
                }
                $em->flush();
            }

            // Remove harvest products added to wrong categories
            if($action->getIntervention()->getInterventionCategory()->getSlug() != 'semis-et-plantation'){
                $action->setDensity("");
                $action->setDensityUnit("");
                $em->flush();
            }

            // Call ACL service
            $aclProvider = $this->get('security.acl.provider');

            // Create the ACL for current Action $action
            $objectIdentity = ObjectIdentity::fromDomainObject($action);
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

            $request->getSession()->getFlashBag()->add('success', 'Une intervention '.$action->getName().' a été ajoutée avec succès le '.$action->getStartDatetime()->format('d/m/Y').' !');

            return $this->redirectToRoute('action_new', array('id' => $action->getCropCycle()->getId()));
        }

        return $this->render('@App/action/new2.html.twig', array(
            'cropCycle' => $cropCycle,
            'action' => $action,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Action entity.
     *
     * @Security("is_granted('VIEW', action) or is_granted('ROLE_ADMIN')")
     * @Route("/action/{id}", name="action_show")
     * @Method("GET")
     */
    public function showAction(Action $action)
    {
        $deleteForm = $this->createDeleteForm($action);

        return $this->render('@App/action/show.html.twig', array(
            'action' => $action,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Action entity.
     *
     * @Security("is_granted('EDIT', action) or is_granted('ROLE_ADMIN')")
     * @Route("/action/{id}/edit", name="action_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Action $action)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $deleteForm = $this->createDeleteForm($action);

        $originalPeriods = new ArrayCollection();

        // Create an ArrayCollection of the current Action->periods objects in the database
        foreach ($action->getPeriods() as $period) {
            $originalPeriods->add($period);
        }

        $editForm = $this->createForm('AppBundle\Form\ActionEditType', $action);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // remove the relationship between the Period and the Action
            foreach ($originalPeriods as $period) {
                if (false === $action->getPeriods()->contains($period)) {
                    $em->remove($period);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($action);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'L\'intervention '.$action->getName().' a été modifiée avec succès !');

            return $this->redirectToRoute('action_show', array('id' => $action->getId()));
        }

        return $this->render('@App/action/edit.html.twig', array(
            'action' => $action,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Action entity.
     *
     *
     * @Route("/action/delete/{id}", name="action_delete")
     * @Security("is_granted('DELETE', action) or is_granted('ROLE_ADMIN')")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Action $action)
    {
        $form = $this->createDeleteForm($action);
        $form->handleRequest($request);

        $id = $action->getCropCycle()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($action);
            $em->flush();
        }

        return $this->redirectToRoute('cropcycle_show', array('id' => $id));
    }

    /**
     * Creates a form to delete a Action entity.
     *
     * @param Action $action The Action entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Action $action)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('action_delete', array('id' => $action->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}