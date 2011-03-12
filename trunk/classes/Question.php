<?php
class Question {
	public function toString()
    {
    	var_dump($this);
    }
}

// This class is for reguler survey questions
class SurveyQuestion extends Question {
	public $itemCode;
	public $item;
	public $responseType;
	public $response;
	//TODO: public $date;
	
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

// This class is for questions pertaining to user info such as age, sex, etc.
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
	
	function UserQuestion2($userItem, $userResponse) 
    { 
        $this->userItem = $userItem;
        $this->userResponse = $userResponse;
    }  	
}