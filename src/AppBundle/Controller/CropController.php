<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Crop;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\CropType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * Crop controller.
 *
 * @Security("has_role('ROLE_FARMER')")
 */
class CropController extends Controller
{
    /**
     * Get cumulated area a a crop for a specific year
     * .
     * @Route("ferme/{farm}/crop/{crop}/campagne/{year)", name="cumulated_area", requirements={"year" = "\d+"}, defaults={"year" = 2016}))
     * @Method("GET")
     */
    public function getCumulatedAreaAction($crop, $year, $farm){
        $em = $this->getDoctrine()->getManager();

        // Create campaign date
        $startDatetime    =   \DateTime::createFromFormat("Y-m-d H:i:s",$year."-01-01 00:00:00");
        $endDatetime    =   \DateTime::createFromFormat("Y-m-d H:i:s",$year."-12-31 23:59:59");

        // Get cropCycles for current crop and campaign
        $cropCycles = $em->getRepository('AppBundle:CropCycle')->findByCropAndCampaign($crop, $startDatetime, $endDatetime,$farm);
        $area = "";
        foreach ($cropCycles as $cropCycle) {
            $area += $cropCycle->getArea();
        }
        return new Response(str_replace('.',',',$area).' ha cumulés');
    }


    /**
     * Lists all Crop entities
     * .
     * @Route("/crop/list", name="crop_list")
     * @Method("GET")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        $crops = $em->getRepository('AppBundle:Crop')->findAll();

        return $this->render('@App/crop/index.html.twig', array(
            'crops' => $crops,
        ));
    }

    /**
     * Lists all Crop entities for current farm
     * .
     * @Route("ferme/{id}/cultures/campagne/{year}", name="crop_current_index", requirements={"year" = "\d+"}, defaults={"year" = 2016})
     * @Method("GET")
     */
    public function indexAction(Request $request, $id, $year)
    {
        $em = $this->getDoctrine()->getManager();

        $crops = $em->getRepository('AppBundle:Crop')->findByFarm($id);

        // Create campaign date
        $startCampaignDate    =   \DateTime::createFromFormat("Y-m-d H:i:s",$year."-01-01 00:00:00");
        $endCampaignDate    =   \DateTime::createFromFormat("Y-m-d H:i:s",$year."-12-31 23:59:59");

        return $this->render('@App/crop/index.html.twig', array(
            'crops' => $crops,
            'year' => $year,
            'startCampaignDate' => $startCampaignDate,
            'endCampaignDate' => $endCampaignDate,
        ));
    }

    /**
     * Creates a new Crop entity.
     *
     * @Route("/crop/new", name="crop_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $crop = new Crop();

        $form = $this->createForm('AppBundle\Form\CropType', $crop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($crop);
            $em->flush();

            return $this->redirectToRoute('crop_show', array('id' => $crop->getId()));
        }

        return $this->render('@App/crop/new.html.twig', array(
            'crop' => $crop,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Crop entity.
     *
     * @Route("/crop/{id}", name="crop_show")
     * @Method("GET")
     * @param Crop $crop
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Crop $crop)
    {
        $deleteForm = $this->createDeleteForm($crop);

        return $this->render('@App/crop/show.html.twig', array(
            'crop' => $crop,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Crop entity.
     *
     * @Route("/crop/{id}/edit", name="crop_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @param Crop $crop
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Crop $crop)
    {
        $deleteForm = $this->createDeleteForm($crop);
        $editForm = $this->createForm('AppBundle\Form\CropType', $crop);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($crop);
            $em->flush();

            return $this->redirectToRoute('crop_show', array('id' => $crop->getId()));
        }

        return $this->render('@App/crop/edit.html.twig', array(
            'crop' => $crop,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Crop entity.
     *
     * @Route("/crop/{id}/delete", name="crop_delete")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("DELETE")
     * @param Request $request
     * @param Crop $crop
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Crop $crop)
    {
        $form = $this->createDeleteForm($crop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($crop);
            $em->flush();
        }

        return $this->redirectToRoute('crop_index');
    }

    /**
     * Creates a form to delete a Crop entity.
     *
     * @param Crop $crop The Crop entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Crop $crop)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('crop_delete', array('id' => $crop->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
