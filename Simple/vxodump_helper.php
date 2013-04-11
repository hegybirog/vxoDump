<?php

/**
 * Class vxoDump
 */
class vxoDump
{
    /**
     * @param $var
     * @param string $name
     */
    static function dump (&$var, $name = '')
    {
        $js = 'var element = document.getElementById("debug_win"); element.parentNode.removeChild(element);';
        ?>
        <pre class="debug_pre" id='debug_win'><a id='debug_close' href='javascript:<?=$js?> void(0);'>close</a><?=$name != '' ? "<br>$name : " : ''; echo vxoDump::_get_info_var ($var, $name);?>
        <style>
            .debug_pre                  {color:#625e4b;line-height: 15px;background-color: #1d1e1a; padding: 10px 10px 10px 10px; border: 5px solid black; text-align: left; font-family: monospace; font-size: 100%;left:5%;width:89%;top:5%;position:absolute;}
            .debug_more                 {color:#AAAAFF;font-weight:bold;}
            #debug_close                {background: #db147b;padding:10px;color:#FFF;float: right;margin:10px;text-decoration: none;text-transform: uppercase;}
            #debug_close:hover          {text-decoration: underline;}
            .debug_more_ct              {background #FFF;border:10px solid #000;background:#FFF;color:#8c8c8c;line-height:19px;font-weight:normal;}
            .debug_more_ct_closed       {display: none;}
            .debug_more:hover           {text-decoration: none;}
            .debug_more:hover .debug_more_ct_closed {display: block;padding:20px;}
            .debug_text                 {color:#625e4b;}
            .debug_text_array           {color:#FFF;}
            .debug_text_array_num       {color:#f31d5f;font-weight:bold;}
            .debug_text_def             {background:#000;padding:2px;}
            .debug_text_object_type     {color:#dcd34b;}
            .debug_text_object          {color:#8fdb21;}
            .debug_text_object_parent   {color:#8fdb21;}
            .debug_text_object_property {color:#52d0e1;background:#222;}
            .debug_text_method_count    {color:#cd6e00;}
            .debug_text_already         {color:#555;}
            .debug_prop                 {color:blue;}
            .debug_constructor          {color: #a8aaa5;}
            .debug_resource             {color:#a8aaa5;}
            .debug_resource_name        {color:#a8aaa5;}
            .debug_int                  {color:#FFF;}
            .debug_float                {color:#FFF;}
            .debug_numeric              {color:#f31d5f;font-weight:bold;}
            .debug_numeric_length       {color:#555;}
            .debug_string               {color:#658da4;}
            .debug_string_length        {color:#555;}
            .debug_bool                 {color:#a8aaa5;}
            .debug_null                 {color:#a8aaa5;}
            .debug_other                {color:red;}
            small                       {color: #DDEEDD;}
        </style>
        <span style="clear:both;"></span>
        </pre>
        <?
    }

    /**
     * @param $var
     */
    public static function debug($var)
    {
        vxoDump::dump($var);
    }

    /**
     * @param $var
     * @param string $name
     * @return string
     */
    function get ($var, $name = '')
    {
        return ($name != '' ? "$name : " : '') . vxoDump::_get_info_var ($var, $name);
    }

    /**
     * @param $var
     * @param string $name
     * @param int $indent
     * @return string
     */
    function _get_info_var ($var, $name = '', $indent = 0)
    {
        static $methods = array ();
        $indent > 0 or $methods = array ();

        $indent_chars = '    ';
        $spc = $indent > 0 ? str_repeat ($indent_chars, $indent ) : '';

        $out = '';
        if (is_array ($var))
        {
            $out .= "<span class='debug_text_array'><b>array</b></span>(" . count ($var) . ") <br>$spc(\n";
            foreach (array_keys ($var) as $key)
            {
                $out .= "$spc    <span class='debug_text_def'>[<span class='debug_text_array_num'>$key</span>]</span> <span color='#888a85'>=&gt;</span> ";
                if (($indent == 0) && ($name != '') && (! is_int ($key)) && ($name == $key))
                {
                    $out .= "LOOP\n";
                }
                else
                {
                    $out .= vxoDump::_get_info_var ($var[$key], '', $indent + 1);
                }
            }
            $out .= "$spc)";
        }
        else if (is_object ($var))
        {
            $class = "<span class='debug_text_object_type'>" . get_class ($var) . "</span>";
            $out .= "<span class='debug_text_object'><b>object</b></span> $class" . "";
            $parent = get_parent_class ($var);
            $out .= $parent != '' ? " <span class='debug_text_object_type'>extends</span> <span class='debug_text_object_parent'>" . $parent  . "</span>" : '';
            $out .= " <br>$spc(\n";
            $arr = get_object_vars ($var);
            while (list($prop, $val) = each($arr)) {
                $out .= "$spc  " . "<span class='debug_text'>-&gt;</span><span class='debug_text_object_property'>$prop</span> = ";
                $out .= vxoDump::_get_info_var ($val, $name != '' ? $prop : '', $indent + 1);
            }
            $arr = get_class_methods ($var);
            $out .= "<br>$spc  " . "$class methods: <span style='debug_text_method_count'>" . count ($arr) . "</span> ";
            if (in_array ($class, $methods))
            {
                $out .= "<span class='debug_text_already'><i>[already listed]</i></span>\n";
            }
            else
            {
                $out .= "<br> $spc (\n";
                $methods[] = $class;
                while (list($prop, $val) = each($arr))
                {
                    if ($val != $class)
                    {
                        $out .= $indent_chars . "$spc  " . "<span class='debug_text'>-&gt;</span><span class='debug_prop'>$val();</span>\n";
                    }
                    else
                    {
                        $out .= $indent_chars . "$spc  " . "<span class='debug_text'>-&gt;</span><span class='debug_prop'>$val();</span> <span class='debug_constructor'><i>[<b>constructor</b>]</i></span>\n";
                    }
                }
                $out .= "$spc  " . ")\n<br>";
            }
            $out .= "$spc)";
        }
        else if (is_resource ($var))
        {
            $out .= "<small>resource</small> <span style='debug_resource_name'>" . $var . "</span> <span class='debug_resource'><i>(type=" . get_resource_type($var) . ")</i></span>";
        }
        else if (is_int ($var))
        {
            $out .= "<small>int</small> <span class='debug_int'>" . $var . "</span>";
        }
        else if (is_float ($var))
        {
            $out .= "<small>float</small> <span class='debug_float'>" . $var . "</span>";
        }
        else if (is_numeric ($var))
        {
            $out .= "'<span class='debug_numeric'>" . $var . "</span>' <small>numstring</small><span class='debug_numeric_length'><i>(length=" . strlen($var) . ")</i></span>";
        }
        else if (is_string ($var))
        {
            $more = nl2br(htmlentities(substr($var,0,60))) . '... <a href="#" class="debug_more">more<span class="debug_more_ct debug_more_ct_closed">' . $var . '</span></a>';
            $kiir = strlen($var) > 60 ? $more : nl2br(htmlentities($var));

            $out .= "'<span class='debug_string'>" . $kiir . "</span>' <small>string</small><span class='debug_string_length'><i>(length=" . strlen($var) . ")</i></span>";
        }
        else if (is_bool ($var))
        {
            $out .= "<small>bool</small> <span class='debug_bool'>" . ($var ? 'True' : 'False') . "</span>";
        }
        else if (! isset ($var))
        {
            $out .= "<small class='debug_null'>null</small>";
        }
        else
        {
            $out .= "<small class='debug_other'>other</small> " . $var . "";
        }

        return $out . "\n";
    }
}

