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
 * Constructs HTML for Module Info block
 *
 * @package    block_module_info
 * @copyright  2013 Queen Mary, University of London
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/blocks/module_info/lib.php');

class block_module_info_renderer extends plugin_renderer_base {
    
    /**
     * Array of configuration data.
     * 
     * @var unknown_type
     */
    private $data = null;
    
    public function initialise($owner) {
        global $CFG,$COURSE;
        
        $result = false;
        
        if(!empty($data)) {
            return $result;
        }
        
        $this->data = new stdClass();
        
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
        $this->data->info = $dbc->return_table_values($table, $keyfields, $fields);
        $this->data->block_config = $owner->config;
        $this->data->context = $owner->context;
        
        $convenor  = get_config('block_module_info','convenor');
        $convenorid = get_config('block_module_info','convenorid');
        
        $this->data->module_code = '';
        $this->data->module_level = '';
        $this->data->module_semester = '';
        $this->data->module_credit = '';
        $this->data->module_convenor_email = '';
        
        $module_code_field = get_config('block_module_info','module_code');
        $module_level_field = get_config('block_module_info','module_level');
        $module_credit_field = get_config('block_module_info','module_credit');
        $module_semester_field = get_config('block_module_info','module_semester');
        $convenor_name_field = get_config('block_module_info','convenor_name');
        $convenor_field = get_config('block_module_info','convenor');
        
        foreach($this->data->info as $field) {
            if (! empty($field[$module_code_field])) {
                $this->data->module_code = $field[$module_code_field];
            }
            if (! empty($field[$module_level_field]) && ! empty($this->data->block_config->module_level)) {
                $this->data->module_level = $field[$module_level_field];
            }
            if (! empty($field[$module_credit_field]) && ! empty($this->data->block_config->module_credit)) {
                $this->data->module_credit = $field[$module_credit_field];
            }
            if (! empty($field[$module_semester_field]) && ! empty($this->data->block_config->module_semester)) {
                $this->data->module_semester = $field[$module_semester_field];
            }
            if (! empty($field[$convenor_field]) && ! empty($this->data->block_config->display_convenor)) {
                $this->data->module_convenor_email = $field[$convenor_field];
            }
        }
        
        // override values out of the interim MIS if necessary
        if(! empty($this->data->block_config->module_code_override)) {
            $this->data->module_code = $this->data->block_config->module_code_override;
        }
        if(! empty($this->data->block_config->module_level_override)) {
            $this->data->module_level = $this->data->block_config->module_level_override;
        }
        if(! empty($this->data->block_config->module_semester_override)) {
            $this->data->module_semester = $this->data->block_config->module_semester_override;
        }
        if(! empty($this->data->block_config->module_credit_override)) {
            $this->data->module_credit = $this->data->block_config->module_credit_override;
        }
        if(! empty($this->data->block_config->module_convenor_override)) {
            $this->data->module_convenor_email = $this->data->block_config->module_convenor_override;
        }
        
        $result = true;
        
        return $result;
    }
    
    public function get_convenorinfo_output() {
        global $DB, $OUTPUT;
        
        $result = '';

        // Output module convenor information#
        // Mug shot:
        if (! empty($this->data->block_config->display_convenor) && ! empty ($this->data->module_convenor_email)) {
            
            $result .= html_writer::start_tag('div', array('id' => 'convenor'));
            
            $headings_options = array(get_string('teacher_headings_options_not_configured', 'block_module_info'));
            $headings = get_config('block_module_info', 'convenor_role_name_options');
            if(!empty($headings) && strlen($headings) > 0) {
                $headings_options = explode("\r\n", $headings);
            }
            
            $result .= html_writer::tag('h2', $headings_options[$this->data->block_config->module_owner_heading],
                    array('class'=>'convenor'));
             
            // NOTE: the following logic assumes that users can't change their email addresses...
            if($thisconvenor = $DB->get_record('user', array('email' => $this->data->module_convenor_email))) {
                // Mugshot
                $size = ($this->data->block_config->convenor_profilepic_size=='small')?'50':'64';
                $result .= $OUTPUT->user_picture($thisconvenor, array('size' => $size, 'class'=>'profile-pic'));
        
                // Name:
                $result .= html_writer::start_tag('p');
                /*$this->content->text .= html_writer::tag('span', get_string( 'convenor_name', 'block_module_info' ).': ',
                 array('class'=>'module_info_title'));*/
                $result .= html_writer::tag('strong', fullname($thisconvenor, true));
                $result .= html_writer::end_tag('p');
                 
                // Email address:
                $result .= html_writer::link('mailto:'.$thisconvenor->email, $thisconvenor->email);
        
            } else {
                $result .= html_writer::start_tag('p');
                $result .= html_writer::tag('strong', $this->data->module_convenor_email.get_string( 'convenor_not_found', 'block_module_info' ));
                $result .= html_writer::end_tag('p');
        
            }
            $result .= html_writer::end_tag('div');
        }
        
        return $result;
    }
    
    /**
     * Returns HTML to display module information.
     * 
     * @param unknown_type $info
     * @param unknown_type $config
     * @param unknown_type $contextid
     * @return string
     */
    public function get_moduleinfo_output() {
    	
        global $CFG,$DB,$OUTPUT;
        require_once($CFG->libdir . '/filelib.php');
 
        $result = '';

        
        // Now build HTML
        if (! empty($this->data->block_config->module_code) && ! empty ($this->data->block_config->module_code)) {
        	$result .= html_writer::start_tag('p');
        	$result .= html_writer::tag('span', get_string( 'module_code', 'block_module_info' ).': ',
        			array('class'=>'module_info_title'));
        	$result .= html_writer::tag('strong', $this->data->module_code);
        	$result .= html_writer::end_tag('p');
        }
        if (! empty($this->data->block_config->module_level) && ! empty ($this->data->block_config->module_level)) {
        	$result .= html_writer::start_tag('p');
        	$result .= html_writer::tag('span', get_string( 'module_level', 'block_module_info' ).': ',
        			array('class'=>'module_info_title'));
        	$result .= html_writer::tag('strong', $this->data->module_level);
        	$result .= html_writer::end_tag('p');
        }
        if (! empty($this->data->block_config->module_credit) && ! empty ($this->data->block_config->module_credit)) {
        	$result .= html_writer::start_tag('p');
        	$result .= html_writer::tag('span', get_string( 'module_credit', 'block_module_info' ).': ',
        			array('class'=>'module_info_title'));
        	$result .= html_writer::tag('strong', $this->data->module_credit);
        	$result .= html_writer::end_tag('p');
        }
        if (! empty($this->data->block_config->module_semester) && ! empty ($this->data->block_config->module_semester)) {
        	$result .= html_writer::start_tag('p');
        	$result .= html_writer::tag('span', get_string( 'module_semester', 'block_module_info' ).': ',
        			array('class'=>'module_info_title'));
        	$result .= html_writer::tag('strong', $this->data->module_semester);
        	$result .= html_writer::end_tag('p');
        }
        
        return $result;
        
    }
    
    /**
     * Internal function - creates htmls structure suitable for YUI tree.
     * 
     * @param unknown_type $context
     * @param unknown_type $block_context
     * @param unknown_type $dir
     * @return string
     */
    protected function htmllize_document_tree($context, $block_context, $dir) {
        global $CFG;
        
        $result = '';
        
        $yuiconfig = array();
        $yuiconfig['type'] = 'html';
    
        if (empty($dir['subdirs']) and empty($dir['files'])) {
            return '';
        }
        $result = '<ul>';
        foreach ($dir['subdirs'] as $subdir) {
            $image = $this->output->pix_icon("f/folder", $subdir['dirname'], 'moodle', array('class'=>'icon'));
            $result .= '<li yuiConfig=\''.json_encode($yuiconfig).'\'><div>'.$image.s($subdir['dirname']).'</div> '.$this->htmllize_document_tree($context, $block_context, $subdir).'</li>';
        }
        foreach ($dir['files'] as $file) {
            $url = file_encode_url("$CFG->wwwroot/pluginfile.php", '/'.$context->id.'/block_module_info/documents/'.$block_context->id.$file->get_filepath().$file->get_filename(), true);
            $filename = $file->get_filename();
            $icon = mimeinfo("icon", $filename);
            $image = $this->output->pix_icon("f/$icon", $filename, 'moodle', array('class'=>'icon'));
            $result .= '<li yuiConfig=\''.json_encode($yuiconfig).'\'><div>'.html_writer::link($url, $image.$filename).'</div></li>';
        }
        $result .= '</ul>';
    
        return $result;
    }
    
    /**
     * Returns a collapsible document tree. Documents are associated with this module - specified by the course owner.
     * 
     * @param unknown_type $block_context
     * @return string
     */
    public function get_documentinfo_output() {
        global $USER;
        
        $result = html_writer::tag('h2', get_string( 'documents_header', 'block_module_info' ),
                array('class'=>'documents'));
        
        // Get the stored files
        $fs = get_file_storage();
        $dir = $fs->get_area_tree($this->page->context->id, 'block_module_info', 'documents', $this->data->context->id);
        
        $module = array('name'=>'block_module_info', 'fullpath'=>'/blocks/module_info/module.js', 'requires'=>array('yui2-treeview'));
        if (empty($dir['subdirs']) && empty($dir['files'])) {
            $result .= $this->output->box(get_string('nofilesavailable', 'repository'));
        } else {
            $htmlid = 'document_tree_'.uniqid();
            $this->page->requires->js_init_call('M.block_module_info.init_tree', array(false, $htmlid));
            $result .= '<div id="'.$htmlid.'">';
            $result .= $this->htmllize_document_tree($this->page->context, $this->data->context, $dir);
            $result .= '</div>';
        }
        
        return $result;
    }

    /**
     * Return true for now
     */
    public function content_is_trusted() {
    	return true;
    }
}


