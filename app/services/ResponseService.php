<?php

class ResponseService extends \Slim\Http\Response{

	public function jsonOk($data = ""){
		return $this->withJson(array(
			"success" => true,
			"data" => $data
		));
	}

	public function jsonKo($data){
		return $this->withJson(array(
			"success" => false,
			"data" => $data
		), 500);
	}
}
