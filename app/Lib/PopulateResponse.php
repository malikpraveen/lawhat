<?php
namespace Lib;

use Illuminate\Http\Response;

class PopulateResponse
{
	private $response;

	function __construct($data)
	{
		$this->response = $data;
		// parent::__construct();
	}

	public function apiResponse()
	{
		// if(!is_object($this->response)){
			$this->response = json_decode(json_encode($this->response),128);
		// }

		return $this->replace_null_with_empty_string($this->response);
	}

	public function replace_null_with_empty_string($array)
	{
	    foreach ($array as $key => $value) {
            if(is_array($value))
	            $array[$key] = $this->replace_null_with_empty_string($value);
	        else {
	            if (is_null($value))
	                $array[$key] = "";
	        }

	    }
    	return $array;
	}

}
