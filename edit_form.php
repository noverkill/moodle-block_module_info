<?php
require_once($CFG->dirroot.'/repository/lib.php');

class block_module_info_edit_form extends block_edit_form {
	
	private $file_manager_data = null;
	
    protected function specific_definition($mform) {
    	
    	global $DB;

        $defaulthtml = get_config('block_module_info', 'defaulthtml');

        $action = optional_param('action','',PARAM_TEXT);

        if($action == 'reset') {
        	$this->_form->values->config_module_code = true;
        	$this->_form->values->config_module_level = true;
        	$this->_form->values->config_module_credit = true;
        	$this->_form->values->config_module_semester = true;
        	$this->_form->values->config_display_convenor = true;
        	$this->_form->values->config_html = true;
            $this->_form->values->config_htmlcontent = $defaulthtml;
        }

        // Core info
        $mform->addElement('header', 'configheader', get_string('core_info_header', 'block_module_info'));
 
        // Block title
        $mform->addElement('text', 'config_title', get_string('config_title', 'block_module_info'));
        $mform->setDefault('config_title', get_string('module_info', 'block_module_info'));
        $mform->setType('config_title', PARAM_MULTILANG);
        $mform->addHelpButton('config_title','config_title','block_module_info');

        $module_code = array();
        $module_code[] = & $mform->createElement('advcheckbox', 'config_module_code', get_string('config_module_code', 'block_module_info'), null, array('group'=>1));
        $module_code[] = & $mform->createElement('text', 'config_module_code_override', get_string('config_module_code_override', 'block_module_info'));
        $mform->addGroup($module_code, 'module_code', get_string('config_module_code', 'block_module_info'), array(' '), false);
        $mform->setType('config_module_code_override', PARAM_MULTILANG);
        $mform->addHelpButton('module_code', 'module_code', 'block_module_info');
        $mform->disabledIf('config_module_code_override','config_module_code');
        $mform->setDefault('config_module_code', 1);
        
        $module_level = array();
        $module_level[] = & $mform->createElement('advcheckbox', 'config_module_level', get_string('config_module_level', 'block_module_info'), null, array('group'=>1));
        $module_level[] = & $mform->createElement('text', 'config_module_level_override', get_string('config_module_level_override', 'block_module_info'));
        $mform->addGroup($module_level, 'module_level', get_string('config_module_level', 'block_module_info'), array(' '), false);
        $mform->setType('config_module_level_override', PARAM_MULTILANG);
        $mform->addHelpButton('module_level', 'module_level', 'block_module_info');
        $mform->disabledIf('config_module_level_override','config_module_level');
        $mform->setDefault('config_module_level', 1);
        
        $module_credit = array();
        $module_credit[] = & $mform->createElement('advcheckbox', 'config_module_credit', get_string('config_module_credit', 'block_module_info'), null, array('group'=>1));
        $module_credit[] = & $mform->createElement('text', 'config_module_credit_override', get_string('config_module_credit_override', 'block_module_info'));
        $mform->addGroup($module_credit, 'module_credit', get_string('config_module_credit', 'block_module_info'), array(' '), false);
        $mform->setType('config_module_credit_override', PARAM_MULTILANG);
        $mform->addHelpButton('module_credit', 'module_credit', 'block_module_info');
        $mform->disabledIf('config_module_credit_override','config_module_credit');
        $mform->setDefault('config_module_credit', 1);
        
        $module_semester = array();
        $module_semester[] = & $mform->createElement('advcheckbox', 'config_module_semester', get_string('config_module_semester', 'block_module_info'), null, array('group'=>1));
        $module_semester[] = & $mform->createElement('text', 'config_module_semester_override', get_string('config_module_semester_override', 'block_module_info'));
        $mform->addGroup($module_semester, 'module_semester', get_string('config_module_semester', 'block_module_info'), array(' '), false);
        $mform->setType('config_module_semester_override', PARAM_MULTILANG);
        $mform->addHelpButton('module_semester', 'module_semester', 'block_module_info');
        $mform->disabledIf('config_module_semester_override','config_module_semester');
        $mform->setDefault('config_module_semester', 1);
        
        $this->add_checkbox_controller(1);
        
        // Teaching
        $mform->addElement('header', 'configheader', get_string('teaching_header', 'block_module_info'));
        
        // Module owner heading
        $headings_options = array(get_string('custom_teacher_heading', 'block_module_info'));
        $headings = get_config('block_module_info', 'convenor_role_name_options');
        if(!empty($headings) && strlen($headings) > 0) {
        	$headings_options = array_merge($headings_options, explode("\r\n", $headings));
        }
        
        $mform->addElement('select', 'config_module_owner_heading', get_string('config_module_owner_heading', 'block_module_info'), $headings_options);
        $mform->addHelpButton('config_module_owner_heading','config_module_owner_heading','block_module_info');
        $mform->addElement('text', 'config_custom_teacher_heading', get_string('config_custom_teacher_heading', 'block_module_info'));
        $mform->disabledIf('config_custom_teacher_heading','config_module_owner_heading','neq',0);
                
        // Module owner property display options
        // What to display
        $possible_options = array('name'=>get_string('fullname'));
        $possible_options = array_merge($possible_options, array('profilepic'=>get_string('profilepic', 'block_module_info')));
        $possible_options = array_merge($possible_options, array('email'=>get_string('email')));
        $possible_options = array_merge($possible_options, array('icq'=>get_string('icqnumber')));
        $possible_options = array_merge($possible_options, array('url'=>get_string('webpage')));
        $possible_options = array_merge($possible_options, array('skype'=>get_string('skypeid')));
        $possible_options = array_merge($possible_options, array('aim'=>get_string('aimid')));
        $possible_options = array_merge($possible_options, array('yahoo'=>get_string('yahooid')));
        $possible_options = array_merge($possible_options, array('msn'=>get_string('msnid')));
        $possible_options = array_merge($possible_options, array('idnumber'=>get_string('idnumber')));
        $possible_options = array_merge($possible_options, array('institution'=>get_string('institution')));
        $possible_options = array_merge($possible_options, array('department'=>get_string('department')));
        $possible_options = array_merge($possible_options, array('phone1'=>get_string('phone')));
        $possible_options = array_merge($possible_options, array('phone2'=>get_string('phone2')));
        $possible_options = array_merge($possible_options, array('address'=>get_string('address')));
        
        $display_options = array();
        
        // Person display options are configured globally
        $person_display_options = explode(',', get_config('block_module_info', 'person_display_options'));
        foreach($person_display_options as $option) {
            if(array_key_exists($option, $possible_options)) {
                $display_options[$option] = $possible_options[$option];
            }
        }
        
        // Add custom profile fields to display options
        if ($fields = $DB->get_records('user_info_field')) {
            foreach ($fields as $field) {
                if(in_array($field->shortname, $person_display_options)) {
                    $display_options[format_string($field->shortname)] = format_string($field->name);
                }
            }
        }
        
        $attributes = array('size'=>'7'); 
        $select = $mform->addElement('select', 'config_display_convenor_options', get_string('config_display_convenor_options', 'block_module_info'), $display_options, $attributes);
        $select->setMultiple(true);
        $mform->setDefault('config_display_convenor_options', array('name', 'profilepic', 'email'));
        
        // Overrides
        
        // Module owner profile picture size
        $sizeoptions = array('small'=>get_string('small', 'block_module_info'), 'large'=>get_string('large', 'block_module_info'));
        $mform->addElement('select', 'config_convenor_profilepic_size', get_string('profilepic_size', 'block_module_info'), $sizeoptions);
        $mform->setDefault('config_convenor_profilepic_size', 'small');
        
        // Module owner email
        $mform->addElement('text', 'config_convenor_email_override', get_string('config_convenor_email_override', 'block_module_info'));
        $mform->setType('config_convenor_email_override', PARAM_EMAIL);
        
        // Additional teachers
        $mform->addElement('header', 'configheader', get_string('additional_teachers_header', 'block_module_info'));
        
        // Additional teachers heading
        $headings_options = array(get_string('no_teacher_heading', 'block_module_info'), get_string('custom_teacher_heading', 'block_module_info'));;
        $headings = get_config('block_module_info', 'additional_teacher_role_name_options');
        
        if(!empty($headings) && strlen($headings) > 0) {
        	$headings_options = array_merge($headings_options, explode("\r\n", $headings));
        } 
        
        $mform->addElement('select', 'config_additional_teachers_heading', get_string('config_additional_teachers_heading', 'block_module_info'), $headings_options);
        $mform->addHelpButton('config_additional_teachers_heading','config_additional_teachers_heading','block_module_info');
        $mform->addElement('text', 'config_custom_additional_teachers_heading', get_string('config_custom_additional_teachers_heading','block_module_info'));
        $mform->disabledIf('config_custom_additional_teachers_heading','config_additional_teachers_heading','neq',1);
        
        $teacherarray = array();
        $teacherarray[] = $mform->createElement('header', '', get_string('config_additional_teacher','block_module_info').' {no}');
        $teacherarray[] = $mform->createElement('text', 'config_additional_teacher_email', get_string('config_additional_teacher_email','block_module_info'));
        
        // Additional teacher display options are the same as those for the module convenor
        $attributes = array('size'=>'7');
        $select = $mform->createElement('select', 'config_display_additional_teacher_options', get_string('config_display_additional_teacher_options', 'block_module_info'), $display_options, $attributes);
        $select->setMultiple(true);
        $teacherarray[] = $select;
        
        // Additional teacher profile picture size
        $profile_size = $mform->createElement('select', 'config_additional_teacher_profilepic_size', get_string('profilepic_size', 'block_module_info'), $sizeoptions);
        $mform->setDefault('config_additional_teacher_profilepic_size', 'small');
        $teacherarray[] = $profile_size;
        
        $teacherarray[] = $mform->createElement('hidden', 'additionalteacherid', 0);
        
        $teacherno = sizeof($this->block->config->additional_teacher_email); 
        $teacherno += 1;
        
        // No settings options specified for now...
        $repeateloptions = array();
        
        $mform->setType('additionalteacherid', PARAM_INT);
        
        $this->repeat_elements($teacherarray, $teacherno,
                $repeateloptions, 'teacher_repeats', 'option_add_fields', 1, null, false);
        
        // Schedule
        $mform->addElement('header', 'configheader', get_string('schedule_header', 'block_module_info'));
        
        $mform->addElement('advcheckbox', 'config_enable_personal_timetable_link', get_string('config_enable_personal_timetable_link', 'block_module_info'));
        $mform->setDefault('config_enable_personal_timetable_link', 1);
        $mform->addElement('advcheckbox', 'config_enable_module_timetable_link', get_string('config_enable_module_timetable_link', 'block_module_info'));
        $mform->setDefault('config_enable_module_timetable_link', 1);
        
        $sessionarray = array();
        $sessionarray[] = $mform->createElement('header', '', get_string('config_additional_session','block_module_info').' {no}');
        $sessionarray[] = $mform->createElement('text', 'config_additional_session_subheading', get_string('config_additional_session_subheading','block_module_info'));
        $sessionarray[] = $mform->createElement('text', 'config_additional_session_day', get_string('config_additional_session_day','block_module_info'));
        $sessionarray[] = $mform->createElement('text', 'config_additional_session_time', get_string('config_additional_session_time','block_module_info'));
        $sessionarray[] = $mform->createElement('text', 'config_additional_session_location', get_string('config_additional_session_location','block_module_info'));
        $sessionarray[] = $mform->createElement('hidden', 'additionalsessionid', 0);
        
        $sessionno = sizeof($this->block->config->additional_session_subheading); 
        $sessionno += 1;
        
        // No settings options specified for now...
        $repeateloptions = array();
        
        $mform->setType('additionalsessionid', PARAM_INT);
        
        $this->repeat_elements($sessionarray, $sessionno,
                $repeateloptions, 'session_repeats', 'option_add_fields', 1, null, false);
        
        // Documents
        $mform->addElement('header', 'configheader', get_string('documents_header', 'block_module_info'));
        
        global $COURSE;
        
        $fileoptions = array('subdirs'=>0,
        		'maxbytes'=>$COURSE->maxbytes,
        		'accepted_types'=>'*',
        		'return_types'=>FILE_INTERNAL);
        
        global $USER;
        $this->file_manager_data = new stdClass();
        file_prepare_standard_filemanager($this->file_manager_data,
        		'files',
        		$fileoptions,
        		$this->page->context,
        		'block_module_info',
        		'documents',
        		$this->block->context->id);
        
        $mform->addElement('filemanager', 'files_filemanager', get_string('files'), null, $fileoptions);
        
        // Legacy
        $mform->addElement('header', 'configheader', get_string('legacy_header', 'block_module_info'));
        
        $mform->addElement('advcheckbox', 'config_html', get_string('config_html', 'block_module_info'));
        $mform->setDefault('config_html', 0);

        // A sample string variable with a default value.
        $editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'noclean'=>true, 'context'=>$this->block->context);
        $mform->addElement('editor', 'config_htmlcontent', get_string('config_htmlcontent', 'block_module_info'), null, $editoroptions);
        $mform->setDefault('config_htmlcontent',array('text'=>$defaulthtml, 'format'=>FORMAT_HTML));
        $mform->setType('config_htmlcontent', PARAM_RAW); // XSS is prevented when printing the block contents and serving files

        //$link = new moodle_url('/course/view.php', array('id' => $this->page->course->id, 'sesskey' => sesskey(),
        //    'bui_editid' => $this->block->instance->id, 'action' => 'reset'));

        //$mform->addElement('html', html_writer::link($link, get_string('reset', 'block_module_info')));

    }
    
    private function deleteArrayElement($anArray=array(), $index) {
        unset($anArray[$index]);
        $anArray = array_values($anArray);
        
        return $anArray;
    }
    
    function get_data() {
        
        $data = parent::get_data();
        
        if($data != null) {
            // If an additional teacher's name is blank then remove this element from the array
            $names = $data->config_additional_teacher_email;
            foreach($names as $key=>$value) {
                if(strlen($value) == 0 || $value == NULL) {
                    unset($data->config_additional_teacher_email[$key]);
                    unset($data->config_additional_teacher_location[$key]);
                    unset($data->config_additional_teacher_office_hours[$key]);
                }
            }
            $data->config_additional_teacher_email = array_values($data->config_additional_teacher_email);
            
            // Any empty additional teaching sessions also need to be removed
            $names = $data->config_additional_session_subheading;
            foreach($names as $key=>$value) {
                if(strlen($value) == 0 || $value == NULL) {
                    unset($data->config_additional_session_subheading[$key]);
                    unset($data->config_additional_session_day[$key]);
                    unset($data->config_additional_session_time[$key]);
                    unset($data->config_additional_session_location[$key]);
                } 
            }
            $data->config_additional_session_subheading = array_values($data->config_additional_session_subheading);
            $data->config_additional_session_day = array_values($data->config_additional_session_day);
            $data->config_additional_session_time = array_values($data->config_additional_session_time);
            $data->config_additional_session_location = array_values($data->config_additional_session_location);
            
            global $COURSE;
            $fileoptions = array('subdirs'=>1,
            		'maxbytes'=>$COURSE->maxbytes,
            		'accepted_types'=>'*',
            		'return_types'=>FILE_INTERNAL);
            
            file_postupdate_standard_filemanager($data,
            		'files',
            		$fileoptions,
            		$this->page->context,
            		'block_module_info',
            		'documents',
            		$this->block->context->id);
        } 
        return $data;
    }
    
    function set_data($default_values) {
        parent::set_data($default_values);
        $default_values->files_filemanager = $this->file_manager_data->files_filemanager;
        parent::set_data($default_values);
    }
    
    function validation($data, $files) {
        $errors = parent::validation($data, $files);
          
        return $errors;
    }
    
}