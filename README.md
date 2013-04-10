vxoDump
=======

Formated and colorized alternative of <b>var_dump</b> php function.<br>
- You can use stand alone, 
- or You can use in your <b>CodeIgniter</b> project or whatever.
- You can customize the colors easily.
- Absolult positioned (or you can change the css class type),
- but you can close with close button.
- Only one file, simple to use.

Usage
----
Just include the helper, and use the dump method.
```php
  require_once("vxodump_helper.php");
  vxoDump::dump($variable);
```

  or, you can add a name to display.
```php 
  vxoDump::dump($variable,"variable name");
```

in CodeIgniter
--------------
In CI, you need put the helper into your <b>```application/helpers/```</b> folder from the CI folder.

You can autoload the helper if you put this line into your <b>```application/configuration/autoloads.php```</b>
```php 
  $autoload['helper'] = array('vxodump');
```

The colors
----------
You can simply change the colors, backgrounds or whatever. In the vxodump_helper.php you can change the styles easily.
```html
<style>
  .debug_pre                  {background-color: whitesmoke; padding: 8px 8px 8px 8px; border: 1px solid black; text-align: left; font-family: monospace; font-size: 100%;left:5%;width:89%;top:5%;position:absolute;}
  .debug_more                 {color:#FF5555;font-weight:bold;}
  #debug_close                {background: #db147b;padding:10px;color:#FFF;float: right;margin:10px;text-decoration: none;text-transform: uppercase;}
  #debug_close:hover          {text-decoration: underline;}
  .debug_more_ct_closed       {display: none;}
  .debug_more:hover           {text-decoration: none;}
  .debug_more:hover .debug_more_ct_closed {color:#a0a0a0;display: block;padding:20px;border:10px solid #d0d0d0;}
  .debug_text                 {color:#888a85;}
  .debug_text_array           {color:#cc0000;}
  .debug_text_array_num       {color:#CC0000;font-weight:bold;}
  .debug_text_def             {background:#f9ffdf;padding:2px;}
  .debug_text_object_type     {color:#00aaaa;}
  .debug_text_object          {color:purple;}
  .debug_text_object_parent   {color:#006688;}
  .debug_text_object_property {color:purple;background:#FFF;padding:0 4px;border-top:1px dashed #808080;}
  .debug_text_method_count    {color:#cd6e00;}
  .debug_text_already         {color:#a8aaa5;}
  .debug_prop                 {color:blue;}
  .debug_constructor          {color: #a8aaa5;}
  .debug_resource             {color:#a8aaa5;}
  .debug_resource_name        {color:#a8aaa5;}
  .debug_int                  {color:blue;}
  .debug_float                {color:blue;}
  .debug_numeric              {color:#6facff;font-weight:bold;}
  .debug_numeric_length       {color:#a8aaa5;}
  .debug_string               {color:#658da4;font-weight:bold;}
  .debug_string_length        {color:#a8aaa5;}
  .debug_bool                 {color:darkorange;}
  .debug_null                 {color:#6facff;}
  .debug_other                {color:red;}
</style>
```

If you want more function or you find a bug just tell me! :)

