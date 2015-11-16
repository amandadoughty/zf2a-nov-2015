<?php
namespace Application\Model;

use Zend\Db\RowGateway;
class Attendee extends RowGateway
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
}
