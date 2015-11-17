<?php
namespace Guestbook\Entity;

use Zend\Form\Annotation;

/**
 * @Annotation\Name("entry")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */

class Entry
{
   /**
    * @Annotation\Exclude()
    */
    protected $id;

   /**
    * @Annotation\Attributes({"type":"text"})
    * @Annotation\Options({"label":"Name"})
    * @Annotation\Filter({"name":"StringTrim"})
    * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
    */
   protected $name;

   /**
    * @Annotation\Attributes({"type":"email"})
    * @Annotation\Options({"label":"Email"})
    * @Annotation\Filter({"name":"StringTrim"})
    * @Annotation\Validator({"name":"EmailAddress"})
    */
    protected $email;

   /**
    * @Annotation\Attributes({"type":"url"})
    * @Annotation\Options({"label":"Website"})
    * @Annotation\Filter({"name":"StringTrim"})
    * @Annotation\Validator({"name":"Uri"})
    */
    protected $website;

   /**
    * @Annotation\Attributes({"type":"textarea"})
    * @Annotation\Options({"label":"Message"})
    * @Annotation\Filter({"name":"StringTrim"})
    * @Annotation\Validator({"name":"NotEmpty"})
    */
    protected $message;
	
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setWebsite($website)
    {
        $this->website = $website;
        return $this;
    }

    public function getWebsite()
    {
        return $this->website;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
