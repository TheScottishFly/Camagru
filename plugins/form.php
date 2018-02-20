<?php

function input($name) {
    $value = isset($_POST[$name]) ? $_POST[$name] : '';
    return "<input type='text' id='$name' name='$name' value='$value' />";
}

function textarea($name) {
    $value = isset($_POST[$name]) ? $_POST[$name] : '';
    return "<textarea type='text' id='$name' name='$name'>$value</textarea>";
}

function select($name, $options = array()) {
    $return = "<select id='$name' name='$name'>";
    foreach ($options as $key => $value) {
        $selected = "";
        if (isset($_POST[$name]) && $key == $_POST[$name])
            $selected = "selected='selected'";
        $return .= "<option value='$key' $selected>$value</option>option>";
    }
    $return .= "</select>";
    return $return;
}