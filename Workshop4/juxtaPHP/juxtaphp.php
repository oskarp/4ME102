<?php
// Include the REST library
require_once("lib/httpful/httpful.phar");

class JuxtaPHP {
	private $URL = "http://celtest1.lnu.se:4040";
	
	/*
	*	Get all quizzes
	*
	*/

	public function getQuizzes() {
		$response = \Httpful\Request::get($this->URL . "/quizzes")->send();
		return $response;
	}
	/*
	*	Get a quiz by ID
	*
	*/
	public function getQuizzById($id) {
		$response = \Httpful\Request::get($this->URL . "/quizzes/id/".$id)->send();
		return $response;
	}
	
	/*
	*	Create a new quiz
	*	[“mediaItem:type” must be one of the following: video, image]
	*	Responds with 201 on success
	*/

	public function makeNewQuiz($quiz) {
		$response = \Httpful\Request::post($this->URL . "/quizzes/new")
			->sendsJson()
			->body($quiz)
			->send();

		return $response;
	}

	/*
	*	Update a quiz
	*	Responds with 200 on success
	*/

	public function updateQuizzById($id, $update) {
		$response = \Httpful\Request::put($this->URL . "/quizzes/id/".$id)
			->sendsJson()
			->body($update)
			->send();

		return $response;
	}

	/*
	*	Deletes quiz by ID
	*
	*/

	public function removeQuizById($id){
		$response = \Httpful\Request::delete($this->URL . "/quizzes/delete/".$id)->send();
		return $response;		
	}

}