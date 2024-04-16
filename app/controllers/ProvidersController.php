<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class ProvidersController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->view->setVar('provider', new Providers());
    }

    /**
     * Searches for providers
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, 'Providers', $_GET)->getParams();
        $parameters['order'] = "id";

        $paginator   = new Model(
            [
                'model'      => 'Providers',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any providers");

            $this->dispatcher->forward([
                "controller" => "providers",
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
        $this->view->setVar('provider', new Providers());
    }

    /**
     * Edits a provider
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $provider = Providers::findFirstByid($id);
            if (!$provider) {
                $this->flash->error("provider was not found");

                $this->dispatcher->forward([
                    'controller' => "providers",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $provider->id;
            $this->view->setVar('provider', $provider);

            //$assignTagDefaults$
        }
    }

    /**
     * Creates a new provider
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "providers",
                'action' => 'index'
            ]);

            return;
        }

        $provider = new Providers();
        $provider->name = $this->request->getPost("name");
        

        if (!$provider->save()) {
            foreach ($provider->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "providers",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("provider was created successfully");

        $this->dispatcher->forward([
            'controller' => "providers",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a provider edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "providers",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $provider = Providers::findFirstByid($id);

        if (!$provider) {
            $this->flash->error("provider does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "providers",
                'action' => 'index'
            ]);

            return;
        }

        $provider->name = $this->request->getPost("name");
        

        if (!$provider->save()) {

            foreach ($provider->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "providers",
                'action' => 'edit',
                'params' => [$provider->id]
            ]);

            return;
        }

        $this->flash->success("provider was updated successfully");

        $this->dispatcher->forward([
            'controller' => "providers",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a provider
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $provider = Providers::findFirstByid($id);
        if (!$provider) {
            $this->flash->error("provider was not found");

            $this->dispatcher->forward([
                'controller' => "providers",
                'action' => 'index'
            ]);

            return;
        }

        if (!$provider->delete()) {

            foreach ($provider->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "providers",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("provider was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "providers",
            'action' => "index"
        ]);
    }
}
