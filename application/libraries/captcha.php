<?php

/**
 * @package FusionCMS
 * @author Jesper Lindström
 * @author Xavier Geerinck
 * @author Elliott Robbins
 * @link http://fusion-hub.com
 */

class Captcha
{
	/**
	 * Configuration
	 */
	private $stack = "abcdefghijklmnopqrstuvxyzABCDEFGHIJKLMNOPQRSTUVXYZ123456789";
	private $length = 7;
	private $distortionLevel = 3;

	/**
	 * Runtime values
	 */
	private $value;
	private $stackLength;

	/**
	 * Initialize the current session if available
	 */
	public function __construct($enable = true)
	{
		// Count the stack (starting from 0)
		$this->stackLength = strlen($this->stack) - 1;

		if(session_id() == '')
			session_start();

		// Initialize the previous session
		if(isset($_SESSION['captcha']))
		{
			$this->value = $_SESSION['captcha'];
		}

		if(!$enable)
		{
			$this->value = false;
		}
	}

	/**
	 * Generate a new value and tie it to a session
	 */
	public function generate()
	{
		$this->value = "";

		for($i = 0; $i < $this->length; $i++)
		{
			$this->value .= $this->random();
		}

		$_SESSION['captcha'] = $this->value;
	}

	/**
	 * Generate one random character from the stack
	 * @return String
	 */
	private function random()
	{
		return $this->stack{rand(0, $this->stackLength)};
	}

	/**
	 * Create an image
	 * @param Int $width
	 * @param Int $height
	 */
	public function output($width, $height)
	{
		// Create the image
		$image = imagecreatetruecolor($width, $height);

		// Create some colors
		$backgroundColor = imagecolorallocate($image, 0, 0, 0);
		$textColor = imagecolorallocate($image, 250, 0, 0);

		// Draw the transparent background
		imagecolortransparent($image, $backgroundColor);

		// Draw the text
		imagestring($image, 5, 3, 4, $this->value, $textColor);

		// Draw some lines to distort
		for($i = 0; $i < $this->distortionLevel; $i++)
		{
			imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), imagecolorallocatealpha($image, rand(0,255), rand(0,255), rand(0,255), 60));
		}

		// Define the headers and output it
		header("Cache-Control: no-cache, must-revalidate");
		header("Content-type: image/png");  
		imagepng($image);  
	}

	/**
	 * Get the captcha value as plaintext and destroy the session
	 * @return String
	 */
	public function getValue()
	{
		return $this->value;
	}
}