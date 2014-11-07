<?php
namespace Takeatea\TeaThemeOptions\Fields\Elasticsearch;

use Takeatea\TeaThemeOptions\TeaThemeOptions;
use Takeatea\TeaThemeOptions\TeaAdminMessage;
use Takeatea\TeaThemeOptions\TeaElasticsearch;
use Takeatea\TeaThemeOptions\TeaFields;

/**
 * TEA ELASTICSEARCH FIELD
 * You do not have to use it
 *
 */

if (!defined('ABSPATH')) {
    die('You are not authorized to directly access to this page');
}

//---------------------------------------------------------------------------------------------------------//

/**
 * Tea Fields Network
 *
 * To get its own Fields
 *
 * @since 1.4.3.10
 *
 */
class Elasticsearch extends TeaFields
{
    //Define protected vars
    private $currentpage;
    private $id = 'elastic';

    /**
     * Constructor.
     *
     * @since 1.4.0
     */
    public function __construct(){}


    //--------------------------------------------------------------------------//

    /**
     * MAIN FUNCTIONS
     **/

    /**
     * Build HTML component to display in all the Tea T.O. defined pages.
     *
     * @param array $content Contains all data
     * @param array $post Contains all post data
     *
     * @since 1.4.3.10
     */
    public function templatePages($content, $post = array(), $prefix = '')
    {
        //Do not display Elasticsearch field on CPTs
        if (!empty($post)) {
            return;
        }

        //Default variables
        $id = $this->getId();
        $title = isset($content['title']) ? $content['title'] : __('Tea Elasticsearch', TTO_I18N);
        $description = isset($content['description']) ? $content['description'] : '';
        $page = $this->getCurrentPage();
        $index = TeaThemeOptions::getConfigs('elastic_index');
        $index = $index[0];

        //Default values
        $std = isset($content['std']) ? $content['std'] : array(
            'enable' => 'no',
            'status' => 0,
            'server_host' => 'localhost',
            'server_port' => '9200',
            'index_name' => 'teasearch',
            'read_timeout' => 5,
            'write_timeout' => 10,
            'template' => 'no',
            'scores' => array(),
            'index_post' => array(),
            'index_tax' => array()
        );

        //Get scores
        //$scores = TeaElasticsearch::getFields();

        //Check selected
        $vals = TeaThemeOptions::getConfigs($id);
        $vals = empty($vals) ? array(0) : (is_array($vals) ? $vals : array($vals));
        $vals = array_merge($std, $vals);

        //Get template
        include(TTO_PATH.'/Fields/Elasticsearch/in_pages.tpl.php');
    }

    /**
     * Build action method.
     *
     * @param array $request Contains all data sent in $_REQUEST method
     *
     * @since 1.4.3.10
     */
    public function actionElasticsearch($request)
    {
        //Check if we are in admin panel
        if (!TTO_IS_ADMIN) {
            return;
        }

        //Check if this action was properly called
        if (!isset($request['for']) || 'elasticsearch' != $request['for']) {
            return;
        }

        //Get id
        $id = $this->getId();

        //Check if this action was properly called
        if (isset($request['tea_elastic_create'])) {
            //Create index
            $this->createElasticsearch();
        }
        else if (isset($request['tea_elastic_enable'])) {
            //Dis/anable Elasticsearch
            $this->enableElasticsearch($request);
        }
        else if (isset($request['tea_elastic_index'])) {
            //Index datas
            $this->indexElasticsearch();
        }
        else if (isset($request[$id])) {
            //Update datas
            $this->updateElasticsearch($request);
        }
    }

    /**
     * Create the index for all datas.
     *
     * @since 1.4.3.10
     */
    public function createElasticsearch()
    {
        //Check if we are in admin panel
        if (!TTO_IS_ADMIN) {
            return;
        }

        //Get id
        $id = $this->getId();

        //Get datas
        $ctn = TeaThemeOptions::getConfigs($id, array());

        //Check if this action was properly called
        if (!isset($ctn['enable']) || 'yes' != $ctn['enable']) {
            return;
        }

        //Check status
        if (!isset($ctn['status']) || 404 != $ctn['status']) {
            //We do not need to create the Index
            return;
        }

        //Create new occurrence
        $els = new TeaElasticsearch(false);
        $els->createElasticsearch();

        //Get Connection status
        $ctn['status'] = TeaElasticsearch::elasticaConnection($ctn);

        //Define data in DB
        TeaThemeOptions::setConfigs($id, $ctn);
        TeaThemeOptions::setConfigs('elastic_index', 0);
    }

    /**
     * Index all search datas.
     *
     * @param array $request Contains all data sent in $_REQUEST method
     *
     * @since 1.4.3.10
     */
    public function enableElasticsearch($request)
    {
        //Check if we are in admin panel
        if (!TTO_IS_ADMIN) {
            return;
        }

        //Get id
        $id = $this->getId();

        //Check if this action was properly called
        if (!isset($request[$id], $request[$id]['enable'])) {
            return;
        }

        //Get datas
        $ctn = TeaThemeOptions::getConfigs($id, array());

        //Enable or disable Elasticsearch
        $ctn['enable'] = $request[$id]['enable'];
        $ctn['status'] = 0;

        //Update datas
        TeaThemeOptions::setConfigs($id, $ctn);
        TeaThemeOptions::setConfigs('elastic_index', 0);
    }

    /**
     * Index all search datas.
     *
     * @since 1.4.3.10
     */
    public function indexElasticsearch()
    {
        //Check if we are in admin panel
        if (!TTO_IS_ADMIN) {
            return;
        }

        //Create new occurrence
        $els = new TeaElasticsearch(false);
        $results = $els->indexContents();
        TeaThemeOptions::setConfigs('elastic_index', $results);

        //Checks contents
        if (!$results) {
            TeaAdminMessage::__display(
                __('Something went wrong: it seems you 
                forgot to attach contents to the current page.', TTO_I18N)
            );
        }
        else if (1 == $results) {
            TeaAdminMessage::__display(
                __('Great: your post has been indexed!', TTO_I18N)
            );
        }
        else {
            TeaAdminMessage::__display(sprintf(
                __('Good job: %d posts have been indexed!', TTO_I18N),
                $results
            ));
        }
    }

    /**
     * Update all search datas.
     *
     * @param array $request Contains all data sent in $_REQUEST method
     *
     * @since 1.4.3.10
     */
    public function updateElasticsearch($request)
    {
        //Check if we are in admin panel
        if (!TTO_IS_ADMIN) {
            return;
        }

        //Check values integrity
        $id = $this->getId();
        $ctn = TeaThemeOptions::getConfigs($id);

        //Check old vars vs new
        $shost = $request[$id]['server_host'] != $ctn['server_host'] ? 1 : 0;
        $sport = $request[$id]['server_port'] != $ctn['server_port'] ? 1 : 0;
        $sname = $request[$id]['index_name'] != $ctn['index_name'] ? 1 : 0;

        //Check old values
        if ($shost || $sport || $sname) {
            TeaThemeOptions::setConfigs('elastic_index', 0);
            $ctn['status'] = 0;
        }

        //Update all datas
        $new = array_merge($ctn, $request[$id]);

        //Get Connection status
        if (0 == $new['status']) {
            $new['status'] = TeaElasticsearch::elasticaConnection($new);
        }

        //Define data in DB
        TeaThemeOptions::setConfigs($id, $new);
    }

    /**
     * ACCESSORS
     **/

    /**
     * Retrieve the $currentpage value
     *
     * @return string $currentpage Get the current page
     *
     * @since 1.4.0
     */
    protected function getCurrentPage()
    {
        //Return value
        return $this->currentpage;
    }

    /**
     * Define the $currentpage value
     *
     * @param string $currentpage Get the current page
     *
     * @since 1.4.0
     */
    public function setCurrentPage($currentpage = '')
    {
        //Define value
        $this->currentpage = $currentpage;
    }

    /**
     * Retrieve the $id value
     *
     * @return string $id Get the current id
     *
     * @since 1.4.0
     */
    protected function getId()
    {
        //Return value
        return $this->id;
    }
}
