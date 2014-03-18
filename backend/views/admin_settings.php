<?php if( !empty($messages) ): ?>
    <div class="updated" style="clear:both"><p><?php echo $messages; ?></p></div>
<?php endif; ?>

<br/>
<form method="post">
    <?php wp_nonce_field('update-options'); ?>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="cmtt_glossaryDoubleclickEnabled, cmtt_glossaryDoubleclickService, cmtt_index_includeAll, cmtt_glossaryID,cmtt_glossaryOnlySingle,cmtt_glossary_showRelatedTermsTitle,cmtt_glossaryOnPages,cmtt_glossaryTooltip,cmtt_glossaryDiffLinkClass,cmtt_glossaryTooltipDesc,cmtt_glossaryTooltipDescExcerpt,cmtt_glossaryRunApiCalls,cmtt_glossaryListTiles,cmtt_glossaryPermalink,cmtt_glossaryFirstOnly,cmtt_glossaryOnlySpaceSeparated,cmtt_glossaryLimitTooltip,cmtt_glossaryTermDetailsLink,cmtt_glossaryFilterTooltip,cmtt_glossaryFilterTooltipA,cmtt_glossaryTermLink,cmtt_glossaryListTermLink,cmtt_glossary_SearchLabel,cmtt_glossary_showSearch,cmtt_glossaryExcerptHover,cmtt_glossaryProtectedTags,cmtt_glossaryCaseSensitive,cmtt_tooltipFeaturedImageSize,cmtt_glossaryInNewPage,cmtt_showTitleAttribute,cmtt_perPage,cmtt_tooltipFontStyle,cmtt_showRelatedTermsList,cmtt_tooltipIsClickable,cmtt_tooltipBackground,cmtt_tooltipForeground,cmtt_tooltipPadding,cmtt_tooltipFontSize,cmtt_tooltipPositionTop,cmtt_tooltipPositionLeft,cmtt_tooltipOpacity,cmtt_tooltipBorderStyle,cmtt_tooltipBorderWidth,cmtt_tooltipBorderWidth,cmtt_tooltipBorderColor,cmtt_tooltipBorderRadius,cmtt_tooltipLinkUnderlineStyle,cmtt_tooltipLinkUnderlineWidth,cmtt_tooltipLinkUnderlineColor,cmtt_tooltipLinkColor,cmtt_tooltipLinkHoverUnderlineStyle,cmtt_tooltipLinkHoverUnderlineWidth,cmtt_tooltipLinkHoverUnderlineColor,cmtt_tooltipLinkHoverColor,cmtt_glossaryServerSidePagination,cmtt_glossary_addBackLink,cmtt_glossary_showRelatedArticles,cmtt_glossary_showRelatedArticlesCount,cmtt_glossary_showRelatedArticlesTitle,cmtt_glossary_showRelatedArticlesPostTypesArr,cmtt_glossary_addSynonyms,cmtt_glossary_addSynonymsTitle,cmtt_glossary_addSynonymsTooltip,cmtt_glossary_relatedArticlesPrefix,cmtt_glossary_addBackLinkBottom,cmtt_glossary_backLinkText,cmtt_glossary_backLinkBottomText,cmtt_glossaryUseTemplate,cmtt_glossary_showRelatedArticlesMerged,cmtt_glossary_showRelatedArticlesGlossaryCount,cmtt_glossary_showRelatedArticlesGlossaryTitle,cmtt_tooltip3RD_AmazonEnabled, cmtt_tooltip3RD_AmazonApiKey, cmtt_tooltip3RD_AmazonCategories" />
    <br/><br/>
    <p>
        <strong>Supported Shortcodes:</strong> <a href="javascript:void(0)" onclick="jQuery(this).parent().next().slideToggle()">Show/Hide</a>
    </p>

    <ul style="display:none;list-style-type:disc;margin-left:20px;">
        <li><strong>Exclude from parsing</strong> - [glossary_exclude] text [/glossary_exclude]</li>
        <li><del><strong>Show glossary category index</strong> - [glossary cat="cat name"]</del> - Only in <a href="http://tooltip.cminds.com"  target="_blank">Pro+</a></li>
        <li><del><strong>Show Merriam-Webster Dictionary</strong> - [glossary_dictionary term="term name"]</del>- Only in <a href="http://tooltip.cminds.com" target="_blank">Pro+</a></li>
        <li><del><strong>Show Merriam-Webster Thesaurus</strong> - [glossary_thesaurus term="term name"]</del>- Only in <a href="http://tooltip.cminds.com"  target="_blank">Pro+</a></li>
        <li><del><strong>Translate</strong> - [glossary_translate term="text-to-translate" source="english" target="spanish"]</del>- Only in <a href="http://tooltip.cminds.com"  target="_blank">Pro+</a></li>
        <li><del><strong>Custom glossary tooltip</strong> - [glossary_tooltip content="text"] term [/glossary_tooltip]</del> - Only in <a href="http://tooltip.cminds.com"  target="_blank">Pro+</a></li>
        <li><del><strong>Apply tooltip</strong> - [cm_tooltip_parse] text [/cm_tooltip_parse] </del>- Only in <a href="http://tooltip.cminds.com"  target="_blank">Pro+</a></li>
        <li><del><strong>Wikipedia</strong> - [glossary_wikipedia term="term name"]</del> - Only in <a href="http://tooltip.cminds.com"  target="_blank">Ecommerce version</a></li>
    </ul>
    <p>
        <strong>Upgrade Options:</strong> <a href="javascript:void(0)" onclick="jQuery(this).parent().next().slideToggle()">Show/Hide</a>
    </p>

    <ul style="display:none;list-style-type:disc;margin-left:20px;">
        <li><strong><a href="http://tooltip.cminds.com/pricing/" target="_blank">Pro Version</a></strong></li>
        <li><strong><a href="http://tooltip.cminds.com/pricing/" target="_blank">Pro+ Version</a></strong></li>
        <li><strong><a href="http://tooltip.cminds.com/pricing/" target="_blank">Ecommerce Version</a></strong></li>
        <li>Coming Soon - Glossary Server (share your glossary items)</li>
    </ul>
    <p>
        <strong>Link to the Glossary index page:</strong> <a href="<?php echo home_url('/' . get_option('cmtt_glossaryPermalink') . '/'); ?>" target="_blank"><?php echo home_url('/' . get_option('cmtt_glossaryPermalink') . '/'); ?></a>
    </p>
    <?php
// check permalink settings
    if( get_option('permalink_structure') == '' )
    {
        echo '<span style="color:red">Your WordPress Permalinks needs to be set to allow plugin to work correctly. Please Go to <a href="' . admin_url() . 'options-permalink.php" target="new">Settings->Permalinks</a> to set Permalinks to Post Name.</span><br><br>';
    }
    ?>

    <div id="tabs" class="glossarySettingsTabs">
        <div class="glossary_loading"></div>

        <?php
        CMTooltipGlossaryBackend::renderSettingsTabsControls();

        CMTooltipGlossaryBackend::renderSettingsTabs();
        ?>

        <div  id="tabs-1">
            <div class="block">
                <h3>General Settings</h3>
                <table class="floated-form-table form-table">
                    <tr style="background-color: #CCFFCC">
                        <th scope="row"><strong>Pro Version</strong></th>
                        <td><p><strong><a href="http://tooltip.cminds.com/" target="_blank">Upgrade</a></p></td>
                        <td colspan="2" class="cmtt_field_help_container"> Professional version of CM Super Glossary Pro which which adds SEO support, Import/Export tools, Multisite support, Sidebar Widget, Synonyms, Support for huge glossaries, tooltip customization options and much more</td>
                    </tr>
                    <tr valign="top" class="whole-line">
                        <th scope="row">Glossary Index Page ID</th>
                        <td>
                            <?php wp_dropdown_pages(array('name' => 'cmtt_glossaryID', 'selected' => (int) get_option('cmtt_glossaryID', -1), 'show_option_none' => '-None-', 'option_none_value' => '0')) ?>
                            <br/><input type="checkbox" name="cmtt_glossaryID" value="-1" /> Generate page for Glossary Index
                        </td>
                        <td colspan="2" class="cmtt_field_help_container">Select the page ID of the page you would like to use as the Glossary Index Page. If you select "-None-" terms will still be highlighted in relevant posts/pages but there won't be a central list of terms (Glossary Index Page). If you check the checkbox a new page would be generated automatically. WARNING! You have to manually remove old pages!</td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Glossary Index Page Permalink</th>
                        <td><input type="text" name="cmtt_glossaryPermalink" value="<?php echo get_option('cmtt_glossaryPermalink'); ?>" /></td>
                        <td colspan="2" class="cmtt_field_help_container">Enter the name you would like to use for the permalink to the Glossary Index Page and glossary terms.  By default this is glossary, however you can update this if you wish. If you are using a parent please indicate this in path eg. /path/glossary, otherwise just leave glossary or the name you have chosen. WARNING! If you already use this permalink the plugins behavior may be unpredictable.</td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Only show terms on single posts/pages (not Homepage, authors etc.)?</th>
                        <td>
                            <input type="hidden" name="cmtt_glossaryOnlySingle" value="0" />
                            <input type="checkbox" name="cmtt_glossaryOnlySingle" <?php checked(true, get_option('cmtt_glossaryOnlySingle')); ?> value="1" />
                        </td>
                        <td colspan="2" class="cmtt_field_help_container">Select this option if you wish to only highlight glossary terms when viewing a single page/post.
                            This can be used so terms aren't highlighted on your homepage, or author pages and other taxonomy related pages.</td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Highlight terms on posts?</th>
                        <td>
                            <input type="hidden" name="cmtt_glossaryOnPosts" value="0" />
                            <input type="checkbox" name="cmtt_glossaryOnPosts" <?php checked(true, get_option('cmtt_glossaryOnPosts')); ?> value="1" />
                        </td>
                        <td colspan="2" class="cmtt_field_help_container">Select this option if you wish for the glossary to highlight terms on posts.
                            With this deselected, posts won't be searched for matching glossary terms.</td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Highlight terms on pages?</th>
                        <td>
                            <input type="hidden" name="cmtt_glossaryOnPages" value="0" />
                            <input type="checkbox" name="cmtt_glossaryOnPages" <?php checked(true, get_option('cmtt_glossaryOnPages')); ?> value="1" />
                        </td>
                        <td colspan="2" class="cmtt_field_help_container">Select this option if you wish for the glossary to highlight terms on pages.
                            With this deselected, pages won't be searched for matching glossary terms.</td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Highlight first term occurance only?</th>
                        <td>
                            <input type="hidden" name="cmtt_glossaryFirstOnly" value="0" />
                            <input type="checkbox" name="cmtt_glossaryFirstOnly" <?php checked(true, get_option('cmtt_glossaryFirstOnly')); ?> value="1" />
                        </td>
                        <td colspan="2" class="cmtt_field_help_container">Select this option if you want to only highlight the first occurance of each term on a page/post.</td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Terms case-sensitive?</th>
                        <td>
                            <input type="hidden" name="cmtt_glossaryCaseSensitive" value="0" />
                            <input type="checkbox" name="cmtt_glossaryCaseSensitive" <?php checked(true, get_option('cmtt_glossaryCaseSensitive')); ?> value="1" />
                        </td>
                        <td colspan="2" class="cmtt_field_help_container">Select this option if you want glossary terms to be case-sensitive.</td>
                    </tr>
                </table>
                <div class="clear"></div>
            </div>
            <div class="block">
                <h3>Referrals</h3>
                <p>Refer new users to any of the CM Plugins and you'll receive 10% of their purchase!. For more information please visit CM Plugins <a href="http://www.cminds.com/referral-program/" target="new">Affiliate page</a></p>
                <table>
                    <tr valign="top">
                        <th scope="row" valign="middle" align="left" >Enable referrals:</th>
                        <td>
                            <input type="hidden" name="cmtt_glossaryReferral" value="0" />
                            <input type="checkbox" name="cmtt_glossaryReferral" <?php checked(1, get_option('cmtt_glossaryReferral')); ?> value="1" />
                        </td>
                        <td colspan="2" class="cmtt_field_help_container">Enable referrals link at the bottom of the question and the answer page<br><br></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" valign="middle" align="left" ><?php _e('Affiliate Code', 'cm-tooltip-ecommerce'); ?>:</th>
                        <td><input type="text" name="cmtt_glossaryAffiliateCode" value="<?php echo get_option('cmtt_glossaryAffiliateCode'); ?>" placeholder="<?php _e('Affiliate Code', 'cm-tooltip-ecommerce'); ?>"/></td>
                        <td colspan="2" class="cmtt_field_help_container"><?php _e('Please add your affiliate code in here.', 'cm-tooltip-ecommerce'); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="tabs-2">
            <div class="block">
                <h3>Glossary Index Page Settings</h3>
                <table class="floated-form-table form-table">
                    <tr valign="top">
                        <th scope="row">Style glossary index page differently?</th>
                        <td>
                            <input type="hidden" name="cmtt_glossaryDiffLinkClass" value="0" />
                            <input type="checkbox" name="cmtt_glossaryDiffLinkClass" <?php checked(true, get_option('cmtt_glossaryDiffLinkClass')); ?> value="1" />
                        </td>
                        <td colspan="2" class="cmtt_field_help_container">Select this option if you wish for the links in the glossary index page to be styled differently than the regular way glossary terms links are styled.  By selecting this option you will be able to use the class 'glossaryLinkMain' to style only the links on the glossary index page otherwise they will retain the class 'glossaryLink' and will be identical to the linked terms on all other pages.</td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Show glossary index page as tiles</th>
                        <td>
                            <input type="hidden" name="cmtt_glossaryListTiles" value="0" />
                            <input type="checkbox" name="cmtt_glossaryListTiles" <?php checked(true, get_option('cmtt_glossaryListTiles')); ?> value="1" />
                        </td>
                        <td colspan="2" class="cmtt_field_help_container">Select this option if you wish the glossary index page to be displayed as tiles. This is not recommended when you have long terms.</td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="tabs-3">
            <div class="block">
                <h3>Glossary Term - Links</h3>
                <table class="floated-form-table form-table">
                    <tr valign="top">
                        <th scope="row">Remove link to the glossary term page?</th>
                        <td>
                            <input type="hidden" name="cmtt_glossaryTermLink" value="0" />
                            <input type="checkbox" name="cmtt_glossaryTermLink" <?php checked(true, get_option('cmtt_glossaryTermLink')); ?> value="1" />
                        </td>
                        <td colspan="2" class="cmtt_field_help_container">Select this option if you do not want to show links from posts or pages to the glossary term pages. This will only apply to Post / Pages and not to the glossary index page, for glossary index page please visit index page tab in settings. Keep in mind that the plugin use a <strong>&lt;span&gt;</strong> tag instead of a link tag and if you are using a custom CSS you should take this into account</td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Open glossary term page in a new windows/tab?</th>
                        <td>
                            <input type="hidden" name="cmtt_glossaryInNewPage" value="0" />
                            <input type="checkbox" name="cmtt_glossaryInNewPage" <?php checked(true, get_option('cmtt_glossaryInNewPage')); ?> value="1" />
                        </td>
                        <td colspan="2" class="cmtt_field_help_container">Select this option if you want glossary term page to open in a new window/tab.</td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Show HTML "title" attribute for glossary links</th>
                        <td>
                            <input type="hidden" name="cmtt_showTitleAttribute" value="0" />
                            <input type="checkbox" name="cmtt_showTitleAttribute" <?php checked(true, get_option('cmtt_showTitleAttribute')); ?> value="1" />
                        </td>
                        <td colspan="2" class="cmtt_field_help_container">Select this option if you want to use glossary name as HTML "title" for link</td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="tabs-4">
            <div class="block">
                <h3>Tooltip - Content</h3>
                <table class="floated-form-table form-table">
                    <tr valign="top">
                        <th scope="row">Show tooltip when the user hovers over the term?</th>
                        <td>
                            <input type="hidden" name="cmtt_glossaryTooltip" value="0" />
                            <input type="checkbox" name="cmtt_glossaryTooltip" <?php checked(true, get_option('cmtt_glossaryTooltip')); ?> value="1" /></td>
                        <td colspan="2" class="cmtt_field_help_container">Select this option if you wish for the definition to show in a tooltip when the user hovers over the term.  The tooltip can be styled differently using the tooltip.css and tooltip.js files in the plugin folder.</td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Limit tooltip length?</th>
                        <td>
                            <input type="hidden" name="cmtt_glossaryLimitTooltip" value="0" />
                            <input type="text" name="cmtt_glossaryLimitTooltip" value="<?php echo get_option('cmtt_glossaryLimitTooltip'); ?>"  />
                        </td>
                        <td colspan="2" class="cmtt_field_help_container">Select this option if you want to show only a limited number of chars and add "(...)<?php echo get_option('cmtt_glossaryTermDetailsLink'); ?>" at the end of the tooltip text. Minimum is 30 chars.</td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Clean tooltip text?</th>
                        <td>
                            <input type="hidden" name="cmtt_glossaryFilterTooltip" value="0" />
                            <input type="checkbox" name="cmtt_glossaryFilterTooltip" <?php checked(true, get_option('cmtt_glossaryFilterTooltip')); ?> value="1" />
                        </td>
                        <td colspan="2" class="cmtt_field_help_container">Select this option if you want to remove extra spaces and special characters from tooltip text.</td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Use term excerpt for hover?</th>
                        <td>
                            <input type="hidden" name="cmtt_glossaryExcerptHover" value="0" />
                            <input type="checkbox" name="cmtt_glossaryExcerptHover" <?php checked(true, get_option('cmtt_glossaryExcerptHover')); ?> value="1" />
                        </td>
                        <td colspan="2" class="cmtt_field_help_container">Select this option if you want to use the term excerpt (if it exists) as hover text.
                            <br/>NOTE: You have to manually create the excerpts for term pages using the "Excerpt" field.
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Avoid parsing protected tags?</th>
                        <td>
                            <input type="hidden" name="cmtt_glossaryProtectedTags" value="0" />
                            <input type="checkbox" name="cmtt_glossaryProtectedTags" <?php checked(true, get_option('cmtt_glossaryProtectedTags')); ?> value="1" />
                        </td>
                        <td colspan="2" class="cmtt_field_help_container">Select this option if you want to avoid using the glossary for the following tags: Script, A, H1, H2, H3, PRE, Object.</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- Start Server information Module -->
        <div id="tabs-99">
            <div class='block'>
                <h3>Server Information</h3>
                <?php
                $safe_mode = ini_get('safe_mode') ? ini_get('safe_mode') : 'Off';
                $upload_max = ini_get('upload_max_filesize') ? ini_get('upload_max_filesize') : 'N/A';
                $post_max = ini_get('post_max_size') ? ini_get('post_max_size') : 'N/A';
                $memory_limit = ini_get('memory_limit') ? ini_get('memory_limit') : 'N/A';
                $cURL = function_exists('curl_version') ? 'On' : 'Off';
                $mb_support = function_exists('mb_strtolower') ? 'On' : 'Off';

                $php_info = cminds_parse_php_info();
                ?>
                <span class="description" style="">
                    Cm Tooltip is a mix of  JavaScript application and a parsing engine.
                    This information is useful to check if CM Tooltip might have some incompabilities with you server
                </span>
                <table class="form-table server-info-table">
                    <tr>
                        <td>PHP Version</td>
                        <td><?php echo phpversion(); ?></td>
                        <td><?php if( version_compare(phpversion(), '5.3.0', '<') ): ?><strong>Recommended 5.3 or higher</strong><?php else: ?><span>OK</span><?php endif; ?></td>
                    </tr>
                    <tr>
                        <td>mbstring support</td>
                        <td><?php echo $mb_support; ?></td>
                        <td><?php if( $mb_support == 'Off' ): ?>
                                <strong>"mbstring" library is required for plugin to work.</strong>
                            <?php else: ?><span>OK</span><?php endif; ?></td>
                    </tr>
                    <tr>
                        <td>PHP Memory Limit</td>
                        <td><?php echo $memory_limit; ?></td>
                        <td><?php if( cminds_units2bytes($memory_limit) < 1024 * 1024 * 128 ): ?>
                                <strong>This value can be too low for a site with big glossary.</strong>
                            <?php else: ?><span>OK</span><?php endif; ?></td>
                    </tr>
                    <tr>
                        <td>PHP Max Upload Size (Pro, Pro+, Ecommerce)</td>
                        <td><?php echo $upload_max; ?></td>
                        <td><?php if( cminds_units2bytes($upload_max) < 1024 * 1024 * 5 ): ?>
                                <strong>This value can be too low to import large files.</strong>
                            <?php else: ?><span>OK</span><?php endif; ?></td>
                    </tr>
                    <tr>
                        <td>PHP Max Post Size (Pro, Pro+, Ecommerce)</td>
                        <td><?php echo $post_max; ?></td>
                        <td><?php if( cminds_units2bytes($post_max) < 1024 * 1024 * 5 ): ?>
                                <strong>This value can be too low to import large files.</strong>
                            <?php else: ?><span>OK</span><?php endif; ?></td>
                    </tr>
                    <tr>
                        <td>PHP cURL (Ecommerce only)</td>
                        <td><?php echo $cURL; ?></td>
                        <td><?php if( $cURL == 'Off' ): ?>
                                <strong>cURL library is required to check if remote audio file exists.</strong>
                            <?php else: ?><span>OK</span><?php endif; ?></td>
                    </tr>

                    <?php
                    if( isset($php_info['gd']) && is_array($php_info['gd']) )
                    {
                        foreach($php_info['gd'] as $key => $val)
                        {
                            if( !preg_match('/(WBMP|XBM|Freetype|T1Lib)/i', $key) && $key != 'Directive' && $key != 'gd.jpeg_ignore_warning' )
                            {
                                echo '<tr>';
                                echo '<td>' . $key . '</td>';
                                if( stripos($key, 'support') === false )
                                {
                                    echo '<td>' . $val . '</td>';
                                }
                                else
                                {
                                    echo '<td>enabled</td>';
                                }
                                echo '</tr>';
                            }
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <p class="submit" style="clear:left">
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" name="cmtt_glossarySave" />
    </p>
</form>