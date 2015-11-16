<?php
namespace Application\Model;

use Zend\Db\RowGateway;
use Application\Model\Registration;
use Application\Repo\RegistrationRepo;
class Event extends RowGateway
{
    protected $registrationRepo;
    protected $rowgateway;
    public function __construct(RowGateway $rowgateway = NULL)
    {
        if (!$rowgateway) {
            $this->rowgateway = new RowGateway('id');
        } else {
            $this->rowgateway = $rowgateway;
        }
    }
    public function getRowgateway()
    {
        return $this->rowgateway;
    }
    public function setRegistration($registrationId)
    {
        $list = $this->getRegistrationList();
        $list[$registrationId] = $registrationId;
        $this->saveRegistrationList();
    }
    public function getRegistration($id)
    {
        $list = $this->getRegistrationList();
        if (isset($list[$id])) {
            return $this->registrationRepo->findById($id);
        } else {
            return NULL;
        }
    }
    public function getAllRegistrations()
    {
        $list    = $this->getRegistrationList();
        $result = array();
        if ($list) {
            $lookup = $this->registrationRepo->getListOfRegistrations($list);
            foreach ($lookup as $rowgateway) {
                $result[$rowgateway->id] = new Registration($rowgateway);
            }
        }
        return $result;
    }
    protected function getRegistrationList()
    {
        $list = array();
        if ($this->rowgateway->registrations) {
            $list = unserialize($this->rowgateway->registrations);
        }
        return $list;
    }
    protected function saveRegistrationList($list)
    {
        $this->rowgateway->registrations = serialize($list);
        $this->rowgateway->save();
    }
}
