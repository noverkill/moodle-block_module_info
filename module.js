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
 * Init private files treeview
 *
 * @package    block_private_files
 * @copyright  2009 Petr Skoda (http://skodak.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

var additional_teachers_heading = null;
var documents_heading = null;
var schedule_heading = null;

function hide_additional_teachers(e) {
	if(additional_teachers_heading) {
		e.halt();
		// Change heading class
		var span = additional_teachers_heading.one('span');
		if(span) {
			span.removeClass('expanded');
			span.addClass('collapsed');
		}
		// Hide all additional teachers
		var pane = additional_teachers_heading.get('nextSibling');
		if(pane) {
			pane.setAttribute("hidden", true);
		}
		// Attach new event handler
		additional_teachers_heading.detach('click', this.hide_additional_teachers, false);
		additional_teachers_heading.on('click', this.show_additional_teachers, this);
	}
}
		
function show_additional_teachers(e) {
	if(additional_teachers_heading) {
		e.halt();
		// Change heading class
		var span = additional_teachers_heading.one('span');
		if(span) {
			span.removeClass('collapsed');
			span.addClass('expanded');
		}
		// Hide all additional teachers
		var pane = additional_teachers_heading.get('nextSibling');
		if(pane) {
			pane.removeAttribute("hidden");
		}
		// Attach new event handler
		additional_teachers_heading.detach('click', this.show_additional_teachers, false);
		additional_teachers_heading.on('click', this.hide_additional_teachers, this);
	}
}

function hide_documents(e) {
	if(documents_heading) {
		e.halt();
		// Change heading class
		var span = documents_heading.one('span');
		if(span) {
			span.removeClass('expanded');
			span.addClass('collapsed');
		}
		// Hide all documents
		var pane = documents_heading.get('nextSibling');
		if(pane) {
			pane.setAttribute("hidden", true);
		}
		// Attach new event handler
		documents_heading.detach('click', this.hide_documents, false);
		documents_heading.on('click', this.show_documents, this);
	}
}
		
function show_documents(e) {
	if(documents_heading) {
		e.halt();
		// Change heading class
		var span = documents_heading.one('span');
		if(span) {
			span.removeClass('collapsed');
			span.addClass('expanded');
		}
		// Hide all documents
		var pane = documents_heading.get('nextSibling');
		if(pane) {
			pane.removeAttribute("hidden");
		}
		// Attach new event handler
		documents_heading.detach('click', this.show_documents, false);
		documents_heading.on('click', this.hide_documents, this);
	}
}
		
function hide_schedule(e) {
	if(schedule_heading) {
		e.halt();
		// Change heading class
		var span = schedule_heading.one('span');
		if(span) {
			span.removeClass('expanded');
			span.addClass('collapsed');
		}
		// Hide all sessions
		var pane = schedule_heading.get('nextSibling');
		if(pane) {
			pane.setAttribute("hidden", true);
		}
		// Attach new event handler
		schedule_heading.detach('click', this.hide_schedule, false);
		schedule_heading.on('click', this.show_schedule, this);
	}
}
		
function show_schedule(e) {
	if(schedule_heading) {
		e.halt();
		// Change heading class
		var span = schedule_heading.one('span');
		if(span) {
			span.removeClass('collapsed');
			span.addClass('expanded');
		}
		// Show all sessions
		var pane = schedule_heading.get('nextSibling');
		if(pane) {
			pane.removeAttribute("hidden");
		}
		// Attach new event handler
		schedule_heading.detach('click', this.show_schedule, false);
		schedule_heading.on('click', this.hide_schedule, this);
	}
}

M.block_module_info = {};

M.block_module_info.init_document_tree = function(Y, expand_all, htmlid) {
		Y.use('yui2-treeview', function(Y) {
	
			additional_teachers_heading = Y.one('#additional-teachers-heading'); 
			additional_teachers_heading.on('click', hide_additional_teachers, this);
			
			documents_heading = Y.one('#documents-heading'); 
			documents_heading.on('click', hide_documents, this);
			
			schedule_heading = Y.one('#schedule-heading'); 
			schedule_heading.on('click', hide_schedule, this);
			
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