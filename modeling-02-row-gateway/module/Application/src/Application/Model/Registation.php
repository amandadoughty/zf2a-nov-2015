<?php
namespace Application\Model;

use Zend\Db\RowGateway;
use Application\Model\Attendee;
use Application\Repo\AttendeeRepo;
class Registration extends RowGateway
{
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
    public function setAttendee($attendeeId)
    {
        $list = $this->getAttendeeList();
        $list[$attendeeId] = $attendeeId;
        $this->saveAttendeeList();
    }
    public function getAttendee($id)
    {
        $list = $this->getAttendeeList();
        if (isset($list[$id])) {
            return $this->attendeeRepo->findById($id);
        } else {
            return NULL;
        }
    }
    public function getAllAttendees()
    {
        $list    = $this->getAttendeeList();
        $result = array();
        if ($list) {
            $lookup = $this->registrationRepo->getListOfAttendees($list);
            foreach ($lookup as $rowgateway) {
                $result[$rowgateway->id] = new Attendee($rowgateway);
            }
        }
        return $result;
    }
    protected function getAttendeeList()
    {
        $list = array();
        if ($this->rowgateway->attendees) {
            $list = unserialize($this->rowgateway->attendees);
        }
        return $list;
    }
    protected function saveAttendeeList($list)
    {
        $this->rowgateway->attendees = serialize($list);
        $this->rowgateway->save();
    }
}
