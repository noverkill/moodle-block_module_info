<?php
 
class block_module_info_edit_form extends block_edit_form {
 
    protected function specific_definition($mform) {

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

        $mform->addElement('advcheckbox', 'config_module_code', get_string('config_module_code', 'block_module_info'));
        $mform->setDefault('config_module_code', 1);
        $mform->addElement('text', 'config_module_code_override', get_string('config_module_code_override', 'block_module_info'));
        $mform->setType('config_module_code_override', PARAM_MULTILANG);
        
        $mform->addElement('advcheckbox', 'config_module_level', get_string('config_module_level', 'block_module_info'));
        $mform->setDefault('config_module_level', 1);
        $mform->addElement('text', 'config_module_level_override', get_string('config_module_level_override', 'block_module_info'));
        $mform->setType('config_module_level_override', PARAM_MULTILANG);
        
        $mform->addElement('advcheckbox', 'config_module_credit', get_string('config_module_credit', 'block_module_info'));
        $mform->setDefault('config_module_credit', 1);
        $mform->addElement('text', 'config_module_credit_override', get_string('config_module_credit_override', 'block_module_info'));
        $mform->setType('config_module_credit_override', PARAM_MULTILANG);
        
        $mform->addElement('advcheckbox', 'config_module_semester', get_string('config_module_semester', 'block_module_info'));
        $mform->setDefault('config_module_semester', 1);
        $mform->addElement('text', 'config_module_semester_override', get_string('config_module_semester_override', 'block_module_info'));
        $mform->setType('config_module_semester_override', PARAM_MULTILANG);
        
        // Teaching
        $mform->addElement('header', 'configheader', get_string('teaching_header', 'block_module_info'));
        
        // Module owner heading
        $headings = explode("\r\n", get_config('block_module_info', 'convenor_role_name_options'));
        $mform->addElement('select', 'config_module_owner_heading', get_string('config_module_owner_heading', 'block_module_info'), $headings);
        
        // Module owner name
        $mform->addElement('advcheckbox', 'config_display_convenor_name', get_string('config_display_convenor_name', 'block_module_info'));
        $mform->setDefault('config_display_convenor_name', 1);
        $mform->addElement('text', 'config_convenor_name_override', get_string('config_convenor_name_override', 'block_module_info'));
        
        // Module owner email
        $mform->addElement('advcheckbox', 'config_display_convenor_email', get_string('config_display_convenor_email', 'block_module_info'));
        $mform->setDefault('config_display_convenor_email', 1);
        $mform->addElement('text', 'config_convenor_email_override', get_string('config_convenor_email_override', 'block_module_info'));
        $mform->setType('config_convenor_email_override', PARAM_EMAIL);
        
        // Module owner location
        $mform->addElement('advcheckbox', 'config_display_convenor_location', get_string('config_display_convenor_location', 'block_module_info'));
        $mform->setDefault('config_display_convenor_location', 1);
        $mform->addElement('text', 'config_convenor_location_override', get_string('config_convenor_location_override', 'block_module_info'));
        
        // Module owner office hours
        $mform->addElement('advcheckbox', 'config_display_convenor_office_hours', get_string('config_display_convenor_office_hours', 'block_module_info'));
        $mform->setDefault('config_display_convenor_office_hours', 1);
        $mform->addElement('text', 'config_convenor_office_hours_override', get_string('config_convenor_office_hours_override', 'block_module_info'));
        
        // Personal web page
        $mform->addElement('advcheckbox', 'config_display_convenor_personal_webpage', get_string('config_display_convenor_personal_webpage', 'block_module_info'));
        $mform->setDefault('config_display_convenor_personal_webpage', 1);
        
        // Additional teachers
        $mform->addElement('header', 'configheader', get_string('additional_teachers_header', 'block_module_info'));
        
        $mform->addElement('text', 'config_additional_teachers_heading', get_string('config_additional_teachers_heading', 'block_module_info'));
        $mform->setDefault('config_additional_teachers_heading', get_string('config_additional_teachers_heading_default', 'block_module_info'));
        
        $teacherarray = array();
        $teacherarray[] = $mform->createElement('header', '', get_string('config_additional_teacher','block_module_info').' {no}');
        $teacherarray[] = $mform->createElement('text', 'config_additional_teacher_name', get_string('config_additional_teacher_name','block_module_info'));
        $teacherarray[] = $mform->createElement('text', 'config_additional_teacher_email', get_string('config_additional_teacher_email','block_module_info'));
        $teacherarray[] = $mform->createElement('text', 'config_additional_teacher_location', get_string('config_additional_teacher_location','block_module_info'));
        $teacherarray[] = $mform->createElement('text', 'config_additional_teacher_office_hours', get_string('config_additional_teacher_office_hours','block_module_info'));
        $teacherarray[] = $mform->createElement('hidden', 'additionalteacherid', 0);
        
        $teacherno = sizeof($this->block->config->additional_teacher_name); 
        $teacherno += 1;
        
        // No settings options specified for now...
        $repeateloptions = array();
        
        $mform->setType('additionalteacherid', PARAM_INT);
        
        $this->repeat_elements($teacherarray, $teacherno,
                $repeateloptions, 'teacher_repeats', 'option_add_fields', 1);
        
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
                $repeateloptions, 'session_repeats', 'option_add_fields', 1);
        
        
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
            $names = $data->config_additional_teacher_name;
            foreach($names as $key=>$value) {
                if(strlen($value) == 0 || $value == NULL) {
                    $data->config_additional_teacher_name = $this->deleteArrayElement($data->config_additional_teacher_name, $key);
                    $data->config_additional_teacher_email = $this->deleteArrayElement($data->config_additional_teacher_email, $key);
                    $data->config_additional_teacher_location = $this->deleteArrayElement($data->config_additional_teacher_location, $key);
                    $data->config_additional_teacher_office_hours = $this->deleteArrayElement($data->config_additional_teacher_office_hours, $key);
                    $data->teacher_repeats=$data->teacher_repeats-1;
                }
            }
            
            // Any empty additional teaching sessions also need to be removed
            $names = $data->config_additional_session_subheading;
            foreach($names as $key=>$value) {
                if(strlen($value) == 0 || $value == NULL) {
                    $data->config_additional_session_subheading = $this->deleteArrayElement($data->config_additional_session_subheading, $key);
                    $data->config_additional_session_day = $this->deleteArrayElement($data->config_additional_session_day, $key);
                    $data->config_additional_session_time = $this->deleteArrayElement($data->config_additional_session_time, $key);
                    $data->config_additional_session_location = $this->deleteArrayElement($data->config_additional_session_location, $key);
                    $data->session_repeats=$data->session_repeats-1;
                }
            }
        }
        return $data;
    }
    
    function set_data($default_values) {
        
        parent::set_data($default_values);
        
    }
    
    function validation($data, $files) {
        $errors = parent::validation($data, $files);
          
        return $errors;
    }
    
}