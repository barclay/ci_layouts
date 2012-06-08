Layout Hook for CodeIgniter
===========================

A modification for CodeIgniter 2.x to support rails or cakePHP style layouts. 

For those new to this, a layout contains presentation code that wraps around the current view view. Anything you want to see in all of your views should be placed in a layout.

Layout files should be placed in /applications/views/layouts/... You can specify which layout is to be used in your controller. i.e.

```php
// in applciation/controllers/welcome.php
//
class Welcome extends MY_Controller { 
    
    function index() {

        // loads layout application/views/layouts/my_new_layout.phtml
        //
        $this->layout = 'my_new_layout';
        $this->load->view('index');
    }
}
```

When you create a layout, you need to tell it where to place the code for your views. To do so, make sure your layout includes a $yield variable. Also, please note that all layouts are expecting a .phtml extension (this is on purpose to try and remind developers that these should be _super_ light on php logic). 

Here's an example of what a default layout might look like:

```html
<!-- in application/layouts/default.phtml -->
<html>
    <title></title>
    <body>
        <h1>Header</h1>
        <?php echo $yield; ?>
    </body>
</html>
```

If you'd like to pass variables into your layout, you can via the MY_Controller's setLayoutVar() method. Any variables set here will be exposed to the layout's scope. 

For example:
```php
// in applciation/controllers/welcome.php
//
class Welcome extends MY_Controller { 
    function index() {
        $this->layout = 'my_new_layout';
        $this->setLayoutVar('body_class', 'foo');
        $this->setLayoutVar('footer', $this->load->view('footer', null, 1)); 
        $this->load->view('index');
    }
}
```

```html
<!-- in application/view/layout/my_new_layout.phtml -->
...
<body class="<?php echo $body_class; ?>">
    <h1>Header</h1>
    <?php echo $yield; ?>
    <?php echo $footer; ?>
</body>
```

To turn off a layout for a particular action (i.e. an AJAX request), you can set the layout member to be null, or string literal 'none'. 

```php
// in applciation/controllers/welcome.php
//
class Welcome extends MY_Controller { 
    function json_action() {
        $this->layout = 'none';
        echo json_encode(array('foo' => 'bar'));
    }
}
```

You can also play around with creating JSON or XML layout templates as well. This can be super useful for normalizing your async return values. 

Notes
=====

When using the layouts hook, you'll no longer be able to call echo() from within a controller action. Well, you _can_, but there's some funny timings, and anything you echo will appear _above_ the layout. And, really, as per MVC conventions, you should be using _views_ anyway!


Installation
============

Clone the project, and add the files into your CI project. In application/config/config.php, the only change from the default config is to turn the hooks on (line 94). 

And then in application/config/hooks.php you can see how we're wiring up the layouts to CI's display_override event. 

In application/hooks/layout.php is where all the magic happens of loading and executing the layout. 

For the application/core/MY_Controller, the logic is in place for setting a default layout, and handing the setLayoutVar method. 