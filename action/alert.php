<?php

//SMALL SCRIPT TO HANDLE ERROR, SUCCESS AND NOTIFICATION MESSAGES.

if (isset($success) || isset($error) || isset($notify)) 
{
	foreach($success as $successmsg)
	{
echo'<div class="alert-box success">';

		echo $successmsg;
			echo '</div>';
}

	foreach($error as $errormsg)
	{
echo'<div class="alert-box alert">';

		echo $errormsg.'</br>';
		echo '</div>';
	}

	foreach($notify as $notifymsg)
	{
echo'<div class="alert-box warning">';

		echo $notifymsg.'</br>';
		echo '</div>';
	}
}
