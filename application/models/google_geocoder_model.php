<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Google_geocoder_model extends CI_Model
{
	function get_coords( $city )
	{
		$city_spaced = str_replace( ' ', '+', $city );
		$json = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$city_spaced.'&sensor=false');
		$decoded = json_decode($json, TRUE);
		
		$error = $decoded['status'];
		if ( $error != 'OK' )
		{
			return FALSE;
		}
		else
		{
			return $decoded['results'][0]['geometry']['location']['lat'].','.$decoded['results'][0]['geometry']['location']['lng'];
		}
	}
}
