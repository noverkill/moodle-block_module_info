<?php

/****************************************************************

File:       block/module_info/block_module_info.php

Purpose:    This file holds the class definition for the block,
            and is used both to manage it as a plugin and to
            render it onscreen.

****************************************************************/

class block_module_info extends block_base {

    /**
     * Initialize the block
     *
     * Give values to any class member variables
     * that need instantiating
     *
     * @return void
     */
	public function init() {

        $this->title = get_string('module_info', 'block_module_info');

        $this->config = new stdClass();

        $this->config->module_code = false;
        $this->config->module_level = false;
        $this->config->module_credit = false;
        $this->config->module_semester = false;

        //$this->config->display_convenor = true;

        $defaulthtml = get_config('block_module_info', 'defaulthtml');
        $this->config->htmlcontent['text'] = $defaulthtml;
        $this->config->html = true;
    }


    /**
     * Configure the block
     *
     * This method is called immediately after init()
     * but before anything else is done with the block
     * (e.g before it has been displayed)
     *
     * @return void
     */
    public function specialization() {
        $this->title = isset($this->config->title) ? format_string($this->config->title) : format_string(get_string('module_info', 'block_module_info'));
    }


    /**
     * This block can appear only on course pages
     *
     * @return boolean
     */
    public function applicable_formats() {
        return array('course' => true);
    }

    /**
     * Allow the block to have a configuration page
     *
     * @return boolean
     */
    public function has_config() {
        return true;
    }

    /**
     * Allow instances to have their own configuration pages
     *
     * @return boolean
     */
    function instance_allow_config() {
        return true;
    }

    /**
     * Disable adding multiple instances of this block to one course
     *
     * @return boolean
     */
    public function instance_allow_multiple() {
        return false;
    }

    /**
     * Create the content that needs to be displayed by this block
     *
     * @return mixed
     */
    public function get_content() {

        if ($this->content !== null) {
            return $this->content;
        }

        $output_buffer = '';

        $renderer = $this->page->get_renderer('block_module_info');

        $renderer->initialise($this);

        // Display module info
        $output_buffer .= $renderer->get_moduleinfo_output();

        // Display Teaching info
        $output_buffer .= $renderer->get_teaching_output();

        // Display Schedule info
        $output_buffer .= $renderer->get_sessioninfo_output();

        // Links to documents
        $output_buffer .= $renderer->get_documentinfo_output();

        // Display legacy HTML - don't move the code to the renderer as we want to remove it eventually.
        $filteropt = new stdClass;
        $filteropt->overflowdiv = true;

        // fancy html allowed only on course, category and system blocks.
        if ($this->content_is_trusted()) {
            $filteropt->noclean = true;
        }

        if((! $this->config->html) || ($this->config->html && (! empty($this->config->htmlcontent['text'])))) {

            $legacyheading = get_string('legacy_header', 'block_module_info');

            if(!empty($this->config->legacy_html_heading)) {
                $legacyheading = $this->config->legacy_html_heading;
            }

            $output_buffer .= mod_info_collapsible_region_start('legacyhtml-heading', 'modinfo-viewlet-legacyhtml', $legacyheading, 'modinfo-legacyhtml', true, true);

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

        return $this->content;
    }

    /**
     * Check if it safe to enable fancy html editor
     *
     * @return boolean
     */
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
}
