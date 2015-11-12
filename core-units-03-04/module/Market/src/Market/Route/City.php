<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Market\Route;

use Traversable;
use Zend\Mvc\Router\Http\RouteInterface;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Mvc\Router\Exception;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\RequestInterface as Request;

use Market\Model\ListingsTable;
use Market\Model\ListingsTableAwareInterface;

class City implements RouteInterface, ListingsTableAwareInterface
{

    const DEFAULT_PATTERN = '!/city/(\w+| )!';
    
    protected $listingsTable;
    
    /**
     * RouteInterface to match.
     *
     * @var string
     */
    protected $route;

    /**
     * Default values.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Create a new literal route.
     *
     * @param  string $route
     * @param  array  $defaults
     */
    public function __construct($route, array $defaults = array())
    {
        $this->route    = $route;
        $this->defaults = $defaults;
    }

    /**
     * factory(): defined by RouteInterface interface.
     *
     * @see    \Zend\Mvc\Router\RouteInterface::factory()
     * @param  array|Traversable $options
     * @return Literal
     * @throws Exception\InvalidArgumentException
     */
    public static function factory($options = array())
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        } elseif (!is_array($options)) {
            throw new Exception\InvalidArgumentException(__METHOD__ . ' expects an array or Traversable set of options');
        }

        if (!isset($options['route'])) {
            throw new Exception\InvalidArgumentException('Missing "route" in options array');
        }

        if (!isset($options['defaults'])) {
            $options['defaults'] = array();
        }

        return new static($options['route'], $options['defaults']);
    }

    /**
     * match(): defined by RouteInterface interface.
     * @TODO: fix bugs!!!
     * @see    \Zend\Mvc\Router\RouteInterface::match()
     * @param  Request      $request
     * @param  integer|null $pathOffset
     * @return RouteMatch|null
     */
    public function match(Request $request, $pathOffset = null)
    {
        if (!method_exists($request, 'getUri')) {
            return;
        }

        $uri     = $request->getUri();
        $path    = $uri->getPath();
        $pattern = (isset($this->defaults['pattern'])) 
                 ? $this->defaults['pattern'] 
                 : self::DEFAULT_PATTERN;
        $this->defaults['countries'] = array();
        $this->defaults['city']      = '';
        $routeMatch = new RouteMatch($this->defaults, strlen($this->route));
        
        if ($pathOffset !== null) {
            if ($pathOffset >= 0 && strlen($path) >= $pathOffset && !empty($this->route)) {
                if (strpos($path, $this->route, $pathOffset) === $pathOffset) {
                    return $routeMatch;
                }
            }
            return;
        }

        if (preg_match($pattern, $path, $matches)) {
            if (isset($matches[1])) {
                $countries = $this->listingsTable->select(['city' => $matches[1]]);
                if ($countries) {
                    $list = array();
                    foreach ($countries as $item) {
                        $list[] = $item->country;
                    }
                    $this->defaults['countries'] = $list;
                    $this->defaults['city']      = $matches[1];
                    $routeMatch = new RouteMatch($this->defaults, strlen($this->route));
                }
            }
            return $routeMatch;
        }
        return;
    }

    /**
     * assemble(): Defined by RouteInterface interface.
     *
     * @see    \Zend\Mvc\Router\RouteInterface::assemble()
     * @param  array $params
     * @param  array $options
     * @return mixed
     */
    public function assemble(array $params = array(), array $options = array())
    {
        return $this->route;
    }

    /**
     * getAssembledParams(): defined by RouteInterface interface.
     *
     * @see    RouteInterface::getAssembledParams
     * @return array
     */
    public function getAssembledParams()
    {
        return array();
    }
    
    /**
     * @return the $listingsTable
     */
    public function getListingsTable()
    {
        return $this->listingsTable;
    }

    /**
     * @param field_type $listingsTable
     */
    public function setListingsTable(ListingsTable $listingsTable)
    {
        $this->listingsTable = $listingsTable;
    }

}
