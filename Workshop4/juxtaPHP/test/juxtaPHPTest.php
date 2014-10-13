<?php
require_once(dirname(__FILE__) . '/../juxtaPHP.php');

class JuxtaPHPTest extends \PHPUnit_Framework_TestCase
{
    
	protected $tempId;

    protected function setUp()
    {
        // Initialize tempId of the test Quiz
        $this->tempId = 0;
    }

    public function testGetQuizzes()
	{
	    $juClient = new JuxtaPHP();
	    $response = $juClient->getQuizzes();
	    if($response->code == "200") {
	    $foo = true;
		}
		else {
			$foo = false;
		}
	    $this->assertTrue($foo);
	}

    public function testMakeNewQuiz()
	{
	    $juClient = new JuxtaPHP();
	    $quizThings = array('title'=>'Who shot first?','description'=>'HAN SHOT FIRST!');
	    $response = $juClient->makeNewQuiz($quizThings);
	    $this->tempId = $response->body->_id;
	    if($response->code == "201") {
	    $foo = true;
		}
		else {
			$foo = false;
		}
	    $this->assertTrue($foo);
	}    

    public function testUpdateQuizzById()
	{
	    $juClient = new JuxtaPHP();
	    $quizThings = array('topic'=>'Star Wars');
	    $response = $juClient->UpdateQuizzById($this->tempId, $quizThings);
	    $this->tempId = $response->body->_id;
	    if($response->code == "200") {
	    $foo = true;
		}
		else {
			$foo = false;
		}
	    $this->assertTrue($foo);
	}    

	public function testGetQuizById()
	{
	    $juClient = new JuxtaPHP();
	    $response = $juClient->getQuizzById($this->tempId);
	    if($response->code == "200") {
	    	$foo = true;
		}
		else {
			$foo = false;
		}
	    $this->assertTrue($foo);
	}

    public function testremoveQuizById()
	{
	    $juClient = new JuxtaPHP();
	    $response = $juClient->removeQuizById($this->tempId);
	    if($response->code == "200") {
	    $foo = true;
		}
		else {
			$foo = false;
		}
	    $this->assertTrue($foo);
	}

}