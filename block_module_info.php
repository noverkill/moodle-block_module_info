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
        return true;
    }
    
    
    
    // The PHP tag and the curly bracket for the class definition 
    // will only be closed after there is another function added in the next section.
	public function get_content() {
		
		if ($this->content !== null) {
            return $this->content;
        }
        
        $output_buffer = '';
        
        $renderer = $this->page->get_renderer('block_module_info');
        
        $info = $this->get_data();
        $output_buffer .= $renderer->get_output($info, $this->config, $this->context->id);
        
        // Legacy HTML
        $filteropt = new stdClass;
        $filteropt->overflowdiv = true;
        if ($this->content_is_trusted()) {
            // fancy html allowed only on course, category and system blocks.
            $filteropt->noclean = true;
        }
        
        if (! empty($this->config->html)) {
             
            if (!empty($this->config->htmlcontent['text'])) {
                // rewrite url
                $this->config->htmlcontent['text'] = file_rewrite_pluginfile_urls($this->config->htmlcontent['text'], 'pluginfile.php', $this->context->id, 'block_module_info', 'content', NULL);
                $this->content->text .= format_text($this->config->htmlcontent['text'], $this->config->htmlcontent['format'], $filteropt);
            } else {
                $this->content->text .= get_config('block_module_info', 'defaulthtml');
            }// if (! empty($this->config->htmlcontent))
        }
        
        // Links to documents
        $fs = get_file_storage();
        $dir = $fs->get_area_tree($this->page->context->id, 'block_module_info', 'documents', $this->context->id);
        
        $this->content->footer = '';
        
        $this->content->text = $output_buffer;
        
        // Return the result
        return $this->content;
    }

    protected function get_data() {
        global $CFG,$COURSE;
        require_once( $CFG->dirroot . '/blocks/module_info/lib.php' );
        $dbc = new module_info_data_connection();
        $table = get_config('block_module_info','dbtable');
        //create the key that will be used in sql query
        $keyfields = array(get_config('block_module_info','extcourseid') => array('=' => "'$COURSE->idnumber'"));
        
        // add fields dynamically as SEMESTER isn't there at the moment
        $module_code_field = get_config('block_module_info','module_code');
        $module_level_field = get_config('block_module_info','module_level');
        $module_credit_field = get_config('block_module_info','module_credit');
        $module_semester_field = get_config('block_module_info','module_semester');
        $convenor_name_field = get_config('block_module_info','convenor_name');
        $convenor_field = get_config('block_module_info','convenor');
        
        $fields = array();
        if(! empty ($module_code_field)) {
        	$fields[] = $module_code_field;
        }
        if(! empty ($module_level_field)) {
        	$fields[] = $module_level_field;
        }
        if(! empty ($module_credit_field)) {
        	$fields[] = $module_credit_field;
        }
        if(! empty ($module_semester_field)) {
        	$fields[] = $module_semester_field;
        }
        if(! empty ($convenor_name_field)) {
        	$fields[] = $convenor_name_field;
        }
        if(! empty ($convenor_field)) {
        	$fields[] = $convenor_field;
        }
        //$fields = array('MODULE_CODE', 'MODULE_LEVEL', 'MODULE_CREDITS', 'CONVENOR', 'CONVENOR_EMAIL');
        $values = $dbc->return_table_values($table, $keyfields, $fields);

        return $values;
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