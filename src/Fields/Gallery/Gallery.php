<?php
namespace Takeatea\TeaThemeOptions\Fields\Gallery;

use Takeatea\TeaThemeOptions\TeaFields;

/**
 * TEA GALLERY FIELD
 * 
 * Copyright (C) 2014, Achraf Chouk - ach@takeatea.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * To add this field, simply make the same as follow:
 * array(
 *     'type' => 'gallery',
 *     'title' => 'Show me your treasures...',
 *     'contents' => array(
 *         array(
 *             'content' => 'Yeah, I am the best at Super Bomberman 2 on SNES :D',
 *             'image' => 39 //Use image ID
 *         )
 *         //You can repeat this array as much as you want
 *     ),
 *     'id' => 'my_gallery_field_id'
 * )
 *
 */

if (!defined('ABSPATH')) {
    die('You are not authorized to directly access to this page');
}

//----------------------------------------------------------------------------//

/**
 * Tea Fields Gallery
 *
 * To get its own Fields
 *
 * @package Tea Fields
 * @subpackage Tea Fields Gallery
 * @since 1.4.0
 *
 */
class Gallery extends TeaFields
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
    public function templatePages($content, $post = array())
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
        $title = isset($content['title']) ? $content['title'] : __('Tea Gallery', TTO_I18N);
        $std = isset($content['std']) ? $content['std'] : '';
        $description = isset($content['description']) ? $content['description'] : '';
        $can_upload = $this->getCanUpload();
        $delete = __('Delete selection', TTO_I18N);

        //Default way
        if (empty($post)) {
            //Check selected
            $vals = $this->getOption($id, $std);
            $vals = empty($vals) ? array(0) : (is_array($vals) ? $vals : array($vals));
        }
        //On CPT
        else {
            //Check selected
            $value = get_post_custom($post->ID);
            /*$a = preg_replace_callback('/s:(\d+):"(.*?)";/s', function($m){
                return 's:'.strlen($m[2]).':"'.$m[2].'";';
            }, $value[$post->post_type . '-' . $id][0]);*/

            $vals = isset($value[$post->post_type . '-' . $id]) ? unserialize($value[$post->post_type . '-' . $id][0]) : $std;
            $vals = empty($vals) ? array(0) : (is_array($vals) ? $vals : array($vals));
        }

        //Get template
        include(TTO_PATH . '/Fields/Gallery/in_pages.tpl.php');
    }
}
