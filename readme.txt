=== Plugin Name ===
Name: Enhanced Tooltip Glossary
Contributors: CreativeMinds. Based on jatls TooltipGlossary
Donate link: http://www.cminds.com/plugins
Tags: glossary, pages, posts, definitions, tooltip, automatic, hints, hint, tip
Requires at least: 3.2
Tested up to: 3.4.2
Stable tag: 1.2

Parses posts for defined glossary terms and adds links to the static glossary page containing the definition and a tooltip with the definition.

== Description ==

Parses posts for defined glossary terms and adds links to the static glossary page containing the definition.  The plugin also creates a tooltip containing the definition which is displayed when users mouseover the term.  Based on [automatic-glossary](http://wordpress.org/extend/plugins/automatic-glossary/) and on [TooltipGlossary] (http://wordpress.org/extend/plugins/tooltipglossary/).

The code has been bug fixed based on TooltipGlossary and many new features added. A new tag was introduced to avoid using the Tooltip [glossary_exclude] text [/glossary_exclude].  

The tooltip is created with JavaScript based on the article written by [Michael Leigeber](http://www.leigeber.com/author/michael/) [here](http://sixrevisions.com/tutorials/javascript_tutorial/create_lightweight_javascript_tooltip/) and can be customized and styled through the tooltip.css and tooltip.js files.

Alphabetical index for glossary list is based on [jQuery ListNav Plugin](http://www.ihwy.com/labs/jquery-listnav-plugin.aspx)

**More About this Plug**
	
You can find more information about CM Invitation Codes plug in [CreativeMinds Website](http://www.cminds.com/plugins/).


**More Plugin by CreativeMinds**

Current list of available plugin by CreativeMinds

* [Enhanced ToolTip Glossary](http://wordpress.org/extend/plugins/enhanced-tooltipglossary/) - Parses posts for defined glossary terms and adds links to the static glossary page containing the definition and a tooltip with the definition. 

* [Multi MailChimp List Manager](http://wordpress.org/extend/plugins/multi-mailchimp-list-manager/) - Allows users to subscribe/unsubscribe from multiple MailChimp lists. 

* [CM Invitation Codes](http://wordpress.org/extend/plugins/cm-invitation-codes/) - Allows more control over site registration by adding managed groups of invitation codes. 


== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Define your glossary terms under the glossary menu item in the administration interface.  The title of the page should be the term.  The body content should be the definition.
4. Create a main glossary page (example "Glossary") with no body content if you wish to.  If you do not create this page then your terms will still be highlighted but there will not be a central listing of all your terms.
5. In the plugin's dashboard preferences, enter the main glossary page's id (optional as above)
6. There are a handful of other optional preferences available in the dashboard.

Note: You must have a call to wp_head() in your template in order for the tooltip js and css to work properly.  If your theme does not support this you will need to link to these files manually in your theme (not recommended).

== Frequently Asked Questions ==

= Does my main glossary page need to be titled "Glossary"? =

No.  It can be called anything.  In fact you don't even need to have a main glossary page.

= Do I need to manually type in an unordered list of my glossary terms on the glossary page? =

No.  Just leave that page blank.  The plugin creates the unordered list of terms automatically.

= How do I add glossary terms? =

Simply add a term under the 'Glossary' section in the adminstration interface.  Title it the glossary term (ex. "WordPress") and put the term's definition into the body (ex. "A neato Blogging Platform").

= What if I need to add or change a glossary term? =

Just add it or change it.  The links for your glossary terms are added to your page and post content on the fly so your glossary links will always be up to date.

= How do I prevent the glossary from parsing a paragraph =

Just wrap the paragraph with [glossary_exclude] paragraph text [/glossary_exclude].  

= How do I define the Glossary link style =

You can use glossaryLink. You can also define glossaryLinkMain if you wish to have a different style in the main glossary page

== Screenshots ==

1. The options available for EnhancedTooltipGlossary in the administration area.

== Changelog ==

= 1.2 =
* Added alphabetical letter index for glossary list
* Added option to style glossary list as tiles instead of regular list
* Do not show glossary explanation tooltip when on its explanation page
* Do not show [glossary_exclude] tag in tooltips
* Fix bug when excluded tags were embedded into other excluded tags
* Fix bug when glossary terms were substrings of other glossary terms and only the shortest was caught (Thanks to Torsten Keil)
* Fix bug when HTML code in tooltip content causes page to break
* Thanks for Paul Ryan (prar@hawaii.edu) for his code contribution and Sebastian Palus for his addition and bug fixes

= 1.1 =
* Add A tag to the list of tags to ignore (Thanks to Robert Gilman)
* Change activation mechanisim  (Thanks to Robert Gilman)
* Fix bug when using excerpt (Thanks to Robert Gilman)

= 1.0 =
* First release nased on revised version on TooltipGlossary
* Optimized code and bug fix from TooltipGlossary
* Added [glossary_exclude] text [/glossary_exclude]
* Added filters to clean tooltip text
* Avoid changing URL using this format: href='url' in adition to href=""
* Add extended functionality including excluding H1, H2, H3, Script, Object tags
* Use the excerpt (if it exists) as hover text.
* Remove term link to the glossary page
* Limit tooltip length
