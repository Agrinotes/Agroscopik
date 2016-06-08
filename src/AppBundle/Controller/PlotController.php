<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Plot;
use AppBundle\Form\PlotType;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * Plot controller.
 * @Security("has_role('ROLE_USER)")
 * @Route("/plot")
 */
class PlotController extends Controller
{

    /**
     * Lists all Plot entities.
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/", name="plot_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plots = $em->getRepository('AppBundle:Plot')->findAll();

        return $this->render('AppBundle:plot:index.html.twig', array(
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
        $plot = new Plot();
        $farm = $this->getUser()->getFarm();
        $farm->addPlot($plot);

        $form = $this->createForm('AppBundle\Form\PlotType', $plot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($plot);
            $em->flush();

            // Create the ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($plot);
            $acl = $aclProvider->createAcl($objectIdentity);

            // Retrieve the security identity of the current user
            $securityIdentity = UserSecurityIdentity::fromAccount($this->getUser());

            // Create Access Mask
            $builder = new MaskBuilder();
            $builder
                ->add('view')
                ->add('edit')
                ->add('delete')
            ;
            $mask = $builder->get();

            // Grant access
            $acl->insertObjectAce($securityIdentity, $mask);
            $aclProvider->updateAcl($acl);

            return $this->redirectToRoute('plot_show', array('id' => $plot->getId()));
        }

        return $this->render('AppBundle:plot:new.html.twig', array(
            'plot' => $plot,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Plot entity.
     *
     * @Security("is_granted('VIEW', plot) or has_role('ROLE_ADMIN')")
     * @Route("/{id}", name="plot_show")
     * @Method("GET")
     * @param Plot $plot
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Plot $plot)
    {
        $deleteForm = $this->createDeleteForm($plot);

        return $this->render('AppBundle:plot:show.html.twig', array(
            'plot' => $plot,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Plot entity.
     *
     * @Security("is_granted('EDIT', plot) or has_role('ROLE_ADMIN')")
     * @Route("/{id}/edit", name="plot_edit")
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
     * @Security("is_granted('DELETE', plot) or is_granted('ROLE_ADMIN')")
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
