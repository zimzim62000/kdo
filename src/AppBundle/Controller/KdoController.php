<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use ZIMZIM\ToolsBundle\Controller\MainController;

use AppBundle\Entity\Kdo;
use AppBundle\Form\KdoType;

/**
 * Kdo controller.
 *
 */
class KdoController extends MainController
{

    /**
     * Lists all Kdo entities.
     *
     */
    public function indexAction()
    {
        $manager = $this->container->get('app_manager_kdo');
        $data = array(
            'manager' => $manager,
            'dir' => 'AppBundle:Kdo',
            'show' => 'appbundle_kdo_show',
            'edit' => 'appbundle_kdo_edit'
        );

        return $this->gridList($data);
    }

    /**
     * Creates a new Kdo entity.
     *
     */
    public function createAction(Request $request)
    {
        $manager = $this->container->get('app_manager_kdo');
        $entity = $manager->createEntity();
        $form = $this->createCreateForm($entity, $manager);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $this->createSuccess();
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('app_kdo_show', array('id' => $entity->getId())));
        }

        return $this->render(
            'AppBundle:Kdo:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a Kdo entity.
     *
     * @param Kdo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Kdo $entity, $manager)
    {
        $form = $this->createForm(
            $manager->getFormName(),
            $entity,
            array(
                'action' => $this->generateUrl('app_kdo_create'),
                'method' => 'POST',
            )
        );

        $form->add(
            'submit',
            'submit',
            array('label' => 'button.validate', 'attr' => array('class' => 'tiny button success'))
        );

        return $form;
    }

    /**
     * Displays a form to create a new Kdo entity.
     *
     */
    public function newAction()
    {
        $manager = $this->container->get('app_manager_kdo');
        $entity = $manager->createEntity();
        $form = $this->createCreateForm($entity, $manager);

        return $this->render(
            'AppBundle:Kdo:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Kdo entity.
     *
     */
    public function showAction($id)
    {
        $manager = $this->container->get('app_manager_kdo');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Kdo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AppBundle:Kdo:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing Kdo entity.
     *
     */
    public function editAction($id)
    {
        $manager = $this->container->get('app_manager_kdo');

        $entity = $manager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Kdo entity.');
        }

        $editForm = $this->createEditForm($entity, $manager);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AppBundle:Kdo:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a Kdo entity.
     *
     * @param Kdo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Kdo $entity, $manager)
    {
        $form = $this->createForm(
            $manager->getFormName(),
            $entity,
            array(
                'action' => $this->generateUrl('app_kdo_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add(
            'submit',
            'submit',
            array('label' => 'button.validate', 'attr' => array('class' => 'tiny button success'))
        );

        return $form;
    }

    /**
     * Edits an existing Kdo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->container->get('app_manager_kdo');

        $entity = $manager->find($id);

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $manager);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->updateSuccess();
            $em->flush();

            return $this->redirect($this->generateUrl('app_kdo_edit', array('id' => $id)));
        }

        return $this->render(
            'AppBundle:Kdo:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a Kdo entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $manager = $this->container->get('app_manager_kdo');

            $entity = $manager->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Kdo entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->deleteSuccess();
        }

        return $this->redirect($this->generateUrl('app_kdo'));
    }

    /**
     * Creates a form to delete a Kdo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('app_kdo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add(
                'submit',
                'submit',
                array('label' => 'button.delete', 'attr' => array('class' => 'tiny button alert'))
            )
            ->getForm();
    }
}
