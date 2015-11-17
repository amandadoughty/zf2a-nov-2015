<?php
namespace Guestbook\Service;

use Zend\View\Helper\AbstractHtmlElement;

class HtmlTableRowHelper extends AbstractHtmlElement
{
	public function __invoke(array $items)
	{
		$output = '';
		foreach ($items as $value) {
			$output .= '<td>' . htmlspecialchars($value) . '</td>';
		}
		return '<tr>' . $output . '</tr>' . PHP_EOL;		
	}
}