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
 * @category   LiteCommerce
 * @package    XLite
 * @subpackage Model
 * @author     Creative Development LLC <info@cdev.ru> 
 * @copyright  Copyright (c) 2010 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    SVN: $Id$
 * @link       http://www.litecommerce.com/
 * @see        ____file_see____
 * @since      3.0.0
 */

/**
 * ____description____
 * 
 * @package XLite
 * @see     ____class_see____
 * @since   3.0.0
 */
class XLite_Model_Profiler extends XLite_Base implements XLite_Base_ISingleton 
{
    /**
     * List of executed queries 
     * 
     * @var    array
     * @access protected
     * @since  3.0.0
     */
    protected static $queries = array();


    /**
     * Determines if profiler is switched on/off
     * 
     * @var    bool
     * @access public
     * @since  3.0.0
     */
    public $enabled = false;


    /**
     * getStartupFlag 
     * 
     * @return bool
     * @access protected
     * @since  3.0.0
     */
    protected function getStartupFlag()
    {
        return XLite::getInstance()->getOptions(array('profiler_details', 'enabled')) && !XLite_Core_Request::getInstance()->isPopup;
    }

	/**
	 * Use this function to get a reference to this class object 
	 * 
	 * @return XLite_Model_Profiler
	 * @access public
	 * @since  3.0.0
	 */
	public static function getInstance()
    {
        return self::getInternalInstance(__CLASS__);
    }

    /**
     * Constructor
     * 
     * @return void
     * @access public
     * @since  3.0.0
     */
    public function __construct()
    {
        $this->start($this->getStartupFlag());
    }

	/**
     * Destructor
     *
     * @return void
     * @access public
     * @since  3.0.0
     */
    public function __destruct()
    {
		$this->stop();
    }








    public $query_time = array();	

    function log($timePoint)
    {
    	if (!isset($this->latest_point)) {
        	$this->latest_point = $this->start_time;
    	} else {
        	$this->latest_point = $this->new_latest_point;
    	}
        $this->new_latest_point = microtime(true);
        $this->$timePoint = number_format($this->new_latest_point - $this->start_time, 4);
        $timePointDelta = $timePoint . "_delta";
        $this->$timePointDelta = number_format($this->new_latest_point - $this->latest_point, 4);
    }
    
    function start($start)
    {
        $this->enabled = !empty($start);
        $this->start_time = microtime(true);
    }
    
    function stop()
    {
        if (!$this->enabled) return;

        $this->stop_time = microtime(true);
        global $parserTime;
        $this->parserTime = $parserTime;
        $this->includedFilesCount = count(get_included_files());
        $this->includedFiles = array();
        $this->includedFileSizes = array();
        $this->includedFilesTotal = 0;
        foreach (get_included_files() as $file) {
            $this->includedFiles[] = $file;
            $size = @filesize($file);
            $this->includedFileSizes[] = $size;
            $this->includedFilesTotal += $size;
        }
		$this->includedFilesTotal /= 1000;
        array_multisort($this->includedFileSizes,SORT_DESC, $this->includedFiles);
        for ($i=0; $i<count($this->includedFiles); $i++) {
            $a = new StdClass();
            $a->name = $this->includedFiles[$i];
            $a->size = $this->includedFileSizes[$i];
            $this->includedFiles[$i] = $a;
        }

        $this->display();
    }
    
    function display()
    {
    	$this->total_time_sum = 0;
?>
<p align=left>
<table border=0>
<tr><td style="FONT-WEIGHT: bold; COLOR: red ">EXECUTION TIME</td><td><?php print number_format($this->stop_time - $this->start_time, 4); ?></td></tr>
<tr><td style="FONT-WEIGHT: bold; COLOR: red ">MEMORY PEAK USAGE</td><td><?php printf("%.2f Mb", memory_get_peak_usage() / 1024 / 1024); ?></td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td style="FONT-WEIGHT: bold;">TOTAL QUERIES</td><td><?php print $this->getTotalQueries(); ?></td></tr>
<tr><td style="FONT-WEIGHT: bold;">TOTAL QUERIES TIME</td><td><?php print $this->getTotalQueriesTime(); ?></td></tr>
</table>

<p>Queries log:
<p>
<?php
foreach (self::$queries as $query => $count) {
    echo "[" . ($count>3?"<font color=red>$count</font>":$count)."] $query<br>\n";
}
?>
<!--
<b>Total time:</b> <?php print $this->getTotalTime(); ?> sec.<br>
<br>
<b>XLite startup time:</b>
PHP parser time: {profiler.parserTime} sec.,
Included files: {profiler.includedFilesCount},
Included files total size: {profiler.includedFilesTotal},
Database connect time: {profiler.dbConnectTime} sec.
<br>
<b>XLite init time:</b><br>
read config: <?php print $this->read_cfg_time; ?> sec.,<br>
modules manager: <?php print $this->mm_init_time; ?> sec.,<br>
session: <?php print $this->ss_time; ?> sec.<br>
<br>
<b>Xlite init total time:</b> <?php print $this->init_time; ?> sec.<br>
<b>Run time:</b> <?php print $this->exec_time - $this->start_time; ?> sec.<br>
<b>Display time:</b> <?php print $this->run_time; ?> sec.<br>
<br>
<b>SQL total queries:</b> {profiler.getTotalQueries()}<br>
<b>SQL total queries time:</b> {profiler.getTotalQueriesTime()} sec.<br>
<b>SQL queries statistics:</b><br>
<span FOREACH="profiler.queries,query,count">
<b>Total:</b> {count}, <b>Time:</b> {profiler.getQueryTime(query)}, <b>Query:</b> {query:h}<br>
</span>
<b>.</b>

Included file sizes: <table>{foreach:profiler.includedFiles,file} <tr><td>{file.name}</td><td>{file.size}</td></tr>{end:} </table>
</p>
-->
<?php
    }

    function displayTime()
    {
        return microtime(true) - $this->displayTime;
    }
    
    function getTotalTime()
    {
        return sprintf("%.03f", $this->stop_time - $this->start_time);
    }

    function addQuery($query)
    {
        // Uncomment if you want to truncate queries
        /*if (strlen($query)>300) {
            $query = substr($query, 0, 300) . ' ...';
            
        }*/

        if (isset(self::$queries[$query])) {
            self::$queries[$query]++;
        } else {
            self::$queries[$query] = 1;
        }
    }

    function getTotalQueries()
    {
        return array_sum(self::$queries);
    }

    function getTotalQueriesTime()
    {
        return sprintf("%.03f", array_sum($this->query_time));
    }
    
    function setQueryTime($query, $time)
    {
        $this->query_time[$query] = $time;
    }
    
    function getQueryTime($query)
    {
        return sprintf("%.03f", $this->query_time[$query]);
    }
}
