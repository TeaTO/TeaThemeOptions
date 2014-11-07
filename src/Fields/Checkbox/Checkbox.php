<?php
namespace Takeatea\TeaThemeOptions\Fields\Checkbox;

use Takeatea\TeaThemeOptions\TeaThemeOptions;
use Takeatea\TeaThemeOptions\TeaFields;

/**
 * TEA CHECKBOX FIELD
 *
 *
 * To add this field, simply make the same as follow:
 * array(
 *     'type' => 'checkbox',
 *     'title' => 'What are your preferred personas?',
 *     'id' => 'my_checkbox_field_id',
 *     'std' => array('minions', 'lapinscretins'), //define the default choice(s)
 *     'description' => '',
 *     //define your options
 *     'options' => array(
 *         'minions' => 'The Minions', //value => label
 *         'lapinscretins' => 'The Lapins Crétins',
 *         'marvel' => 'All Marvel Superheroes',
 *         'franklin' => 'Franklin (everything is possible)',
 *         'spongebob' => 'Spongebob (nothing to say... Love it!)'
 *     )
 * )
 *
 */

if (!defined('ABSPATH')) {
    die('You are not authorized to directly access to this page');
}

//----------------------------------------------------------------------------//

/**
 * Tea Fields Checkbox
 *
 * To get its own Fields
 *
 * @package Tea Fields
 * @subpackage Tea Fields Checkbox
 * @since 1.4.0
 *
 */
class Checkbox extends TeaFields
{
    //Define protected vars

    /**
     * Constructor.
     *
     * @since 1.3.0
     */
    public function __construct(){}


    //------------------------------------------------------------------------//

    /**
     * MAIN FUNCTIONS
     **/

    /**
     * Build HTML component to display in all the Tea T.O. defined pages.
     *
     * @param array $content Contains all data
     * @param array $post Contains all post data
     *
     * @since 1.4.0
     */
    public function templatePages($content, $post = array(), $prefix = '')
    {
        //Check current post on CPTs
        if (empty($post)) {
            //Check if an id is defined at least
            $this->checkId($content);
        }
        else {
            //Modify content
            $content = $content['args']['contents'];
        }

        //Default variables
        $id = $content['id'];
        $title = isset($content['title']) ? $content['title'] : __('Tea Checkbox', TTO_I18N);
        $description = isset($content['description']) ? $content['description'] : '';
        $std = isset($content['std']) ? $content['std'] : array();
        $options = isset($content['options']) ? $content['options'] : array();
        $count = count($options);

        //Default way
        if (empty($post)) {
            //Check selected
            $vals = TeaThemeOptions::get_option($prefix.$id, $std);
            $vals = empty($vals) ? array(0) : (is_array($vals) ? $vals : array($vals));
        }
        //On CPT
        else {
            //Check selected
            $vals = get_post_meta($post->ID, $post->post_type . '-' . $id, false);
            $vals = empty($vals) ? $std : (is_array($vals) ? $vals[0] : array($vals));
        }

        //Get template
        include(TTO_PATH.'/Fields/Checkbox/in_pages.tpl.php');
    }
}
