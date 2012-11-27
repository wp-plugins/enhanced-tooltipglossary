<?php
/*
  Plugin Name: Enhanced Tooltip Glossary
  Plugin URI: http://www.cminds.com/plugins/enhanced-tooltipglossary/
  Description: Parses posts for defined glossary terms and adds links to the static glossary page containing the definition and a tooltip with the definition.
  Version: 1.31
  Author: CreativeMinds based on jatls tooltipglossary
 */

/*

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
define('RED_MENU_OPTION', 'red_menu_option');
define('RED_ABOUT_OPTION', 'red_about');
define('RED_SETTINGS_OPTION', 'red_settings');
//Add options needed for plugin
add_option('red_glossaryOnlySingle', 0); //Show on Home and Category Pages or just single post pages?
add_option('red_glossaryOnPages', 1); //Show on Pages or just posts?
add_option('red_glossaryID', 0); //The ID of the main Glossary Page
add_option('red_glossaryTooltip', 0); //Use tooltips on glossary items?
add_option('red_glossaryDiffLinkClass', 0); //Use different class to style glossary list
add_option('red_glossaryListTiles', 0); // Display glossary terms list as tiles
add_option('red_glossaryPermalink', 'glossary'); //Set permalink name
add_option('red_glossaryFirstOnly', 0); //Search for all occurances in a post or only one?
add_option('red_glossaryFilterTooltip', 30); //Clean the tooltip text fromuneeded chars?
add_option('red_glossaryLimitTooltip', 0); // Limit the tooltip length  ?
add_option('red_glossaryTermLink', 0); //Remove links to glossary page
add_option('red_glossaryExcerptHover', 0); //Search for all occurances in a post or only one?
add_option('red_glossaryProtectedTags', 1); //SAviod the use of Glossary in Protected tags?
// Register glossary custom post type
function red_create_post_types() {
    
    $glossaryPermalink = get_option('red_glossaryPermalink');
    $args = array(
        'label' => 'Glossary',
        'labels' => array(
            'add_new_item' => 'Add New Glossary Item',
            'edit_item' => 'Edit Glossary Item',
            'view_item' => 'View Glossary Item',
            'singular_name' => 'Glossary Item',
            'name' => 'CM Glossary',
            'menu_name' => 'Glossary'
        ),
        'description' => '',
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => RED_MENU_OPTION,
        '_builtin' => false,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => $glossaryPermalink, 'with_front' => false),
        'query_var' => true,
        
        'supports' => array('title', 'editor', 'author', 'excerpt'));
    register_post_type('glossary',$args);
}

add_action('init', 'red_create_post_types');
function red_admin_menu() {
    $page = add_menu_page('Glossary', 'CM Glossary', 'manage_options', RED_MENU_OPTION, 'red_adminMenu');
    add_submenu_page(RED_MENU_OPTION, 'Add New', 'Add New', 'manage_options', 'post-new.php?post_type=glossary');
    add_submenu_page(RED_MENU_OPTION, 'TooltipGlossary Options', 'Settings', 'manage_options', RED_SETTINGS_OPTION, 'glossary_options');
    add_submenu_page(RED_MENU_OPTION, 'About', 'About', 'manage_options', RED_ABOUT_OPTION, 'red_about');
    add_filter('views_edit-glossary', 'red_filter_admin_nav', 10, 1);
}
add_action('admin_menu', 'red_admin_menu');
function red_adminMenu() {
    
}
function red_about() {
    ob_start();
    require 'admin_about.php';
    $content = ob_get_contents();
    ob_end_clean();
    require 'admin_template.php';
}
function red_filter_admin_nav($views) {
        global $submenu, $plugin_page, $pagenow;
        $scheme = is_ssl()?'https://':'http://';
        $adminUrl = str_replace($scheme.$_SERVER['HTTP_HOST'], '', admin_url());
        $homeUrl = home_url();
        $currentUri = str_replace($adminUrl, '', $_SERVER['REQUEST_URI']);
        $submenus = array();
        if (isset($submenu[RED_MENU_OPTION])) {
            $thisMenu = $submenu[RED_MENU_OPTION];
            foreach ($thisMenu as $item) {
                $slug = $item[2];
                $isCurrent = ($slug == $plugin_page || strpos($item[2], '.php')=== strpos($currentUri, '.php'));
                $url = (strpos($item[2], '.php')!==false)?$slug:get_admin_url('', 'admin.php?page='.$slug);
                $submenus[$item[0]] = 
                    '<a href="'.$url.'" class="'.($isCurrent?'current':'').'">'.$item[0].'</a>';
            }
            
        }
        return $submenus;
}
function red_showNav() {
    global $submenu, $plugin_page, $pagenow;
        $submenus = array();
        if (isset($submenu[RED_MENU_OPTION])) {
            $thisMenu = $submenu[RED_MENU_OPTION];
            foreach ($thisMenu as $item) {
                $slug = $item[2];
                $isCurrent = $slug == $plugin_page;
                $url = (strpos($item[2], '.php')!==false)?$slug:get_admin_url('', 'admin.php?page='.$slug);
                $submenus[] = array(
                    'link' => $url,
                    'title' => $item[0],
                    'current' => $isCurrent
                );
            }
            require('admin_nav.php');
        }
}
function glossary_flush_rewrite_rules() {

    // First, we "add" the custom post type via the above written function.
    red_create_post_types();

    flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'glossary_flush_rewrite_rules');

//Function parses through post entries and replaces any found glossary terms with links to glossary term page.
//Add tooltip stylesheet & javascript to page first
function red_glossary_js() {
    $glossary_path = WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
    wp_enqueue_script('tooltip-js', $glossary_path . 'tooltip.js');
}

add_action('wp_print_scripts', 'red_glossary_js');

function red_glossary_css() {
    $glossary_path = WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
    wp_enqueue_style('tooltip-css', $glossary_path . 'tooltip.css');
}

add_action('wp_print_styles', 'red_glossary_css');
// Sort longer titles first, so if there is collision between terms (e.g.,
// "essential fatty acid" and "fatty acid") the longer one gets created first.
function sortByWPQueryObjectTitleLength($a, $b) {
       $sortVal = 0;
       if (property_exists($a, 'post_title') && property_exists($b, 'post_title')) {
               $sortVal = strlen($b->post_title) - strlen($a->post_title);
       }
       return $sortVal;
}
function red_glossary_parse($content) {

    //Run the glossary parser
    if (((!is_page() && get_option('red_glossaryOnlySingle') == 0) OR
            (!is_page() && get_option('red_glossaryOnlySingle') == 1 && is_single()) OR
            (is_page() && get_option('red_glossaryOnPages') == 1))) {
        $glossary_index = get_children(array(
            'post_type' => 'glossary',
            'post_status' => 'publish',
            'order' => 'DESC',
            'orderby' => 'title'
                ));
               // Sort by title length (function above)
               uasort($glossary_index, 'sortByWPQueryObjectTitleLength');

        //the tag:[glossary_exclude]+[/glossary_exclude] can be used to mark text will not be taken into account by the glossary
        if ($glossary_index) {
            $timestamp = time();

            $excludeGlossary_regex = '/\\['                              // Opening bracket
                    . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
                    . "(glossary_exclude)"                     // 2: Shortcode name
                    . '\\b'                              // Word boundary
                    . '('                                // 3: Unroll the loop: Inside the opening shortcode tag
                    . '[^\\]\\/]*'                   // Not a closing bracket or forward slash
                    . '(?:'
                    . '\\/(?!\\])'               // A forward slash not followed by a closing bracket
                    . '[^\\]\\/]*'               // Not a closing bracket or forward slash
                    . ')*?'
                    . ')'
                    . '(?:'
                    . '(\\/)'                        // 4: Self closing tag ...
                    . '\\]'                          // ... and closing bracket
                    . '|'
                    . '\\]'                          // Closing bracket
                    . '(?:'
                    . '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
                    . '[^\\[]*+'             // Not an opening bracket
                    . '(?:'
                    . '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
                    . '[^\\[]*+'         // Not an opening bracket
                    . ')*+'
                    . ')'
                    . '\\[\\/\\2\\]'             // Closing shortcode tag
                    . ')?'
                    . ')'
                    . '(\\]?)/s';

            // define regular expression of tags Glossary should aviod
            if (get_option('red_glossaryProtectedTags') == 1) {
                $pre_regex = '/<pre[^>]*>(.*?)<\/pre>/si';
                $object_regex = '/<object[^>]*>(.*?)<\/object>/si';
                $span_regxA = '/<a[^>]*>(.*?)<\/a>/si';
                $span_regxH1 = '/<h1[^>]*>(.*?)<\/h1>/si';
                $span_regxH2 = '/<h2[^>]*>(.*?)<\/h2>/si';
                $span_regxH3 = '/<h3[^>]*>(.*?)<\/h3>/si';
                $script_regex = '/<script[^>]*>(.*?)<\/script>/si';
                $pretags = array();
                $objecttags = array();
                $spantagsA = array();
                $spantagsH1 = array();
                $spantagsH2 = array();
                $spantagsH3 = array();
                $scripttags = array();

                $preTagsCount = preg_match_all($pre_regex, $content, $pretags, PREG_PATTERN_ORDER);
                $i = 0;

                if ($preTagsCount > 0) {
                    foreach ($pretags[0] as $pretag) {
                        $content = preg_replace($pre_regex, '#' . $i . 'pre', $content, 1);
                        $i++;
                    }
                }

                $objectTagsCount = preg_match_all($object_regex, $content, $objecttags, PREG_PATTERN_ORDER);
                $i = 0;

                if ($objectTagsCount > 0) {
                    foreach ($objecttags[0] as $objecttag) {
                        $content = preg_replace($object_regex, '#' . $i . 'object', $content, 1);
                        $i++;
                    }
                }


                $spanATagsCount = preg_match_all($span_regxA, $content, $spantagsA, PREG_PATTERN_ORDER);
                $i = 0;

                if ($spanATagsCount > 0) {
                    foreach ($spantagsA[0] as $spantagA) {
                        $content = preg_replace($span_regxA, '#' . $i . 'a', $content, 1);
                        $i++;
                    }
                }


                $spanH1TagsCount = preg_match_all($span_regxH1, $content, $spantagsH1, PREG_PATTERN_ORDER);
                $i = 0;

                if ($spanH1TagsCount > 0) {
                    foreach ($spantagsH1[0] as $spantagH1) {
                        $content = preg_replace($span_regxH1, '#' . $i . 'H1', $content, 1);
                        $i++;
                    }
                }

                $spanH2TagsCount = preg_match_all($span_regxH2, $content, $spantagsH2, PREG_PATTERN_ORDER);
                $i = 0;

                if ($spanH2TagsCount > 0) {
                    foreach ($spantagsH2[0] as $spantagH2) {
                        $content = preg_replace($span_regxH2, '#' . $i . 'H2', $content, 1);
                        $i++;
                    }
                }

                $spanH3TagsCount = preg_match_all($span_regxH3, $content, $spantagsH3, PREG_PATTERN_ORDER);
                $i = 0;

                if ($spanH3TagsCount > 0) {
                    foreach ($spantagsH3[0] as $spantagH3) {
                        $content = preg_replace($span_regxH3, '#' . $i . 'H3', $content, 1);
                        $i++;
                    }
                }


                $scriptTagsCount = preg_match_all($script_regex, $content, $scripttags, PREG_PATTERN_ORDER);
                $i = 0;

                if ($scriptTagsCount > 0) {
                    foreach ($scripttags[0] as $scripttag) {
                        $content = preg_replace($script_regex, '#' . $i . 'script', $content, 1);
                        $i++;
                    }
                }
            }

            $excludeGlossaryStrs = array();

            //replace exclude tags and content between them in purpose to save the original text as is 
            //before glossary plug go over the content and add its code
            //(later will be returned to the marked places in content) 

            $excludeTagsCount = preg_match_all($excludeGlossary_regex, $content, $excludeGlossaryStrs, PREG_PATTERN_ORDER);
            $i = 0;

            if ($excludeTagsCount > 0) {
                foreach ($excludeGlossaryStrs[0] as $excludeStr) {
                    $content = preg_replace($excludeGlossary_regex, '#' . $i . 'excludeGlossary', $content, 1);
                    $i++;
                }
            }


            foreach ($glossary_index as $glossary_item) {
                $timestamp++;
                $glossary_title = $glossary_item->post_title;
                if ($GLOBALS['post']->post_type == 'glossary' && $GLOBALS['post']->post_title == $glossary_item->post_title)
                    continue;
                //old code bug-doesn't take into account href='' takes into account only href="")
                //$glossary_search = '/\b'.$glossary_title.'s*?\b(?=([^"]*"[^"]*")*[^"]*$)/i';
                $glossary_search = '/(?<!glossaryLink">)\b'.$glossary_title.'s*?\b(?=([^"]*"[^"]*")*[^"]*$)(?=([^\']*\'[^\']*\')*[^\']*$)(?!<\/a>)/i';
                $glossary_replace = '<a' . $timestamp . '>$0</a' . $timestamp . '>';

                $origContent = $content;

                if (get_option('red_glossaryFirstOnly') == 1) {
                    $content_temp = preg_replace($glossary_search, $glossary_replace, $content, 1);
                } else {
                    $content_temp = preg_replace($glossary_search, $glossary_replace, $content);
                }
                $content_temp = rtrim($content_temp);

                $link_search = '/<a' . $timestamp . '>(' . $glossary_item->post_title . '[A-Za-z]*?)<\/a' . $timestamp . '>/i';
                if (get_option('red_glossaryTooltip') == 1) {
                    if (get_option('red_glossaryExcerptHover') && $glossary_item->post_excerpt) {
                        $glossaryItemContent = $glossary_item->post_excerpt;
                    } else {
                        $glossaryItemContent = $glossary_item->post_content;
                    }
                    $glossaryItemContent = str_replace('[glossary_exclude]', '', $glossaryItemContent);
                    $glossaryItemContent = str_replace('[/glossary_exclude]', '', $glossaryItemContent);
                    
                    if (get_option('red_glossaryFilterTooltip') == 1) {
                        // remove paragraph, bad chars from tooltip text
                        $glossaryItemContent = str_replace(chr(10), "", $glossaryItemContent);
                        $glossaryItemContent = str_replace(chr(13), "", $glossaryItemContent);
                        $glossaryItemContent = str_replace('</p>', '<br/>', $glossaryItemContent);
                        $glossaryItemContent = strip_only($glossaryItemContent, '<p>');
                        $glossaryItemContent = strip_only($glossaryItemContent, '<img>');
                        $glossaryItemContent = strip_only($glossaryItemContent, '<a>');
                        $glossaryItemContent = htmlspecialchars($glossaryItemContent);
                        $glossaryItemContent = addslashes($glossaryItemContent);
                        $glossaryItemContent = str_replace("color:#000000", "color:#ffffff", $glossaryItemContent);
                        $glossaryItemContent = str_replace('\\[glossary_exclude\\]', '', $glossaryItemContent);
                    } else {
                        $glossaryItemContent = nl2br($glossaryItemContent);
                        $glossaryItemContent = str_replace("\r\n", "", $glossaryItemContent);
                        $glossaryItemContent = str_replace("\n", "", $glossaryItemContent);
                        
                        $glossaryItemContent = htmlentities($glossaryItemContent);
                    }

                    if ((get_option('red_glossaryLimitTooltip') > 30) && (strlen($glossaryItemContent) > get_option('red_glossaryLimitTooltip'))) {
                        $glossaryItemContent = substr($glossaryItemContent, 0, get_option('red_glossaryLimitTooltip')) . '    <strong>   More Details...<strong>';
                    }
                    $glossaryItemContent = str_replace('\'', '\\\'', $glossaryItemContent);
                    if (get_option('red_glossaryTermLink') == 1) {
                        $link_replace = '<span title="Glossary: '. $glossary_title . '" onmouseover="tooltip.show(\'' . $glossaryItemContent . '\');" onmouseout="tooltip.hide();" class="glossaryLink">$1</span>';
                    } else {
                        $link_replace = '<a href="' . get_permalink($glossary_item) . '" title="Glossary: ' . $glossary_title . '" onmouseover="tooltip.show(\'' . $glossaryItemContent . '\');" onmouseout="tooltip.hide();" class="glossaryLink">$1</a>';
                    }
                } else {
                    if (get_option('red_glossaryTermLink') == 1) {
                        $link_replace = '<span  title="Glossary: ' . $glossary_title . '" class="glossaryLink">$1</span>';
                    } else {
                        $link_replace = '<a href="' . get_permalink($glossary_item) . '" title="Glossary: ' . $glossary_title . '" class="glossaryLink">$1</a>';
                    }
                }
                $content_temp = preg_replace($link_search, $link_replace, $content_temp);
                $content = $content_temp;
            }


            if ($excludeTagsCount > 0) {
                $i = 0;
                foreach ($excludeGlossaryStrs[0] as $excludeStr) {
                    $content = str_replace('#' . $i . 'excludeGlossary', $excludeStr, $content);
                    $i++;
                }
                //remove all the exclude signs			
                $content = str_replace('[glossary_exclude]', "", $content);
                $content = str_replace('[/glossary_exclude]', "", $content);
            }


            if (get_option('red_glossaryProtectedTags') == 1) {

                if ($preTagsCount > 0) {
                    $i = 0;
                    foreach ($pretags[0] as $pretag) {
                        $content = str_replace('#' . $i . 'pre', $pretag, $content);
                        $i++;
                    }
                }

                if ($objectTagsCount > 0) {
                    $i = 0;
                    foreach ($objecttags[0] as $objecttag) {
                        $content = str_replace('#' . $i . 'object', $objecttag, $content);
                        $i++;
                    }
                }




                if ($spanH1TagsCount > 0) {
                    $i = 0;
                    foreach ($spantagsH1[0] as $spantagH1Content) {
                        $content = str_replace('#' . $i . 'H1', $spantagH1Content, $content);
                        $i++;
                    }
                }

                if ($spanH2TagsCount > 0) {
                    $i = 0;
                    foreach ($spantagsH2[0] as $spantagH2Content) {
                        $content = str_replace('#' . $i . 'H2', $spantagH2Content, $content);
                        $i++;
                    }
                }

                if ($spanH3TagsCount > 0) {
                    $i = 0;
                    foreach ($spantagsH3[0] as $spantagH3Content) {
                        $content = str_replace('#' . $i . 'H3', $spantagH3Content, $content);
                        $i++;
                    }
                }

                if ($spanATagsCount > 0) {
                    $i = 0;
                    foreach ($spantagsA[0] as $spantagAContent) {
                        $content = str_replace('#' . $i . 'a', $spantagAContent, $content);
                        $i++;
                    }
                }
                if ($scriptTagsCount > 0) {
                    $i = 0;
                    foreach ($scripttags[0] as $scriptContent) {
                        $content = str_replace('#' . $i . 'script', $scriptContent, $content);
                        $i++;
                    }
                }
            }
        }
    }
    return $content;
}

//Make sure parser runs before the post or page content is outputted
add_filter('the_content', 'red_glossary_parse');

function red_glossaryShowList($content = '') {
    $glossary_index = get_children(array(
            'post_type' => 'glossary',
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
                ));
        if ($glossary_index) {
            
            $content.='<div id="glossaryList-nav" class="listNav"></div>';
            $content .= '<ul id="glossaryList">';
            //style links based on option
            if (get_option('red_glossaryDiffLinkClass') == 1) {
                $glossary_style = 'glossaryLinkMain';
            } else {
                $glossary_style = 'glossaryLink';
            }
            foreach ($glossary_index as $glossary_item) {
                //show tooltip based on user option
                if (get_option('red_glossaryTooltip') == 1) {

                    if (get_option('red_glossaryExcerptHover') && $glossary_item->post_excerpt) {
                        $glossaryItemContent = $glossary_item->post_excerpt;
                    } else {
                        $glossaryItemContent = $glossary_item->post_content;
                    }

                    $glossaryItemContent = htmlspecialchars($glossaryItemContent);
                    $glossaryItemContent = addslashes($glossaryItemContent);
$glossaryItemContent = str_replace('[glossary_exclude]', "", $glossaryItemContent);
                $glossaryItemContent = str_replace('[/glossary_exclude]', "", $glossaryItemContent);

                    if (get_option('red_glossaryTermLink') == 1) {
                        $content .= '<li><span class="' . $glossary_style . '"  onmouseover="tooltip.show(\'' . $glossaryItemContent . '\');" onmouseout="tooltip.hide();">' . $glossary_item->post_title . '</span></li>';
                    } else {
                        $content .= '<li><a class="' . $glossary_style . '" href="' . get_permalink($glossary_item) . '" onmouseover="tooltip.show(\'' . $glossaryItemContent . '\');" onmouseout="tooltip.hide();">' . $glossary_item->post_title . '</a></li>';
                    }
                } else {
                    if (get_option('red_glossaryTermLink') == 1) {
                        $content .= '<li><span class="' . $glossary_style . '"  >' . $glossary_item->post_title . '</span></li>';
                    } else {
                        $content .= '<li><a class="' . $glossary_style . '" href="' . get_permalink($glossary_item) . '">' . $glossary_item->post_title . '</a></li>';
                    }
                }
            }
            $content .= '</ul>';
            $content.='<script>jQuery(document).ready(function($){ $("#glossaryList").listnav();});</script>';
            if (get_option('red_glossaryListTiles') == 1)
                $content='<div class="tiles">'.$content.'</div>';
        }
        return $content;
}
//create the actual glossary
function red_glossary_createList($content) {
    $glossaryPageID = get_option('red_glossaryID');
    if (is_numeric($glossaryPageID) && is_page($glossaryPageID)) {
        $content = red_glossaryShowList($content);
    }
    return $content;
}
function red_glossary_createList_scripts() {
    $glossaryPageID = get_option('red_glossaryID');
    if (is_numeric($glossaryPageID) && is_page($glossaryPageID)) {
        $glossary_path = WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
        wp_register_script('jquery-listnav',$glossary_path.'/jquery.listnav.min-2.1.js', array('jquery') );
        wp_enqueue_script('jquery-listnav');
        wp_register_style('jquery-listnav-style', $glossary_path.'/jquery.listnav.css');
        wp_enqueue_style('jquery-listnav-style');
    }
}
add_filter('the_content', 'red_glossary_createList');
add_action('wp_enqueue_scripts', 'red_glossary_createList_scripts');


function glossary_options() {
    if (isset($_POST["red_glossarySave"])) {
        //update the page options
        update_option('red_glossaryID', $_POST["red_glossaryID"]);
        update_option('red_glossaryID', $_POST["red_glossaryPermalink"]);
        $options_names = array('red_glossaryOnlySingle', 'red_glossaryOnPages', 'red_glossaryTooltip', 'red_glossaryDiffLinkClass', 'red_glossaryListTiles', 'red_glossaryFirstOnly', 'red_glossaryLimitTooltip', 'red_glossaryFilterTooltip', 'red_glossaryTermLink', 'red_glossaryExcerptHover', 'red_glossaryProtectedTags');
        foreach ($options_names as $option_name) {
            if ($_POST[$option_name] == 1) {
                update_option($option_name, 1);
            } else {
                update_option($option_name, 0);
            }
        }
    }
    ob_start();
    require('admin_settings.php');
    $content = ob_get_contents();
    ob_end_clean();
    require('admin_template.php');
}

function strip_only($str, $tags, $stripContent = false) {
    $content = '';
    if (!is_array($tags)) {
        $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
        if (end($tags) == '')
            array_pop($tags);
    }
    foreach ($tags as $tag) {
        if ($stripContent)
            $content = '(.+</' . $tag . '[^>]*>|)';
        $str = preg_replace('#</?' . $tag . '[^>]*>' . $content . '#is', '', $str);
    }
    return $str;
}
?>
