<?php
if( !defined('ABSPATH') )
{
    exit;
}

class CMTooltipGlossaryShared
{
    protected static $instance = NULL;
    public static $calledClassName;

    public static function instance()
    {
        $class = __CLASS__;
        if( !isset(self::$instance) && !( self::$instance instanceof $class ) )
        {
            self::$instance = new $class;
        }
        return self::$instance;
    }

    public function __construct()
    {
        if( empty(self::$calledClassName) )
        {
            self::$calledClassName = __CLASS__;
        }

        self::setupConstants();
        self::setupOptions();
        self::loadClasses();
        self::registerActions();

        if( get_option('cmtt_afterActivation', 0) == 1 )
        {
            add_action('admin_notices', array(self::$calledClassName, '__showProMessage'));
        }
    }

    /**
     * Shows the message about Pro versions on activate
     */
    public static function __showProMessage()
    {
        /*
         * Only show to admins
         */
        if( current_user_can('manage_options') )
        {
            ?>
            <div id="message" class="updated fade">
                <p><strong>New !! Pro versions of Tooltip Glossary are <a href="http://tooltip.cminds.com/"  target="_blank">available here</a></strong></p>
            </div>
            <?php
            delete_option('cmtt_afterActivation');
        }
    }

    /**
     * Register the plugin's shared actions (both backend and frontend)
     */
    private static function registerActions()
    {
        add_action('init', array(self::$calledClassName, 'cmtt_create_post_types'));
        add_action('init', array(self::$calledClassName, 'cmtt_create_taxonomies'));

        $updateMessageHook = "in_plugin_update_message-" . CMTT_PLUGIN;
        add_action($updateMessageHook, array(self::$calledClassName, 'cmtt_warn_on_upgrade'));
    }

    /**
     * Setup plugin constants
     *
     * @access private
     * @since 1.1
     * @return void
     */
    private static function setupConstants()
    {
        define('CMTT_MENU_OPTION', 'cmtt_menu_option');
        define('CMTT_ABOUT_OPTION', 'cmtt_about');
        define('CMTT_PRO_OPTION', 'cmtt_pro');
        define('CMTT_SETTINGS_OPTION', 'cmtt_settings');
        define('CMTT_IMPORTEXPORT_OPTION', 'cmtt_importexport');
    }

    /**
     * Setup plugin constants
     *
     * @access private
     * @since 1.1
     * @return void
     */
    private static function setupOptions()
    {
        /*
         * General settings
         */
        add_option('cmtt_glossaryOnPages', 1); //Show on Pages?
        add_option('cmtt_glossaryOnPosts', 1); //Show on Posts?
        add_option('cmtt_glossaryID', 0); //The ID of the main Glossary Page
        add_option('cmtt_glossaryPermalink', 'glossary'); //Set permalink name
        add_option('cmtt_glossaryOnlySingle', 0); //Show on Home and Category Pages or just single post pages?
        add_option('cmtt_glossaryFirstOnly', 0); //Search for all occurances in a post or only one?
        add_option('cmtt_glossaryOnlySpaceSeparated', 1); //Search only for words separated by spaces
        add_option('cmtt_script_in_footer', 0); //Place the scripts in the footer not the header

        /*
         * Glossary page styling
         */
        add_option('cmtt_glossaryDoubleclickEnabled', 0);
        add_option('cmtt_glossaryDoubleclickService', 0);

        /*
         * Glossary page styling
         */
        add_option('cmtt_glossaryDiffLinkClass', 0); //Use different class to style glossary list
        add_option('cmtt_glossaryListTiles', 0); // Display glossary terms list as tiles
        add_option('cmtt_glossaryListTermLink', 0); //Remove links from glossary index to glossary page
        add_option('cmtt_glossary_showSearch', 1); //Show the search button on the index glossary page
        add_option('cmtt_glossaryTagsLabel', 'Tags: '); //Label for the Tags on the index glossary page and term page
        add_option('cmtt_glossary_SearchLabel', 'Search:'); //Label for the Search button on the index glossary page
        add_option('cmtt_glossary_ClearLabel', '(clear)'); //Label for the clear link on the index glossary page
        add_option('cmtt_index_letters', array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'));
        add_option('cmtt_glossaryTooltipDesc', 0); // Display description in glossary list
        add_option('cmtt_glossaryTooltipDescExcerpt', 0); // Display excerpt in glossary list
        add_option('cmtt_glossaryServerSidePagination', 0); //paginate server side or client side (with alphabetical index)
        add_option('cmtt_perPage', 0); //pagination on "glossary page" withing alphabetical navigation
        add_option('cmtt_glossaryRunApiCalls', 0); //exclude the API calls from the glossary main page
        add_option('cmtt_index_includeNum', 1);
        add_option('cmtt_index_includeAll', 1);
        add_option('cmtt_glossary_addBackLink', 1);
        add_option('cmtt_glossary_addBackLinkBottom', 1);
        add_option('cmtt_glossary_backLinkText', '&laquo; Back to Glossary Index');
        add_option('cmtt_glossary_backLinkBottomText', '&laquo; Back to Glossary Index');
        add_option('cmtt_glossaryUseTemplate', 0); //Use the attached single term template?
        /*
         * Related articles
         */
        add_option('cmtt_glossary_showRelatedArticles', 1);
        add_option('cmtt_glossary_showRelatedArticlesCount', 5);
        add_option('cmtt_glossary_showRelatedArticlesGlossaryCount', 5);
        add_option('cmtt_glossary_showRelatedArticlesMerged', 0);
        add_option('cmtt_glossary_showRelatedArticlesTitle', 'Related Articles:');
        add_option('cmtt_glossary_showRelatedArticlesGlossaryTitle', 'Related Glossary Terms:');
        add_option('cmtt_glossary_showRelatedArticlesPostTypesArr', array('post', 'page', 'glossary'));
        add_option('cmtt_glossary_relatedArticlesPrefix', 'Glossary: ');
        /*
         * Related terms
         */
        add_option('cmtt_showRelatedTermsList', 1); //show the list of related terms under post/page
        add_option('cmtt_glossary_showRelatedTermsTitle', 'Related Terms:'); //title of the "Related Terms" box
        add_option('cmtt_glossary_relatedTermsPrefix', 'Term: '); //prefix of the "Related Terms" item
        /*
         * Synonyms
         */
        add_option('cmtt_glossary_addSynonyms', 1);
        add_option('cmtt_glossary_addSynonymsTitle', 'Synonyms: ');
        add_option('cmtt_glossary_addSynonymsTooltip', 0);
        /*
         * Referral
         */
        add_option('cmtt_glossaryReferral', false);
        add_option('cmtt_glossaryAffiliateCode', '');

        /*
         * Tooltip content
         */
        add_option('cmtt_glossaryTooltip', 1); //Use tooltips on glossary items?
        add_option('cmtt_glossaryTooltipStripShortcode', 0); //Strip the shortcodes from glossary page before placing the tooltip?
        add_option('cmtt_glossaryFilterTooltip', 30); //Clean the tooltip text from uneeded chars?
        add_option('cmtt_glossaryFilterTooltipA', 0); //Clean the tooltip anchor tags
        add_option('cmtt_glossaryLimitTooltip', 0); // Limit the tooltip length  ?
        add_option('cmtt_glossaryTermDetailsLink', 'Term details'); // Label of the link to term's details
        add_option('cmtt_glossaryExcerptHover', 0); //Search for all occurances in a post or only one?
        add_option('cmtt_glossaryProtectedTags', 1); //SAviod the use of Glossary in Protected tags?
        add_option('cmtt_glossaryCaseSensitive', 0); //Case sensitive?
        /*
         * Glossary link
         */
        add_option('cmtt_glossaryInNewPage', 0); //In New Page?
        add_option('cmtt_glossaryTermLink', 0); //Remove links to glossary page
        add_option('cmtt_showTitleAttribute', 1); //show HTML title attribute

        /*
         * Tooltip styling
         */
        add_option('cmtt_tooltipFontStyle', 'default');
        add_option('cmtt_tooltipIsClickable', 0);
        add_option('cmtt_tooltipLinkUnderlineStyle', 'dotted');
        add_option('cmtt_tooltipLinkUnderlineWidth', 1);
        add_option('cmtt_tooltipLinkUnderlineColor', '#000000');
        add_option('cmtt_tooltipLinkColor', '#000000');
        add_option('cmtt_tooltipLinkHoverUnderlineStyle', 'solid');
        add_option('cmtt_tooltipLinkHoverUnderlineWidth', '1');
        add_option('cmtt_tooltipLinkHoverUnderlineColor', '#333333');
        add_option('cmtt_tooltipLinkHoverColor', '#333333');
        add_option('cmtt_tooltipBackground', '#666666');
        add_option('cmtt_tooltipForeground', '#ffffff');
        add_option('cmtt_tooltipOpacity', 95);
        add_option('cmtt_tooltipBorderStyle', 'none');
        add_option('cmtt_tooltipBorderWidth', 0);
        add_option('cmtt_tooltipBorderColor', '#000000');
        add_option('cmtt_tooltipPositionTop', 3);
        add_option('cmtt_tooltipPositionLeft', 23);
        add_option('cmtt_tooltipFontSize', 13);
        add_option('cmtt_tooltipPadding', '2px 12px 3px 7px');
        add_option('cmtt_tooltipBorderRadius', 6);

        /*
         * Adding additional options
         */
        do_action('cmtt_setup_options');
    }

    /**
     * Create custom post type
     */
    public static function cmtt_create_post_types()
    {
        $glossaryPermalink = get_option('cmtt_glossaryPermalink');

        $args = array(
            'label'               => 'Glossary',
            'labels'              => array(
                'add_new_item'  => 'Add New Glossary Item',
                'add_new'       => 'Add Glossary Item',
                'edit_item'     => 'Edit Glossary Item',
                'view_item'     => 'View Glossary Item',
                'singular_name' => 'Glossary Item',
                'name'          => CMTT_NAME,
                'menu_name'     => 'Glossary'
            ),
            'description'         => '',
            'map_meta_cap'        => true,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_admin_bar'   => true,
            'show_in_menu'        => CMTT_MENU_OPTION,
            '_builtin'            => false,
            'capability_type'     => 'post',
            'hierarchical'        => false,
            'has_archive'         => false,
            'rewrite'             => array('slug' => $glossaryPermalink, 'with_front' => false, 'feeds' => true, 'feed' => true),
            'query_var'           => true,
            'supports'            => array('title', 'editor', 'author', 'comments', 'excerpt', 'revisions',
                'custom-fields', 'page-attributes', 'post-formats'));

        register_post_type('glossary', $args);
    }

    /**
     * Create taxonomies
     */
    public static function cmtt_create_taxonomies()
    {
        return;
    }

    /**
     * Load plugin's required classes
     *
     * @access private
     * @since 1.1
     * @return void
     */
    private static function loadClasses()
    {
        /*
         * Load the file with shared global functions
         */
        require_once CMTT_PLUGIN_DIR . "shared/functions.php";
    }

    public function registerShortcodes()
    {
//        add_shortcode('create_wallet_button', array(get_class(), 'getCreateWalletButton'));
//        add_shortcode('get_transaction_wallet', array(get_class(), 'getTransactionWalletID'));
//        add_shortcode('get_transaction_wallet_points', array(get_class(), 'getTransactionWalletPoints'));
//        add_shortcode('cm_micropayment_checkout', array(get_class(), 'getCheckOutTemplate'));
//        add_shortcode('cm_confirm_payment', array(get_class(), 'confirmPayment'));
//        add_shortcode('cm_check_wallet', array(get_class(), 'getWalletData'));
    }

    public function registerFilters()
    {
//        add_filter('wallet_has_enough_points', array(get_class(), 'hasWalletEnoughPoints'));
//        add_filter('withdraw_wallet_points', array(get_class(), 'withdrawWalletPoints'));
    }

    public static function initSession()
    {
        if( !session_id() )
        {
            session_start();
        }
    }

    /**
     * Function tries to generate the new Glossary Index Page
     */
    public static function tryGenerateGlossaryIndexPage()
    {
        $glossaryIndexId = get_option('cmtt_glossaryID', -1);
        if( $glossaryIndexId == -1 || get_post($glossaryIndexId) === null )
        {
            $id = wp_insert_post(array(
                'post_author' => get_current_user_id(),
                'post_status' => 'publish',
                'post_title'  => 'Glossary',
                'post_type'   => 'page'
            ));

            if( is_numeric($id) )
            {
                update_option('cmtt_glossaryID', $id);
            }
        }
    }

    /**
     * Function seaches for the options with prefix "red_" (old tooltip options were prefixed that way) and applies their values to the new options
     */
    public static function tryResetOldOptions()
    {
        $all_options = wp_load_alloptions();
        foreach($all_options as $name => $value)
        {
            if( stripos($name, 'red_') === 0 )
            {
                $realOptionName = 'cmtt_' . str_ireplace('red_', '', $name);
                $unserialisedValue = maybe_unserialize($value);
                update_option($realOptionName, $unserialisedValue);
                delete_option($name);
            }
        }
    }

}