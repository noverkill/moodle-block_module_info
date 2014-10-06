<?php

/****************************************************************

File:       block/module_info/version.php

Purpose:    This file holds version information for the plugin,
            along with other advanced parameters like object field
            definitions that denote the version number of the block,
            along with the minimum version of Moodle that must be
            installed in order to use it.
			These parameters are used during the plugin installation
			and upgrade process to make sure that the
			plugin is compatible with the given Moodle site, as well
			as spotting whether an upgrade is needed.

****************************************************************/

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2014091900;  			// YYYYMMDDHH (year, month, day, 24-hr time)
$plugin->requires  = 2011112900; 			// YYYYMMDDHH (This is the release version for Moodle 2.0)
$plugin->component = 'block_module_info';	// Full name of the plugin (used for diagnostics)

