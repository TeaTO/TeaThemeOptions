<?php
namespace Takeatea\TeaThemeOptions\Fields\Upload;

use Takeatea\TeaThemeOptions\TeaFields;

/**
 * TEA UPLOAD FIELD
 *
 *
 * To add this field, simply make the same as follow:
 * array(
 *     'type' => 'upload',
 *     'title' => 'Upload',
 *     'id' => 'simple_upload',
 *     'std' => get_template_directory_uri() . 'img/my_default_image.png',
 *     'description' => 'Simple description to upload panel'
 * )
 *
 */

if (!defined('ABSPATH')) {
    die('You are not authorized to directly access to this page');
}

//----------------------------------------------------------------------------//

/**
 * Tea Fields Upload
 *
 * To get its own Fields
 *
 * @package Tea Fields
 * @subpackage Tea Fields Upload
 * @since 1.4.0
 *
 */
class Upload extends TeaFields
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
        //Check if an id is defined at least
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
        $title = isset($content['title']) ? $content['title'] : __('Tea Upload', TTO_I18N);
        $std = isset($content['std']) ? $content['std'] : '';
        $library = isset($content['library']) ? $content['library'] : 'image';
        $description = isset($content['description']) ? $content['description'] : '';
        $multiple = isset($content['multiple']) && (true === $content['multiple'] || '1' == $content['multiple']) ? '1' : '0';
        $can_upload = $this->getCanUpload();
        $delete = __('Delete selection', TTO_I18N);

        //Default way
        if (empty($post)) {
            //Check selected
            $val = $this->getOption($prefix.$id, $std);
        }
        //On CPT
        else {
            //Check selected
            $val = get_post_meta($post->ID, $post->post_type . '-' . $id, true);
        }

        //Get template
        include(TTO_PATH . '/Fields/Upload/in_pages.tpl.php');
    }
}
