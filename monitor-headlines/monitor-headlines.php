<?php

/**
 * @package monitor-headlines
 */
/*
Plugin Name: Monitor-Headlines
Plugin URI: https://masiko.com/
Description: Used by millions, to monitor headlines from the daily monitor newspaper and depict it 
Version: 0.0.1
Author: Timothy Masiko
Author URI: https://masikotimo.github.io/portfolio/
License: GPLv2 or later

*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/


if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  security team is watching you.';
	exit;
}

class MonitorHeadline{
    
    function __construct()
    {
     
        add_action('init',array($this,'custom_post_type'));
        $this->fetchHeadlines('https://www.monitor.co.ug/uganda');
    }
    
    function activate(){

        $this->custom_post_type();
        $this->fetchHeadlines('https://www.monitor.co.ug/uganda');

        flush_rewrite_rules();
    }

    function deactivate(){

        flush_rewrite_rules();
    }

    function uninstall(){

    }

    function custom_post_type(){
        register_post_type('book',['public'=> true, 'label'=>'Books']);
    }

    function fetchHeadlines($url){
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_URL, $url); 

        $output= curl_exec($ch);
       
        preg_match_all('/(<h3>\V|<h3>)<a href="(.*?)">(.*?)<\/a><\/h3>/', $output, $headlines);
    
        foreach ($headlines[0] as $headline => $value) {
            echo $value;
        }
    
        return $headlines[0];
    
    }
    
     

   
}

if (class_exists('MonitorHeadline')){
    $monitorheadline= new MonitorHeadline();
}


//activation

register_activation_hook( __FILE__, array($monitorheadline,'activate') );

//deactivation

register_deactivation_hook( __FILE__, array($monitorheadline,'deactivate') );

//uninstall