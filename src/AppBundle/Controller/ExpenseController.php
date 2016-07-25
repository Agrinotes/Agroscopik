<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Expense;
use AppBundle\Form\ExpenseType;

/**
 * Expense controller.
 *
 * @Route("/expense")
 */
class ExpenseController extends Controller
{
    /**
     * Lists all Expense entities.
     *
     * @Route("/", name="expense_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $expenses = $em->getRepository('AppBundle:Expense')->findAll();

        return $this->render('expense/index.html.twig', array(
            'expenses' => $expenses,
        ));
    }

    /**
     * Creates a new Expense entity.
     *
     * @Route("/new", name="expense_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $expense = new Expense();
        $form = $this->createForm('AppBundle\Form\ExpenseType', $expense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($expense);
            $em->flush();

            return $this->redirectToRoute('expense_show', array('id' => $expense->getId()));
        }

        return $this->render('expense/new.html.twig', array(
            'expense' => $expense,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Expense entity.
     *
     * @Route("/{id}", name="expense_show")
     * @Method("GET")
     */
    public function showAction(Expense $expense)
    {
        $deleteForm = $this->createDeleteForm($expense);

        return $this->render('expense/show.html.twig', array(
            'expense' => $expense,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Expense entity.
     *
     * @Route("/{id}/edit", name="expense_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Expense $expense)
    {
        $deleteForm = $this->createDeleteForm($expense);
        $editForm = $this->createForm('AppBundle\Form\ExpenseType', $expense);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($expense);
            $em->flush();

            return $this->redirectToRoute('expense_edit', array('id' => $expense->getId()));
        }

        return $this->render('expense/edit.html.twig', array(
            'expense' => $expense,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Expense entity.
     *
     * @Route("/{id}", name="expense_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Expense $expense)
    {
        $form = $this->createDeleteForm($expense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($expense);
            $em->flush();
        }

        return $this->redirectToRoute('expense_index');
    }

    /**
     * Creates a form to delete a Expense entity.
     *
     * @param Expense $expense The Expense entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Expense $expense)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('expense_delete', array('id' => $expense->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
