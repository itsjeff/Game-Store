<?php
/*
 * Set value
 *
 */
function set_value($key)
{
	return (isset($_POST[$key])) ? trim(htmlspecialchars($_POST[$key])) : '';
}


/*
 * Form - Select
 *
 */
function form_select($name, array $options, $selected)
{
	// Select start
	$select = '<select class="select" name="' . $name . '">'."\n";
	
	
	// Loop through options
	foreach ($options as $option => $value)
	{
		$is_selected = ($selected == $value) ? ' selected="selected"' : '';
		
		$select .= '<option value="' . $value . '"' . $is_selected . '>' . $option . '</option>'."\n";
	}
	
	
	// Select end
	$select .= '</select>'."\n";
	
	return $select;
}
?>