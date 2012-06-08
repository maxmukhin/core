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
 * @since     1.0.23
 */

namespace XLite\Core\EventListener\Base;

/**
 * Abstract countable task
 * 
 * @see   ____class_see____
 * @since 1.0.23
 */
abstract class Countable extends \XLite\Core\EventListener\AEventListener
{
    /**
     * Event record 
     * 
     * @var   array
     * @see   ____var_see____
     * @since 1.0.23
     */
    protected $record;

    /**
     * Get event name 
     * 
     * @return string
     * @see    ____func_see____
     * @since  1.0.23
     */
    abstract protected function getEventName();

    /**
     * Get length 
     * 
     * @return integer
     * @see    ____func_see____
     * @since  1.0.23
     */
    abstract protected function getLength();

    /**
     * Get items 
     * 
     * @return array
     * @see    ____func_see____
     * @since  1.0.23
     */
    abstract protected function getItems();

    /**
     * Process item 
     * 
     * @param mixed $item Item
     *  
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.23
     */
    abstract protected function processItem($item);

    /**
     * Handle event (internal, after checking)
     *
     * @param string $name      Event name
     * @param array  $arguments Event arguments OPTIONAL
     *
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.19
     */
    public function handleEvent($name, array $arguments)
    {
        $result = false;

        $this->initializeStep();

        if ($this->isStepValid()) {

            $this->startStep();
            $repo = \XLite\Core\Database::getRepo('XLite\Model\TmpVar');
            foreach ($this->getItems() as $item) {
                if ($this->processItem($item)) {
                    $this->record['position']++;
                    $repo->setEventState($this->getEventName(), $this->record);
                }
            }

            if ($this->record['length'] <= $this->record['position'] + 1) {
                $this->finishTask();

            } else {
                $this->finishStep();
            }

            $result = true;
        }

        return $result;
    }

    /**
     * Initialize step 
     * 
     * @return void
     * @see    ____func_see____
     * @since  1.0.23
     */
    protected function initializeStep()
    {
        $this->record = \XLite\Core\Database::getRepo('XLite\Model\TmpVar')->getEventState($this->getEventName());
    }

    /**
     * Check step valid state
     * 
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.23
     */
    protected function isStepValid()
    {
        return !empty($this->record) && 0 < $this->getLength();
    }

    /**
     * Start step 
     * 
     * @return void
     * @see    ____func_see____
     * @since  1.0.23
     */
    protected function startStep()
    {
        if (0 == $this->record['length']) {
            $this->record['length'] = $this->getLength();
        }
    }

    /**
     * Finish step 
     * 
     * @return void
     * @see    ____func_see____
     * @since  1.0.23
     */
    protected function finishStep()
    {
        $event = $this->getEventName();
        \XLite\Core\EventTask::$event();
    }

    /**
     * Finish task 
     * 
     * @return void
     * @see    ____func_see____
     * @since  1.0.23
     */
    protected function finishTask()
    {
    }    
}
