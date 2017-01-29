<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Crop;
use AppBundle\Entity\CropCycle;
use AppBundle\Entity\InterventionCategory;
use AppBundle\Form\ActionCalendarType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Action;
use AppBundle\Form\ActionType;
use AppBundle\Form\ActionModalType;
use Symfony\Component\HttpFoundation\Response;
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
     * Creates a new Action entity from cropcycle_show.
     *
     * @Route("/action/new_from_calendar", name="action_new_from_calendar")
     * @Method({"GET", "POST"})
     */
    public function newFromCalendarAction(Request $request)
    {
        $action = new Action();

        // Get Entity Manager
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ActionCalendarType::class, $action, array(
        'action' => $this->generateUrl('action_new_from_calendar'),
        'method' => 'POST'
    ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Check for edit access
            $authorizationChecker = $this->get('security.authorization_checker');
            if (false === $authorizationChecker->isGranted('EDIT', $action->getCropCycle())) {
                throw new AccessDeniedException();
            }

            $em = $this->getDoctrine()->getManager();

            // Strange... Maybe not necessary
            $action->getCropCycle()->addAction($action);

            $em->persist($action);

            $em->flush();

            // Remove specialities added to wrong categories
            if ($action->getFarmSpecialityMvts() && $action->getIntervention()->getName() != 'Traitement phytosanitaire') {
                $mvts = $action->getFarmSpecialityMvts();
                foreach ($mvts as $mvt) {
                    $em->remove($mvt);
                }
                $em->flush();
            }

            // Remove fertilizers added to wrong categories
            if ($action->getFarmFertilizerMvts() && $action->getIntervention()->getInterventionCategory()->getSlug() != 'fertilisation') {
                $mvts = $action->getFarmFertilizerMvts();
                foreach ($mvts as $mvt) {
                    $em->remove($mvt);
                }
                $em->flush();
            }

            // Remove harvest products added to wrong categories
            if ($action->getIntervention()->getInterventionCategory()->getSlug() != 'recolte') {
                $products = $action->getHarvestProducts();
                foreach ($products as $product) {
                    $em->remove($product);
                }
                $em->flush();
            }

            // Remove seeds or plant density products added to wrong categories
            if ($action->getIntervention()->getInterventionCategory()->getSlug() != 'semis-et-plantation') {
                $action->setDensity(null);
                $action->setDensityUnit(null);
                $em->flush();
            }

            // Remove pH and EC added to wrong categories
            if ($action->getIntervention()->getName() != 'Relevé pH/EC') {
                $action->setPH(null);
                $action->setEc(null);
                $em->flush();
            }

            // Remove irrigations added to wrong categories
            if ($action->getIntervention()->getInterventionCategory()->getSlug() != 'irrigation') {
                $irrigations = $action->getIrrigations();
                foreach ($irrigations as $i) {
                    $em->remove($i);
                }
                $em->flush();
            }

            // Remove tank volume added to wrong intervention
            if ($action->getIntervention()->getName() != 'Préparation d\'une cuve de solution-mère') {
                $action->setTankVolume(null);
                $em->flush();
            }

            // Remove drainage added to wrong intervention
            if ($action->getIntervention()->getName() != 'Relevé de drainage') {
                $action->setDrainage(null);
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

            $request->getSession()->getFlashBag()->add('success', 'Une intervention ' . $action->getName() . ' a été ajoutée avec succès le ' . $action->getStartDatetime()->format('d/m/Y') . ' !');

            return $this->redirectToRoute('farm_calendar');
        }

        return $this->render('@App/action/new_from_calendar.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new Action entity from cropcycle_show.
     *
     * @Route("/cropcycle/{id}/action/new_from_cropcycle", name="action_new_from_cropcycle")
     * @Method({"GET", "POST"})
     */
    public function newFromCropCycleAction(Request $request, $id)
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
            if ($action->getFarmSpecialityMvts() && $action->getIntervention()->getInterventionCategory()->getSlug() != 'protection-des-cultures') {
                $mvts = $action->getFarmSpecialityMvts();
                foreach ($mvts as $mvt) {
                    $em->remove($mvt);
                }
                $em->flush();
            }

            // Remove fertilizers added to wrong categories
            if ($action->getFarmFertilizerMvts() && $action->getIntervention()->getInterventionCategory()->getSlug() != 'fertilisation') {
                $mvts = $action->getFarmFertilizerMvts();
                foreach ($mvts as $mvt) {
                    $em->remove($mvt);
                }
                $em->flush();
            }

            // Remove harvest products added to wrong categories
            if ($action->getIntervention()->getInterventionCategory()->getSlug() != 'recolte') {
                $products = $action->getHarvestProducts();
                foreach ($products as $product) {
                    $em->remove($product);
                }
                $em->flush();
            }

            // Remove seeds or plant density products added to wrong categories
            if ($action->getIntervention()->getInterventionCategory()->getSlug() != 'semis-et-plantation') {
                $action->setDensity(null);
                $action->setDensityUnit(null);
                $em->flush();
            }

            // Remove pH and EC added to wrong categories
            if ($action->getIntervention()->getName() != 'Relevé pH/EC') {
                $action->setPH(null);
                $action->setEc(null);
                $em->flush();
            }

            // Remove irrigations added to wrong categories
            if ($action->getIntervention()->getInterventionCategory()->getSlug() != 'irrigation') {
                $irrigations = $action->getIrrigations();
                foreach ($irrigations as $i) {
                    $em->remove($i);
                }
                $em->flush();
            }

            // Remove tank volume added to wrong intervention
            if ($action->getIntervention()->getName() != 'Préparation d\'une cuve de solution-mère') {
                $action->setTankVolume(null);
                $em->flush();
            }

            // Remove drainage added to wrong intervention
            if ($action->getIntervention()->getName() != 'Relevé de drainage') {
                $action->setDrainage(null);
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

            $request->getSession()->getFlashBag()->add('success', 'Une intervention ' . $action->getName() . ' a été ajoutée avec succès le ' . $action->getStartDatetime()->format('d/m/Y') . ' !');

            return $this->redirectToRoute('cropcycle_show', array('id' => $cropCycle->getId()));
        }

        return $this->render('@App/action/new.html.twig', array(
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
     * Finds and displays a Action entity.
     *
     * @Security("is_granted('VIEW', action) or is_granted('ROLE_ADMIN')")
     * @Route("/action/{id}/ajax", name="action_ajax_show", options = { "expose" = true })
     * @Method("GET")
     * @param Action $action
     * @return Response
     */
    public function showAjaxAction(Action $action)
    {
        $template = $this->renderView('AppBundle:action:show_ajax.html.twig',array(
            'action'=>$action
        ));
        return new JsonResponse(array('data' => $template));

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

            $request->getSession()->getFlashBag()->add('success', 'L\'intervention ' . $action->getName() . ' a été modifiée avec succès !');

            return $this->redirectToRoute('cropcycle_show', array('id' => $action->getCropCycle()->getId()));
        }

        return $this->render('@App/action/edit.html.twig', array(
            'action' => $action,
            'form' => $editForm->createView(),
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
            ->getForm();
    }

    /**
     * Deletes a Action entity.
     * @Security("is_granted('DELETE', action) or is_granted('ROLE_ADMIN')")
     * @Route("/action/delete/ajax/{id}", name="action_delete_ajax")
     */
    public function deleteAjaxAction(Request $request, Action $action)
    {

        // Must add ACL check here
        $em = $this->getDoctrine()->getManager();
        $em->remove($action);
        $em->flush();

        return $this->redirectToRoute('dashboard');

    }

}