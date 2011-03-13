<?php
/**
 * The Question class encompasses two types of questions. A UserQuestion is
 * for questions that involve user information, such as age, sex, etc. The
 * SurveyQuestion class is for regular survey questions. These need to be
 * separated since they encapsulate different information.
 * 
 * @author Kevin Brotcke <brotcke@gmail.com>
 * @package classes
 */
class Question {
	public function toString()
    {
    	return var_dump($this);
    }
}

class ResponseType {
	const YES_NO = 'Yes/No';
	const INPUT_BOX = 'Input Box';
	// or Integer
}

class SurveyQuestion extends Question {
	public $itemCode;
	public $item;
	public $responseType;
	public $response;
	
	public function SurveyQuestion() {
		// Allows for overloaded constructors
		$a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='SurveyQuestion'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        }
	}
	
	function SurveyQuestion3($itemCode, $item, $responseType) 
    { 
        $this->itemCode = $itemCode;
		$this->item = $item;
		$this->responseType = $responseType;
    }
}

class UserQuestion extends Question {
	public $userItem;
	public $userResponse;
	
	public function UserQuestion() {
		// Allows for overloaded constructors
		$a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='UserQuestion'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        }
	}
	
	function UserQuestion1($userItem) 
    { 
        $this->userItem = $userItem;
    }
	
	function UserQuestion2($userItem, $userResponse) 
    { 
        $this->userItem = $userItem;
        $this->userResponse = $userResponse;
    }  	
}