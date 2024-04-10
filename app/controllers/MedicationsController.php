<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;
use Phalcon\Http\Response;


class MedicationsController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()

    {
        $this->view->setVar('medication', new Medications());
    }

    /**
     * Searches for medications
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, 'Medications', $_GET)->getParams();
        $parameters['order'] = "id";

        $paginator   = new Model(
            [
                'model'      => 'Medications',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any medications");

            $this->dispatcher->forward([
                "controller" => "medications",
                "action" => "index"
            ]);

            return;
        }

        $this->view->page = $paginate;
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('medication', new Medications());
    }

    /**
     * Edits a medication
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $medication = Medications::findFirstByid($id);
            if (!$medication) {
                $this->flash->error("medication was not found");

                $this->dispatcher->forward([
                    'controller' => "medications",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $medication->id;
            $this->view->setVar('medication', $medication);

            //$assignTagDefaults$
        }
    }

    /**
     * Creates a new medication
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "medications",
                'action' => 'index'
            ]);

            return;
        }

        $medication = new Medications();
        $medication->id = $this->request->getPost("id", "int");
        $medication->name = $this->request->getPost("name");
        

        if (!$medication->save()) {
            foreach ($medication->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "medications",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("medication was created successfully");

        $this->dispatcher->forward([
            'controller' => "medications",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a medication edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "medications",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $medication = Medications::findFirstByid($id);

        if (!$medication) {
            $this->flash->error("medication does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "medications",
                'action' => 'index'
            ]);

            return;
        }

        $medication->id = $this->request->getPost("id", "int");
        $medication->name = $this->request->getPost("name");
        

        if (!$medication->save()) {

            foreach ($medication->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "medications",
                'action' => 'edit',
                'params' => [$medication->id]
            ]);

            return;
        }

        $this->flash->success("medication was updated successfully");

        $this->dispatcher->forward([
            'controller' => "medications",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a medication
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $medication = Medications::findFirstByid($id);
        if (!$medication) {
            $this->flash->error("medication was not found");

            $this->dispatcher->forward([
                'controller' => "medications",
                'action' => 'index'
            ]);

            return;
        }

        if (!$medication->delete()) {

            foreach ($medication->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "medications",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("medication was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "medications",
            'action' => "index"
        ]);
    }
}
