<?php
namespace Market\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;

class PostForm extends Form
{
	public function prepareElements(Array $categories, Array $cityCodes)
	{
		$category = new Element\Select('category');
		$category->setLabel('Category')
				   ->setOptions(array('options' => $categories));
		
		$title = new Element\Text('title');
		$title->setLabel('Title')
			 ->setAttribute('title', 'Enter a suitable title for this posting')
			 ->setAttribute('size', 40)
			 ->setAttribute('maxlength', 128);

		$price = new Element\Text('price');
		$price->setLabel('Price')
			  ->setAttribute('title', 'Enter price as nnn.nn')
	 		  ->setAttribute('size', 20)
			  ->setAttribute('maxlength', 20);
		
		$photo = new Element\Text('photo');
		$photo->setLabel('URL of Photo')
			  ->setAttribute('title', 'Enter the URL to a photo of the item')
			  ->setAttribute('size', 40)
			  ->setAttribute('maxlength', 128);
		
		$expires = new Element\Radio('expires');
		$expires->setLabel('Expires')
			    ->setAttribute('title', 'The expiration date will be calculated from today')
				->setAttribute('class', 'expires')
				->setValueOptions(array('0'  => 'Never',
										'1'  => 'Tomorrow', 
										'7'  => 'Week', 
										'30' => 'Month', 
				));
	
		$city = new Element\Select('cityCode');
		$city->setLabel('Nearest City')
			  ->setAttribute('title', 'Select the city nearest to where you will be selling the item')
			  ->setOptions(array('options' => $cityCodes));
				
		$name = new Element\Text('name');
		$name->setLabel('Contact Name')
			 ->setAttribute('title', 'Enter the name of the person to contact for this item')
			 ->setAttribute('size', 40)
			 ->setAttribute('maxlength', 255);
		
		$phone = new Element\Text('phone');
		$phone->setLabel('Contact Phone Number')
			  ->setAttribute('title', 'Enter the phone number of the person to contact for this item')
			  ->setAttribute('size', 20)
			  ->setAttribute('maxlength', 32);
		
		$email = new Element\Email('email');
		$email->setLabel('Contact Email')
			  ->setAttribute('title', 'Enter the email address of the person to contact for this item')
			  ->setAttribute('size', 40)
			  ->setAttribute('maxlength', 255);

		$delCode = new Element\Text('delCode');
		$delCode->setLabel('Delete Code')
			 ->setAttribute('title', 'Enter code needed to delete this posting')
			 ->setAttribute('size', 40)
			 ->setAttribute('maxlength', 128);

		$description = new Element\Textarea('description');
		$description->setLabel('Description')
					->setAttribute('title', 'Enter a suitable description for this posting')
					->setAttribute('rows', 4)
					->setAttribute('cols', 80);

		$captcha = new Element\Captcha('captcha');
		$captchaAdapter = new Captcha\Dumb();
		$captchaAdapter->setWordlen(5);
		$captcha->setCaptcha($captchaAdapter)
			    ->setAttribute('title', 'Help to prevent SPAM');
		
		$submit = new Element\Submit('submit');
		$submit->setAttribute('value', 'Post')
			   ->setAttribute('title', 'Click here when done');
		
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
			 ->add($description)
			 ->add($captcha)
			 ->add($submit);
	}
} 
