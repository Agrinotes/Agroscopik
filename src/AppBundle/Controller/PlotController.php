<?php

namespace AppBundle\Controller;

use DateInterval;
use DateTimeImmutable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Plot;
use AppBundle\Form\PlotType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * Plot controller.
 * @Security("has_role('ROLE_FARMER')")
 */
class PlotController extends Controller
{

    /**
     * Lists current farm Plot entities.
     *
     * @Route("/ferme/parcelle/campagne/{year}", name="plot_index", requirements={"year" = "\d+"}, defaults={"year" = 2016})
     * @Method("GET")
     */
    public function indexAction(Request $request, $year)
    {
        $em = $this->getDoctrine()->getManager();

        $farm= $this->getUser()->getFarm();

        $plots = $em->getRepository('AppBundle:Plot')->findAllForCurrentFarm($farm->getId());

        // Create campaign date
        $startDatetime = \DateTime::createFromFormat("Y-m-d H:i:s", $year . "-01-01 00:00:00");
        $endDatetime = \DateTime::createFromFormat("Y-m-d H:i:s", $year . "-12-31 23:59:59");

        $cropCycles = $em->getRepository('AppBundle:CropCycle')->findAllByCampaign($startDatetime,$endDatetime,$farm->getId());

        return $this->render('AppBundle:plot:index.html.twig', array(
            'plots' => $plots,
            'cropCycles' => $cropCycles,
            'startCampaignDate' => $startDatetime,
            'endCampaignDate' => $endDatetime,
            'year' => $year,
        ));
    }

    /**
     * Creates a new Plot entity.
     *
     * @Route("/parcelle/new", name="plot_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $plot = new Plot();

        // Get Entity Manager
        $em = $this->getDoctrine()->getManager();

        $farm = $this->getUser()->getFarm();
        $farm->addPlot($plot);

        $form = $this->createForm('AppBundle\Form\PlotType', $plot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Store plot in the database
            $em->persist($plot);
            $em->flush();

            // Call ACL service
            $aclProvider = $this->get('security.acl.provider');

            // Create the ACL for current Plot $plot
            $objectIdentity = ObjectIdentity::fromDomainObject($plot);
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

            $request->getSession()->getFlashBag()->add('success', array('title' => 'Votre parcelle '.$plot->getName().' ('.number_format($plot->getArea(), 2, ',', ' ').'ha)'.' a été ajoutée avec succès !', 'message' => 'Ajouter une autre parcelle') );



            return $this->redirectToRoute('plot_show', array('id' => $plot->getId()));
        }

        return $this->render('AppBundle:plot:new.html.twig', array(
            'plot' => $plot,
            'form' => $form->createView(),
        ));
    }

       /**
     * Creates a new Plot entity.
     *
     * @Route("/parcelle/new_from_dashboard", name="plot_new_from_dashboard")
     * @Method({"GET", "POST"})
     */
    public function newFromDashboardAction(Request $request)
    {
        $plot = new Plot();

        // Get Entity Manager
        $em = $this->getDoctrine()->getManager();

        $farm = $this->getUser()->getFarm();
        $farm->addPlot($plot);

        $form = $this->createForm('AppBundle\Form\PlotType', $plot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Store plot in the database
            $em->persist($plot);
            $em->flush();

            // Call ACL service
            $aclProvider = $this->get('security.acl.provider');

            // Create the ACL for current Plot $plot
            $objectIdentity = ObjectIdentity::fromDomainObject($plot);
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

            $request->getSession()->getFlashBag()->add('success', array('title' => 'Votre parcelle '.$plot->getName().' ('.number_format($plot->getArea(), 2, ',', ' ').'ha)'.' a été ajoutée avec succès !', 'message' => 'Ajouter une autre parcelle') );



            return $this->redirectToRoute('dashboard');
        }

        return $this->render('AppBundle:plot:new_from_dashboard.html.twig', array(
            'plot' => $plot,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Plot entity.
     *
     * @Security("is_granted('VIEW', plot) or is_granted('ROLE_ADMIN')")
     * @Route("/parcelle/{id}/campagne/{year}", name="plot_show", requirements={"year" = "\d+"}, defaults={"year" = 2016})
     * @Method("GET")
     * @param Plot $plot
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Plot $plot, $year)
    {
        $deleteForm = $this->createDeleteForm($plot);

        return $this->render('AppBundle:plot:show.html.twig', array(
            'plot' => $plot,
            'delete_form' => $deleteForm->createView(),
            'year' => $year,
        ));
    }

    /**
     * Displays a form to edit an existing Plot entity.
     *
     * @Security("is_granted('EDIT', plot) or has_role('ROLE_ADMIN')")
     * @Route("/parcelle/{id}/edit", name="plot_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Plot $plot
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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

            return $this->redirectToRoute('plot_show', array('id' => $plot->getId()));
        }

        return $this->render('AppBundle:plot:edit.html.twig', array(
            'plot' => $plot,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Plot entity.
     *
     * @Security("is_granted('DELETE', plot) or has_role('ROLE_ADMIN')")
     * @Route("/parcelle/{id}", name="plot_delete")
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

        return $this->redirectToRoute('farm_show_current');
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
            ->getForm();
    }

    /**
     * Get cumulated working time a plot for a specific year
     *
     * @Route("ferme/plot/{plot}/campagne/{year)/time", name="plot_cumulated_time", requirements={"year" = "\d+"}, defaults={"year" = 2016}))
     * @Method("GET")
     */
    public function getCumulatedWorkingTimeAction($plot, $year)
    {
        $em = $this->getDoctrine()->getManager();

        // Create campaign date
        $startDatetime = \DateTime::createFromFormat("Y-m-d H:i:s", $year . "-01-01 00:00:00");
        $endDatetime = \DateTime::createFromFormat("Y-m-d H:i:s", $year . "-12-31 23:59:59");

        // Get cropCycles for current crop and campaign
        $cropCycles = $em->getRepository('AppBundle:CropCycle')->findByPlotAndCampaign($plot, $startDatetime, $endDatetime);

        //Calculate duration
        $reference = new DateTimeImmutable;
        $endTime = clone $reference;

        foreach ($cropCycles as $cropCycle) {
            $cycle_duration = $cropCycle->getWorkingDuration();
            $cycle_duration = $this->format_duration_to_hours($cycle_duration);
            $endTime = $endTime->add($cycle_duration);
        }
        $time = $reference->diff($endTime);

        return new Response(str_replace('.', ',', $time->format('%h')) . ' h');
    }

    /**
     * Format an interval to show all existing components.
     *
     * @param DateInterval $interval The interval
     *
     * @return string Formatted interval string.
     */
    function format_duration_to_hours(DateInterval $interval) {
        $result = 0;

        // Years
        if ($interval->y) {
            if ($interval->y != 0) {
                $result += $interval->y * 365 * 24;
            }
        }

        // Months
        if ($interval->m) {
            if ($interval->m != 0) {
                $result += $interval->m * 30 * 24;
            }
        }

        // Days
        if ($interval->d) {
            if ($interval->d != 0) {
                $result += $interval->d * 24;
            }
        }

        // Hours
        if ($interval->h) {
            if ($interval->h != 0) {
                $result += $interval->h;
            }
        }

        // Minutes
        if ($interval->i) {
            if ($interval->i != 0) {
                $result += 1;
            }
        }

        return new DateInterval('PT'.$result.'H');
    }


}
