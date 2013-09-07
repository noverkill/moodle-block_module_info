<?php

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
 * Strings for component 'block_module_info', language 'en', branch 'MOODLE_20_STABLE'
 *
 * @package   block_module_info
 * @copyright 2012 onwards University of London Computer Centre
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
class block_module_info extends block_base {
    
	public function init() {
        $this->title = get_string('module_info', 'block_module_info');
        
        $this->config = new stdClass();
        
        $this->config->module_code = true;
        $this->config->module_level = true;
        $this->config->module_credit = true;
        $this->config->module_semester = true;
        $this->config->display_convenor = true;
        $defaulthtml = get_config('block_module_info', 'defaulthtml');
        $this->config->htmlcontent['text'] = $defaulthtml;
        $this->config->html = true;
    }

    public function applicable_formats() {
        return array('course' => true);
    }

    public function specialization() {
        $this->title = isset($this->config->title) ? format_string($this->config->title) : format_string(get_string('module_info', 'block_module_info'));
    }

    public function instance_allow_multiple() {
        return false;
    }
    
    // The PHP tag and the curly bracket for the class definition 
    // will only be closed after there is another function added in the next section.
	public function get_content() {
		
		if ($this->content !== null) {
            return $this->content;
        }
        
        $output_buffer = '';
        
        $renderer = $this->page->get_renderer('block_module_info');
        
        $renderer->initialise($this);
        
        // Display module info
        $output_buffer .= $renderer->get_moduleinfo_output();
        
        // Display convenor info
        $output_buffer .= $renderer->get_convenorinfo_output();
        
        // Display additional teacher info
        $output_buffer .= $renderer->get_additionteacherinfo_output();
        
        // Display Schedule info
        $output_buffer .= $renderer->get_sessioninfo_output();
        
        // Links to documents
        $output_buffer .= $renderer->get_documentinfo_output();
        
        // Display legacy HTML - don't move the code to the renderer as we want to remove it eventually.
        $filteropt = new stdClass;
        $filteropt->overflowdiv = true;
        if ($this->content_is_trusted()) {
            // fancy html allowed only on course, category and system blocks.
            $filteropt->noclean = true;
        }
        
        if (!empty($this->config->html)) {
            $output_buffer .= mod_info_collapsible_region_start('legacyhtml-heading', 'modinfo-viewlet-legacyhtml', get_string('legacy_header', 'block_module_info'), 'modinfo-legacyhtml', true, true);
            if (!empty($this->config->htmlcontent['text']) && !empty($this->config->htmlcontent['format'])) {
                // rewrite url
                $this->config->htmlcontent['text'] = file_rewrite_pluginfile_urls($this->config->htmlcontent['text'], 'pluginfile.php', $this->context->id, 'block_module_info', 'content', NULL);
                $output_buffer .= format_text($this->config->htmlcontent['text'], $this->config->htmlcontent['format'], $filteropt);
            } else {
                $output_buffer .= get_config('block_module_info', 'defaulthtml');
            }// if (! empty($this->config->htmlcontent))
            $output_buffer .= mod_info_collapsible_region_end(true);
        }
        
        // The output buffer is now complete so copy this to the content
        $this->content = new stdClass();
        
        $this->content->text = $output_buffer;
        
        $this->content->footer = '';
        
        // Return the result
        return $this->content;
    }

    function content_is_trusted() {
        global $SCRIPT;

        if (!$context = get_context_instance_by_id($this->instance->parentcontextid)) {
            return false;
        }
        //find out if this block is on the profile page
        if ($context->contextlevel == CONTEXT_USER) {
            if ($SCRIPT === '/my/index.php') {
                // this is exception - page is completely private, nobody else may see content there
                // that is why we allow JS here
                return true;
            } else {
                // no JS on public personal pages, it would be a big security issue
                return false;
            }
        }

        return true;
    }
}   // Here's the closing bracket for the class definition