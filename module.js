// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Init document area treeview
 *
 * @package    block_module_info
 * @copyright  2013 Queen Mary, University of London
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

M.block_module_info = {};

M.block_module_info.init = function(Y, expand_all, htmlid) {
			
	Y.use('yui2-treeview', function(Y) {

		var tree = new YAHOO.widget.TreeView(htmlid);

		tree.subscribe("clickEvent", function(node, event) {
			// we want normal clicking which redirects to url
			return false;
		});

		if (expand_all) {
        tree.expandAll();
		}

		tree.render();
	});
		
};

/**
 * Init a collapsible region, see print_collapsible_region in weblib.php
 * @param {YUI} Y YUI3 instance with all libraries loaded
 * @param {String} id the HTML id for the div.
 * @param {String} userpref the user preference that records the state of this box. false if none.
 * @param {String} strtooltip
 */
M.block_module_info.init_collapsible_region = function(Y, id, userpref, strtooltip) {
    Y.use('anim', function(Y) {
        new M.block_module_info.CollapsibleRegion(Y, id, userpref, strtooltip);
    });
};

/**
 * Object to handle a collapsible region : instantiate and forget styled object
 *
 * @class
 * @constructor
 * @param {YUI} Y YUI3 instance with all libraries loaded
 * @param {String} id The HTML id for the div.
 * @param {String} userpref The user preference that records the state of this box. false if none.
 * @param {String} strtooltip
 */
M.block_module_info.CollapsibleRegion = function(Y, id, userpref, strtooltip) {
    // Record the pref name
    this.userpref = userpref;

    // Find the divs in the document.
    this.div = Y.one('#'+id);

    // Get the caption for the collapsible region
    var caption = this.div.one('#'+id + '_caption');

    // Create a link
    var a = Y.one('#'+id+'_caption_anchor');
    a.setAttribute('title', strtooltip);

    // Get the height of the div at this point before we shrink it if required
    var height = this.div.get('offsetHeight');
    if (this.div.hasClass('collapsed')) {
        // Add the correct image and record the YUI node created in the process
        this.icon = Y.Node.create('<img src="'+M.util.image_url('collapsed', 'block_module_info')+'" alt="" />');
        // Shrink the div as it is collapsed by default
        this.div.setStyle('height', caption.get('offsetHeight')+'px');
    } else {
        // Add the correct image and record the YUI node created in the process
        this.icon = Y.Node.create('<img src="'+M.util.image_url('expanded', 'block_module_info')+'" alt="" />');
    }
    caption.insertBefore(this.icon, a);

    // Create the animation.
    var animation = new Y.Anim({
        node: this.div,
        duration: 0.3,
        easing: Y.Easing.easeBoth,
        to: {height:caption.get('offsetHeight')},
        from: {height:height}
    });

    // Handler for the animation finishing.
    animation.on('end', function() {
        this.div.toggleClass('collapsed');
        if (this.div.hasClass('collapsed')) {
            this.icon.set('src', M.util.image_url('collapsed', 'block_module_info'));
        } else {
            this.icon.set('src', M.util.image_url('expanded', 'block_module_info'));
        }
    }, this);

    // Hook up the event handler.
    a.on('click', function(e, animation) {
        e.preventDefault();
        // Animate to the appropriate size.
        if (animation.get('running')) {
            animation.stop();
        }
        animation.set('reverse', this.div.hasClass('collapsed'));
        // Update the user preference.
        if (this.userpref) {
            M.util.set_user_preference(this.userpref, !this.div.hasClass('collapsed'));
        }
        animation.run();
    }, this, animation);
};

/**
 * The user preference that stores the state of this box.
 * @property userpref
 * @type String
 */
M.block_module_info.CollapsibleRegion.prototype.userpref = null;

/**
 * The key divs that make up this
 * @property div
 * @type Y.Node
 */
M.block_module_info.CollapsibleRegion.prototype.div = null;

/**
 * The key divs that make up this
 * @property icon
 * @type Y.Node
 */
M.block_module_info.CollapsibleRegion.prototype.icon = null;