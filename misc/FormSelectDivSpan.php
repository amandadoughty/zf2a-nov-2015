<?php
namespace Application\Helper;

use Zend\Form\Element;
use Zend\View\Helper\AbstractHelper;

/**
 * Returns a number formatted using trim(sprintf('%12.2f', $amount))
 * Also forces data type to (float) as a safety measure
 * @author doug <doug@unlikelysource.com
 *
 */
class FormSelectDivSpan extends AbstractHelper
{

	/**
	 * Takes a form element + params and produces a series of radio button markup like this:
        <div class="dropdown">
            <button class="btn btn-select dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
            Choose
            <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">First Action</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Second Action</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Third Action</a></li>
            </ul>
        </div>
	 * 
	 * @param Zend\Form\Element
	 * @param string $divClass
	 * @param string $buttonClass
	 * @param string $buttonId
	 * @return string $output = HTML w/ proper markup
	 */
	public function __invoke(Element $element, $divClass, $buttonClass, $buttonId)
	{
	    $values  = $element->getValueOptions();
	    $current = $element->getAttribute('value');
	    $type    = $element->getAttribute('type');
	    $output  = '';
	    $output .= '<div class="' . $divClass . '">' . PHP_EOL;
	    $output .= sprintf('<button class="%s" type="button" id="%s" data-toggle="">', 
	                       $buttonClass, $buttonId, $divClass) . PHP_EOL;
	    $output .= 'Choose' . PHP_EOL;
	    $output .= '<span class="caret"></span>' . PHP_EOL;
        $output .= '</button>' . PHP_EOL;
	    if ($values && is_array($values)) {
	        $output .= '<ul class="dropdown-menu" role="menu" aria-labelledby="' . $buttonId . '">';
	        foreach ($values as $key => $value) {
                //  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">First Action</a></li>
	            $output .= '<li role="presentation">' . PHP_EOL;
                $output .= '<a role="menuitem" tabindex="-1" href="#">';
                $output .= $value;
                $output .= '</a></li>' . PHP_EOL;
	        }
	        $output .= '</ul>' . PHP_EOL;
	    }
	    $output .= '</div>' . PHP_EOL;
	    return $output;
	}
}
