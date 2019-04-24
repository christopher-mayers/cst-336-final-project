<?php

if (preg_match("/^api$/", $_SERVER["REQUEST_URI"]))
{
	require "api/index.php";
}
else
{
	return false;
}