<?php

/**
 * Class that manages the layout mechanism. Called via CI's display_override hook. 
 * 
 * @package Readyforce.Hooks
 */
class Layout
{
    
    /** 
     * Method that handles the rendering of the page content into the 
     * given template. The template is specified in the RF_Controller::$layout
     * property. If layout is null, or the controller is derived from something
     * that's NOT RF_Controller based, then we'll return, and let CI continue
     * it's default rendering. 
     * 
     * NOTE: By using this layout mechanism, any echo statements in your 
     * controller will fire BEFORE the page renders, and will come down outside
     * the template. 
     *
     * @param  string  $output  When called with an output param, we'll ignore 
     *                          the current stack's get_output() call and use
     *                          the supplied content instead. (Exception handling
     *                          is done this way). 
     * @return void. 
     */
    public static function Yield($output=null) {
        $ci=& get_instance();

        if (!$output)
            $yield = $ci->output->get_output();
        else 
            $yield = $output;

        // no layout, so let CI's internals handle it. 
        //
        if (!isset($ci->layout) || $ci->layout == null || $ci->layout == '' || $ci->layout == 'none') {
            echo $yield;
            return;
        }

        // get the layout. I'm specifically using the .phtml extension to
        // remind devs that these templates should be VERY light weight. 
        //
        $layout = "application/views/layouts/{$ci->layout}.phtml";
        if (!file_exists($layout)) {
            echo "<h2 style=\"color: red;\">Warning: Layout {$layout} not found</h2>";
            echo $yield;
            return; 
        }
        
        // pull in the layout vars to the function's scope.
        //
        extract($ci->layout_vars);

        // run the layout. 
        //
        include $layout;
    }
}



