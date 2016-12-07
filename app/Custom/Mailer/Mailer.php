<?php

namespace App\Custom\Mailer;

use Mailgun\Mailgun;
use Http\Adapter\Guzzle6;

class Mailer
{
	/**
	 * Static Mailer Instance
	 *
	 * @var Mailgun
	 */
	private static $mailer;

	/**
	 * Mailgun Secret API key
	 * Mailgun Domain
	 *
	 * @var string
	 */
	protected static $mg_domain = 'mail.grabbthedeal.in';
	private static $mg_secret = 'key-9cbadc68e75df284a4cb0c84ed81b9d7';

	/**
	 * Mailgun constructor.
	 *
	 * @return void
	 */
	public function __construct () {
		$http = new Guzzle6\Client();
		self::$mailer = new Mailgun(self::$mg_secret,$http);
	}

	/**
	 * If already not iniatilized
	 * Initialize Mailgun
	 *
	 * @return Mailer|Mailgun
	 */
	protected static function initMailgun () {
		if (self::$mailer) {
			return self::$mailer;
		} else {
			new Mailer();
			return self::$mailer;
		}
	}

	/**
	 * Send Message Wrapper
	 * Accepts same Mailgun data array
	 *
	 * @param $data array
	 * @throws \Mailgun\Messages\Exceptions\MissingRequiredMIMEParameters
	 * @return void
	 */
	public static function sendMessage ($data) {
		self::initMailgun()->sendMessage(self::$mg_domain, $data);
	}
}