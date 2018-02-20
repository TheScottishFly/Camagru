<?php

function input($name, $type) {
    $value = isset($_POST[$name]) ? $_POST[$name] : '';
    return "<input type='$type' id='$name' name='$name' value='$value' />";
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

function extractMessageForm(){
    if (isset($_SESSION['messageForm'])){
        extract($_SESSION['messageForm']);
        unset($_SESSION['messageForm']);
        if ($type == 'error')
            return "<div class='ui error message'><div class='header'>Echec</div><p>$message</p></div>";
        else
            return "<div class='$type'>$message</div>";
    }
}

function setMessageForm($message, $type = 'success'){
    $_SESSION['messageForm']['message'] = $message;
    $_SESSION['messageForm']['type'] = $type;
}