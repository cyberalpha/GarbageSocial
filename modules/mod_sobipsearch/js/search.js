/* ------------------------------------------------------------------------
  # mod_sobipsearch - Search in Selected Section
  # ------------------------------------------------------------------------
  # author    Prieco S.A.
  # copyright Copyright (C) 2011 Prieco.com. All Rights Reserved.
  # @license - http://http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  # Websites: http://www.prieco.com
  # Technical Support:  Forum - http://www.prieco.com/en/contact.html
  ------------------------------------------------------------------------- 

Based on:
http://demo.sobi.pro/components/com_sobipro/usr/templates/sobirestara/js/search.js

 * @package: SobiPro Template SobiRestara
 * ===================================================
 * @author
 * Name: Sigrid Suski & Radek Suski, Sigsiu.NET GmbH
 * Email: sobi[at]sigsiu.net
 * Url: http://www.Sigsiu.NET
 * ===================================================
 * @copyright Copyright (C) 2006 - 2011 Sigsiu.NET GmbH (http://www.sigsiu.net). All rights reserved.
 * @license Sigsiu.NET Template License V1.
 * ===================================================

 */

/*jslint plusplus: true, browser: true, sloppy: true */
/*global jQuery, SobiProUrl*/

var ExtSearchHelper3 = function (sectionid, searchsearchwordid) {
        this.sectionid = sectionid;
        this.searchsearchwordid = searchsearchwordid;
        this.searchsearchword = jQuery(searchsearchwordid);

        this.cache = {};
        this.lastXhr = null;
    };

ExtSearchHelper3.prototype.bind = function (jqueryui) {
    var that = this;
    if (typeof that.searchsearchword.autocomplete === 'function') {
        that.searchsearchword.autocomplete({
            minLength: 3,
            source: function (request, response) {
                that.queryAutocomplete(request, response);
            }
        });
    } else {
        jQuery.getScript(jqueryui, function () {
            /* SAME CODE, BUT FORCED jquery-ui.js */
            that.searchsearchword.autocomplete({
                minLength: 3,
                source: function (request, response) {
                    that.queryAutocomplete(request, response);
                }
            });
        });
        /* SAME CODE, BUT FORCED jquery-ui.js */
    }
};

ExtSearchHelper3.prototype.queryAutocomplete = function (request, response) {
    var that = this,
        term = request.term;
    if (this.cache.hasOwnProperty(term)) {
        response(this.cache.term);
        return;
    }
    this.lastXhr = jQuery.ajax({
        url: SobiProUrl.replace('%task%', 'search.suggest'),
        data: {
            term: request.term,
            sid: this.sectionid,
            tmpl: 'component',
            format: 'raw'
        },
        success: function (data) {
            that.cache.term = data;
            response(data);
        }
    });
};

