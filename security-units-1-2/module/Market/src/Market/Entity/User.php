<?php

namespace Market\Entity;

use ZfcUser\Entity\User as ZfcUser;

class User extends ZfcUser
{

    /**
     * @var string
     */
    protected $ccnumber;

    /**
     * @return the $ccnumber
     */
    public function getCcnumber()
    {
        return $this->ccnumber;
    }

    /**
     * @param string $ccnumber
     */
    public function setCcnumber($ccnumber)
    {
        $this->ccnumber = $ccnumber;
    }

}
