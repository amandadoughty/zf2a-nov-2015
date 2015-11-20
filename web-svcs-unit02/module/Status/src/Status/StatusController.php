<?php

namespace Status;

use Zend\Db\TableGateway\TableGateway;
use Zend\EventManager\EventManagerInterface;
use Zend\Math\Rand;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Stdlib\ArrayUtils;
use Zend\View\Model\JsonModel;

class StatusController extends AbstractRestfulController
{
    protected $acceptCriteria = array(
        'Zend\View\Model\JsonModel' => array(
            'application/json',
        ),
    );

    protected $model;
    protected $table;

    public function __construct(TableGateway $table)
    {
        $this->table = $table;
        $this->model = new JsonModel();
    }

    public function createIdentifier()
    {
        return Rand::getString(32, 'abcdef0123456789');
    }

    /**
     * Fetch a record (see if it exists)
     *
     * This method is intended to make the others simpler to implement.
     * Examine it and make sure you understand what it's doing:
     *
     * - It fetches a resultset using the given identifier
     * - If the resultset is empty, it creates a 404 response status, and
     *   provides an error message to return in the model.
     * - Otherwise, it returns the data set.
     * 
     * @param  string $id 
     * @return array|false
     */
    protected function fetch($id)
    {
        $resultSet = $this->table->select(array('id' => $id));

        if (0 == count($resultSet)) {
            $response = $this->getResponse();
            $response->setStatusCode(404);
            $this->model->setVariables(array(
                'message' => sprintf('Status by id "%s" not found', $id),
            ));
            return false;
        }

        return $resultSet->current();
    }

    /**
     * Retrieve a single status
     *
     * This method demonstrates many of the tasks you will perform in the other
     * methods, including accessing the table gateway, manipulating the response,
     * and populating and returning the model.
     * 
     * @param  string $id 
     * @return JsonModel
     */
    public function get($id)
    {
        $status = $this->fetch($id);
        if (false === $status) {
            return $this->model;
        }

        $this->model->setVariables($status);
        return $this->model;
    }

    /**
     * Check that we have an Accept-able request
     *
     * Your task:
     *
     * - Create a view model using the acceptableViewModelSelector plugin, 
     *   passing it the $acceptCriteria.
     * - If the view model is a JsonModel, assign it to $model and return.
     * - If not, set the status code to 406 and return the response object.
     *
     * @param  MvcEvent $e
     * @return void|\Zend\Http\Response
     */
    public function isAcceptable($e)
    {
    }

    /**
     * Register the event manager
     *
     * Your task:
     *
     * - Register the isAcceptable method as a handler on the dispatch event, with high priority
     * - Have the parent method complete the registration of the event manager
     *
     * @param  EventManagerInterface $events
     * @return self
     */
    public function setEventManager(EventManagerInterface $events)
    {
        // Register the listener here

        // Keep the following line
        return parent::setEventManager($events);
    }

    /**
     * Create a new status
     *
     * Your task:
     *
     * - Ensure that $data has a "text" field, and remove any other data provided.
     * - If it does not, return a 400 status code, and a response that includes 
     *   an error message.
     * - If it does, create an ID using the method createIdentifier(), add it to 
     *   the data, and insert into the table; on success, return a 201 status and 
     *   the data, and ensure a Location header is set pointing to the new resource.
     *
     * Hint: use the url plugin and its fromRoute() method to generate the url 
     * for the Location header; the route name is "status-api".
     * 
     * @param mixed $data 
     * @return JsonModel
     */
    public function create($data)
    {
    }

    /**
     * Delete a single record
     *
     * Your task is:
     *
     * - use fetch() to see if the record exists; return the view model if not.
     * - If it does, attempt to delete it; on failure, return a 500 status and an
     *   error message; on success, return a 204 status and no content.
     * 
     * @param  string $id 
     * @return JsonModel
     */
    public function delete($id)
    {
    }

    /**
     * Retrieve the entire set of status messages
     *
     * Your task is:
     *
     * - Query the table to retrieve all status messages
     * - If a DB error occurs, return a 500 response with an error message
     * - Populate the model with the status messages on success
     *   - Hint: use ArrayUtils::iteratorToArray() on the resultset to cast it to an array
     *   - Assign the statuses to a "statuses" variable in the view model
     * 
     * @return JsonModel
     */
    public function getList()
    {
        try {
            $resultSet = $this->table->select()->toArray();
            if (0 == count($resultSet)) {
                throw new Exception();
            }
        } catch (\Exception $e) {
            $response = $this->getResponse();
            $response->setStatusCode(500);
            $this->model->setVariables(array(
                'message' => 'Database error',
            ));
            return false;
        }
        $jsonModel = new JsonModel(['statuses' => $resultSet]);
        return $jsonModel;
    }

    /**
     * Update a single status
     *
     * Your task is:
     *
     * - Use fetch() to ensure the status exists; if not, return the view model immediately.
     * - Ensure that $data has a "text" field, and remove any other data provided.
     * - If it does not, return a 400 status code, and a response that includes 
     *   an error message.
     * - If it does, attempt to update the record specified by $id; on failure,
     *   return a 500 status and an error message; on success, return a 200 status
     *   and the updated record.
     *
     * Typically, patch is used for partial updates; however, since we only have
     * one field, it is for all intents and purposes the same as update.
     *
     * @param  string $id 
     * @param  array $data 
     * @return JsonModel
     */
    public function patch($id, $data)
    {
        $status = $this->fetch($id);
        $response = $this->getResponse();
        if ($status === FALSE) {
            $response->setStatusCode(400);
            $this->model->setVariables(array(
                'message' => 'ID not found',
            ));
            return $this->model;
        }
        
        $text = (isset($data['text'])) ? $data['text'] : FALSE;
        if ($text === FALSE) {
            $response->setStatusCode(400);
            $this->model->setVariables(array(
                'message' => 'No text to update',
            ));
            return $this->model;
        }
        
        try {
            $this->table->update(['text' => $text],['id' => $id]);
        } catch (\Exception $e) {
            $response->setStatusCode(500);
            $this->model->setVariables(array(
                'message' => 'Database error',
            ));
            return false;
        }
        return $this->get($id);
    }
    
    /**
     * Update a single status
     *
     * Your task is:
     *
     * - Implement patch(), and this method is done.
     *
     * Typically, update is used to replace a record; however, since we only 
     * have one field, it is for all intents and purposes the same as patch.
     *
     * @param  string $id 
     * @param  array $data 
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return $this->patch($id, $data);
    }
}
