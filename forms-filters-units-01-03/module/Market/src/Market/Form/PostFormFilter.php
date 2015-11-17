<?php
namespace Market\Form;

use Zend\InputFilter\Input;
use Zend\Validator;
use Zend\Filter;
use Zend\InputFilter\InputFilter;
use Zend\Uri\Http;	// URI handler

class PostFormFilter extends InputFilter
{
	public function prepareFilters(Array $categories, Array $cityCodes)
	{
		$category = new Input('category');
		$category->getValidatorChain()
			     ->addByName('InArray', array('haystack' => $categories));
		$category->getFilterChain()
				 ->attach(new Filter\StringToLower())
				 ->attachByName('StripTags');

		$title = new Input('title');
		$title->getFilterChain()
			 ->attachByName('StripTags')
			 ->attachByName('StringTrim');
		$title->getValidatorChain()
			 ->addByName('NotEmpty')
			 ->addByName('StringLength', array('min' => 1, 'max' => 128, 'encoding' => 'utf-8'));

		$price = new Input('price');
		$priceValidator = new Validator\Regex(array('pattern' => '/^[0-9]+\.[0-9]{2}$/'));
		$priceValidator->setMessage('If less than 0 enter 0.nn, otherwise enter price in this form: nnnn.nn');
		$price->getValidatorChain()
			  ->addByName('NotEmpty')
			  ->addValidator($priceValidator);
		
		$photo = new Input('photo');
/*		
		$uriValidator = new Validator\Uri();
		$uriValidator->setUriHandler(new Http())
					 ->setAllowAbsolute(TRUE)
					 ->setAllowRelative(TRUE);
		$photo->setRequired(FALSE);
		$photo->getFilterChain()
			  ->attachByName('StripTags')
			  ->attachByName('StringTrim');
		$photo->getValidatorChain()
			  ->addValidator($uriValidator);
*/				
		$expires = new Input('expires');
		$expires->getValidatorChain()
				->addByName('Digits');
		$expires->getFilterChain()
			    ->attachByName('StripTags')
				->attachByName('StringTrim');
		
		$city = new Input('cityCode');
		$city->getValidatorChain()
			 ->addByName('NotEmpty')
			 ->addByName('InArray', array('haystack' => array_keys($cityCodes)));
		$city->getFilterChain()
			 ->attachByName('Digits');
		
		$name = new Input('name');
		$name->getFilterChain()
			  ->attachByName('StripTags')
			  ->attachByName('StringTrim');
		$name->getValidatorChain()
			 ->addByName('NotEmpty')
			 ->addByName('StringLength', array('min' => 0, 'max' => 255));
  
		$phone = new Input('phone');
		$phoneValidator = new Validator\Regex(array('pattern' => '/^\+[0-9]+ [0-9 -]+$/'));
		$phoneValidator->setMessage('Enter phone as: +<country code> nnn-nnn-nnnn');
		$phone->getFilterChain()
			  ->attachByName('StripTags')
			  ->attachByName('StringTrim');
		$phone->getValidatorChain()
			  ->addValidator($phoneValidator);
  
		$email = new Input('email');
		$email->getValidatorChain()
			  ->addByName('NotEmpty')
			  ->addByName('EmailAddress');
		$email->getFilterChain()
			  ->attachByName('StripTags')
			  ->attachByName('StringTrim');
		
		$delCode = new Input('delCode');
		$delCode->getValidatorChain()
				->addByName('Alnum');
		
		$description = new Input('description');
		$description->getFilterChain()
				    ->attachByName('StripTags')
				    ->attachByName('StringTrim');
		$description->getValidatorChain()
				    ->addByName('NotEmpty')
				    ->addByName('StringLength', array('min' => 1, 'max' => 4096, 'encoding' => 'utf-8'));
  
		$this->add($category)
			 ->add($title)
			 ->add($price)
			 ->add($photo)
			 ->add($expires)
			 ->add($city)
			 ->add($name)
			 ->add($phone)
			 ->add($email)
			 ->add($delCode)
			 ->add($description);
	}
} 
