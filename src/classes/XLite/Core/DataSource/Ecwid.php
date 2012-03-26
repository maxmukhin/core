<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * LiteCommerce
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@litecommerce.com so we can send you a copy immediately.
 * 
 * PHP version 5.3.0
 * 
 * @category  LiteCommerce
 * @author    Creative Development LLC <info@cdev.ru> 
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 * @see       ____file_see____
 * @since     1.0.17
 */

namespace XLite\Core\DataSource;

/**
 * Ecwid data source
 * 
 * @see   ____class_see____
 * @since 1.0.17
 */
class Ecwid extends ADataSource
{

    /**
     * Get Ecwid data source name
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.17
     */
    public static function getName()
    {
        return 'Ecwid';
    }

    /**
     * Get Ecwid data source name
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.17
     */
    public static function getType()
    {
        return \XLite\Model\DataSource::TYPE_ECWID;
    }

    /**
     * Get standardized data source information array
     * 
     * @return array
     * @see    ____func_see____
     * @since  1.0.17
     */
    public function getInfo()
    {
        return $this->callApi('profile');
    }

    /**
     * Checks whether the data source is valid
     * 
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.17
     */
    public function isValid()
    {
        $result = false;

        if (0 < $this->getStoreId()) {

            try {
                $result = (bool)$this->callApi('profile');

            } catch(\Exception $e) {
            }
        }

        return $result;
    }

    /**
     * Request and return products collection
     * 
     * @return \XLite\Core\DataSource\Ecwid\Products
     * @see    ____func_see____
     * @since  1.0.17
     */
    public function getProductsCollection()
    {
        return new \XLite\Core\DataSource\Ecwid\Products($this);
    }

    /**
     * Request and return categories collection
     * 
     * @return \XLite\Core\DataSource\Ecwid\Categories
     * @see    ____func_see____
     * @since  1.0.17
     */
    public function getCategoriesCollection()
    {
        return new \XLite\Core\DataSource\Ecwid\Categories($this);
    }

    /**
     * Get Ecwid Store ID
     * 
     * @return integer
     * @see    ____func_see____
     * @since  1.0.17
     */
    public function getStoreId()
    {
        return $this->getConfiguration()->getParameterValue('storeid');
    }

    /**
     * Does an Ecwid API call
     * 
     * @param string $apiMethod API method name to call
     * @param string $params    Parameters to pass along OPTIONAL
     *  
     * @return array
     * @throws Exception
     * @see    ____func_see____
     * @since  1.0.17
     */
    public function callApi($apiMethod, $params = array())
    {
        $url = 'http://app.ecwid.com/api/v1/'
            . $this->getStoreId() . '/'
            . $apiMethod
            . ($params ? ('?' . http_build_query($params)) : '');

        $bouncer = new \XLite\Core\HTTP\Request($url);

        $bouncer->requestTimeout = 5;
        $response = $bouncer->sendRequest();

        $result = null;

        if (200 == $response->code) {
            $result = json_decode($response->body, true);

        } else {
            throw new \Exception('Call to \'' . $url . '\' failed with \'' . $response->code . '\' code');
        }

        return $result;
    }

    /**
     * Performs batch api call
     * Takes an array of parameters in the following form:
     * array (
     *     'product_33' => array (
     *         'method' => 'product',
     *         'params' => array('id' => 33)
     *     ),
     *     'product_34' => array (
     *         'method' => 'product',
     *         'params' => array('id' => 34)
     *     )
     * )
     * Returns an array containing keys specified in the input along with results for each call
     * 
     * @param array $params An array of call parameters
     *  
     * @return array
     * @see    ____func_see____
     * @since  1.0.17
     */
    public function callBatchApi(array $params)
    {
        $queries = array();

        foreach ($params as $key => $param) {
            $queryParams = array();
            foreach ($param['params'] as $k => $v) {
                $queryParams[] = $k . '=' . $v;
            }

            $queries[$key] = $param['method'] . '?' . implode('&', $queryParams);
        }

        return $this->callApi('batch', $queries);
    }
}
