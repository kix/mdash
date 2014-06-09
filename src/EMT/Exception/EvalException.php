<?php
namespace EMT\Exception;

class EvalException extends \Exception
{
	
	private $evaldCode;

	public function __construct($evaldCode, $message = "", $code = 0, Exception $previous = null)
	{
		parent::__construct($message = "", $code = 0, $previous);
		$this->evaldCode = $evaldCode;
	}

	public function __toString()
	{
		return parent::__toString() . ', eval\'d code: ' . $this->evaldCode;
	}

}