<?php

/**
 * Plugin name: Vacancies List
 * Plugin URI: https://github.com/emagweb/vacancies
 * Description: Get vacancies from external APIs in WordPress
 * Author: Antonina Osipenko
 * Author URI: https://github.com/emagweb/
 * version: 0.1.0
 * License: GPL2 or later.
 * text-domain: vacancies-list
 */

// Includes
defined('ABSPATH') || die('Unauthorized access');

add_shortcode('vacancies_list', 'callback_function_name');

function callback_function_name()
{

	$url = 'https://emagweb.github.io/sdev/data/vacancies.json';

	$arguments = array(
		'method' => 'GET'
	);

	$response = wp_remote_get($url, $arguments);

	if (is_wp_error($response)) {
		$error_message = $response->get_error_message();
		return "Someething went wrong: $error_message";
	}

	$vacancies = json_decode(wp_remote_retrieve_body($response));

	$html = '';

	$html += '<h1>List</h1>';

	foreach ($vacancies as $vacancy) {
		$html += '<p>' . $vacancy->count . '</p>';
		$html += '<p>' . $vacancy->salary . '</p>';
		$html += '<p>' . $vacancy->general_experience . '</p>';
		$html += '<p>' . $vacancy->position . '</p>';
		$html += '<p>' . $vacancy->business_area . '</p>';
		$html += '<p>' . $vacancy->timeline->start . '</p>';
		$html += '<p>' . $vacancy->timeline->end . '</p>';
		$html += '<p>' . $vacancy->timeline->job_title . '</p>';
		$html += '<p>' . $vacancy->timeline->desc . '</p>';
	}

	$html += '';

	return $html;
}