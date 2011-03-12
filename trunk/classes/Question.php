<?php
class Question {
	public $itemCode;
	public $item;
	public $responseType;
	public $response;
	//public $date;
	
	public function Question() {
		// Allows for overloaded constructors
		$a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='Question'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        }
	}
	
	function Question3($a1,$a2,$a3) 
    { 
        $this->itemCode = $a1;
		$this->item = $a2;
		$this->responseType = $a3;
    }
    
	public function toString()
    {
    	var_dump($this);
    }
	

}