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

        // Section header title according to language file.
        $mform->addElement('header', 'configheader', get_string('core_info_header', 'block_module_info'));
 
        // Block title
        $mform->addElement('text', 'config_title', get_string('config_title', 'block_module_info'));
        $mform->setDefault('config_title', get_string('module_info', 'block_module_info'));
        $mform->setType('config_title', PARAM_MULTILANG);

        // Settings
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
        
        $mform->addElement('header', 'configheader', get_string('teaching_header', 'block_module_info'));
        
        $mform->addElement('advcheckbox', 'config_display_convenor', get_string('config_display_convenor', 'block_module_info'));
        $mform->setDefault('config_convenor', 1);
        $mform->addElement('text', 'config_module_convenor_override', get_string('config_module_convenor_override', 'block_module_info'));
        $mform->setType('config_module_convenor_override', PARAM_EMAIL);
        
        $mform->addElement('advcheckbox', 'config_html', get_string('config_html', 'block_module_info'));
        $mform->setDefault('config_html', 1);

        // A sample string variable with a default value.
        $editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'noclean'=>true, 'context'=>$this->block->context);
        $mform->addElement('editor', 'config_htmlcontent', get_string('config_htmlcontent', 'block_module_info'), null, $editoroptions);
        $mform->setDefault('config_htmlcontent',array('text'=>$defaulthtml, 'format'=>FORMAT_HTML));
        $mform->setType('config_htmlcontent', PARAM_RAW); // XSS is prevented when printing the block contents and serving files


        //$link = new moodle_url('/course/view.php', array('id' => $this->page->course->id, 'sesskey' => sesskey(),
        //    'bui_editid' => $this->block->instance->id, 'action' => 'reset'));

        //$mform->addElement('html', html_writer::link($link, get_string('reset', 'block_module_info')));

    }
}