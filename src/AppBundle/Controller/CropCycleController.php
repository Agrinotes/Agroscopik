<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Plot;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\CropCycle;
use AppBundle\Form\CropCycleType;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * CropCycle controller.
 *
 * @Security("has_role('ROLE_FARMER')")
 */
class CropCycleController extends Controller
{




    /**
     * Lists all CropCycle entities for a specific plot and a campaign
     * .
     * @Route("/parcelle/{id}/cultures/campagne/{year}", name="cropcycle_index", requirements={"year" = "\d+"}, defaults={"year" = 2016})
     * @Method("GET")
     */
    public function indexAction(Request $request, $id, $year)
    {
        $em = $this->getDoctrine()->getManager();

        // Get current plot
        $plot = $this->getDoctrine()->getManager()->getRepository('AppBundle:Plot')->find($id);

        // Create campaign date
        $startCampaignDate    =   \DateTime::createFromFormat("Y-m-d H:i:s",$year."-01-01 00:00:00");
        $endCampaignDate    =   \DateTime::createFromFormat("Y-m-d H:i:s",$year."-12-31 23:59:59");

        $cropCycles = $em->getRepository('AppBundle:CropCycle')->findBy(array('plot' => $plot));

        return $this->render('@App/cropcycle/index.html.twig', array(
            'plot' => $plot,
            'cropCycles' => $cropCycles,
            'startCampaignDate' => $startCampaignDate,
            'endCampaignDate' => $endCampaignDate,


        ));
    }

    /**
     * Lists all CropCycle entities for a specific crop and campaign on all plots
     * .
     * @Route("/culture/{id}/campagne/{year}", name="cropcycle_cropcampaign_index", requirements={"year" = "\d+"}, defaults={"year" = 2016})
     * @Method("GET")
     */
    public function indexCropCampaignAction(Request $request, $id, $year)
    {
        $em = $this->getDoctrine()->getManager();

        $farm = $em->getRepository('AppBundle:Farm')->find($this->getUser()->getFarm()->getId());

        // Create campaign date
        $startDatetime    =   \DateTime::createFromFormat("Y-m-d H:i:s",$year."-01-01 00:00:00");
        $endDatetime    =   \DateTime::createFromFormat("Y-m-d H:i:s",$year."-12-31 23:59:59");

        // Get cropCycles for current crop and campaign
        $cropCycles = $em->getRepository('AppBundle:CropCycle')->findByCropAndCampaign($id,$startDatetime,$endDatetime,$farm);

        return $this->render('@App/cropcycle/crop_campaign_index.html.twig', array(
            'cropCycles' => $cropCycles,
            'startCampaignDate' => $startDatetime,
            'endCampaignDate' => $endDatetime,
            'year'=>$year,
        ));
    }

    /**
     * Creates a new CropCycle entity.
     *
     * @Route("/plot/{id}/cropcycle/new", name="cropcycle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id)
    {
        $cropCycle = new CropCycle();

        // Get current plot
        $plot = $this->getDoctrine()->getManager()->getRepository('AppBundle:Plot')->find($id);
        $plot->addCropCycle($cropCycle); // Which also setPlot($plot) on $cropCycle

        // Get Entity Manager
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm('AppBundle\Form\CropCycleType', $cropCycle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cropCycle);
            $em->flush();

            // Call ACL service
            $aclProvider = $this->get('security.acl.provider');

            // Create the ACL for current CropCycle $cropCycle
            $objectIdentity = ObjectIdentity::fromDomainObject($cropCycle);
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

            $request->getSession()->getFlashBag()->add('success', 'Votre culture a été ajoutée avec succès ! ('.$cropCycle->getName().' - '.str_replace('.', ',', $cropCycle->getArea()).'ha)');

            return $this->redirectToRoute('cropcycle_show', array('id' => $cropCycle->getId()));
        }

        return $this->render('@App/cropcycle/new.html.twig', array(
            'plot' => $plot,
            'cropCycle' => $cropCycle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CropCycle entity.
     *
     * @Route("/cropcycle/{id}", name="cropcycle_show")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param CropCycle $cropCycle
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('VIEW', cropCycle) or is_granted('ROLE_ADMIN')")
     */
    public function showAction(Request $request, CropCycle $cropCycle)
    {
        $editForm = $this->createForm('AppBundle\Form\CropCycleType', $cropCycle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cropCycle);
            $em->flush();

            return $this->redirectToRoute('cropcycle_show', array('id' => $cropCycle->getId()));
        }

        $deleteForm = $this->createDeleteForm($cropCycle);

        return $this->render('@App/cropcycle/show.html.twig', array(
            'cropCycle' => $cropCycle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to edit an existing CropCycle entity.
     *
     * @Route("/cropcycle/{id}/edit", name="cropcycle_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param CropCycle $cropCycle
     * @Security("is_granted('EDIT', cropCycle) or is_granted('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, CropCycle $cropCycle)
    {
        $deleteForm = $this->createDeleteForm($cropCycle);
        $editForm = $this->createForm('AppBundle\Form\CropCycleType', $cropCycle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cropCycle);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Votre culture a été modifée avec succès ! ('.$cropCycle->getName().' - '.str_replace('.', ',', $cropCycle->getArea()).'ha)');

            return $this->redirectToRoute('cropcycle_show', array('id' => $cropCycle->getId()));
        }

        return $this->render('@App/cropcycle/edit.html.twig', array(
            'cropCycle' => $cropCycle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CropCycle entity.
     *
     * @Route("/cropcycle/{id}", name="cropcycle_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param CropCycle $cropCycle
     * @Security("is_granted('DELETE', cropCycle) or is_granted('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, CropCycle $cropCycle)
    {
        $form = $this->createDeleteForm($cropCycle);
        $form->handleRequest($request);

        $plot_id = $cropCycle->getPlot()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cropCycle);
            $em->flush();
        }

        return $this->redirectToRoute('plot_show', array(
            'id' => $plot_id
        ));
    }

    /**
     * Creates a form to delete a CropCycle entity.
     *
     * @param CropCycle $cropCycle The CropCycle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CropCycle $cropCycle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cropcycle_delete', array('id' => $cropCycle->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }


}
