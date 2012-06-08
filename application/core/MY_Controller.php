<?php

/**
 * Subclass of the CI_Controller class that implements the layout member. 
 * 
 * @author barclay loftus
 */
class MY_Controller extends CI_Controller
{
    /**
     * The public member for specifying which layout template we should use
     * (located in application/views/layout/). If no layout is specified,
     * then no layout will be applied.
     *
     * @return string
     */
    public $layout = 'default';
    
    /**
     * Array that contains variables to be passed into the layout at rendertime. 
     *
     * @var array
     */
    public $layout_vars = array();
    
    /**
     * Method for setting a variable to be rendered within the current page's 
     * layout
     * 
     * @param  string $var_name  The name of the variable
     * @param  mixed  $val       The value
     * @return void
     */
    public function setLayoutVar($var_name, $val) {
        $this->layout_vars[$var_name] = $val;
    }
}
