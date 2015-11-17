<?php
namespace Application\Helper;
use Zend\View\Helper\AbstractHelper;

/**
 * Given a string <input name="someName" type="text" etc. />
 * returns <input name="$prefix[someName][$count]" type="text" etc. />
 * @author aed
 *
 */
class MakeElementArray extends AbstractHelper
{
	/**
	 * 
	 * @param string $element = HTML
	 * @param string $prefix
	 * @param int $count
	 * @return string HTML
	 */
	public function __invoke($element, $prefix, $count)
	{
		$pattern = '/name="(.+?)"/';
		$replace = sprintf('name="%s[%d][$1]"', $prefix, $count);
		return preg_replace($pattern, $replace, $element);
	}
}
