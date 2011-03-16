<?php
/*
 * This is a special class for Surveys dealing with randomizing the questions.
 *
 * @package
 * @uses Survey, Question
 * @todo complete the empty functions and add any necessary helper functions
 */
class SurveyRandomGenerator {

	/**
	 * This takes a Survey object and checks if it is possible to make it
	 * 'pseudo' random. This takes into account the width between questions of
	 * different types specificed by the user and stored in the Survey object.
	 * In the method this value can be called by the following statement:
	 *
	 * $survey->surveyProperties["surveyTableProperties_pseudoRandomWidth"]
	 *
	 * Question types are defined by the first part of the item code substring
	 * preceding the first period. For example, if the item code is "A.83.B3",
	 * the type is just 'A'. For out purposes, the rest of the string is not
	 * useful.
	 *
	 * For instance, if the width is 2, that means an the sequence of questions
	 * cannot be ABA since the A's are only separated by one. A valid sequence
	 * could be BADCABC, since all types are separated by at least 2 from each
	 * other.
	 *
	 * After running through all combinations and no valid combination exists,
	 * return false. As soon as one valid combination is found, return true.
	 * If the width is undefined or 0, return true;
	 *
	 * @param Survey $survey
	 * @return Boolean
	 */
	public function isValid($survey) {
		$width = $survey->surveyProperties["surveyTableProperties_pseudoRandomWidth"];
		
		$questions = $survey->surveyQuestions;
		echo 'START';
		$questions = $this->array_permutations($questions);
		echo 'END';
		echo var_dump($questions);
		
		if (!isset($width) || $width == 0) {
			return true;
		}
		else {
			$questions = $survey->surveyQuestions;
			//$questions = $this->array_permutations($questions);
			echo var_dump($question);
			
			//$itemCodes = array();
			
			//$currentQuestion = current($questions);
			//while ($currentQuestion != null) {
			//	$itemCodes[] = $currentQuestion->itemCode;
			//}
			
			
		}
	}

	/**
	 * This will generate all possible survey combinations and randomly choose
	 * one. After choosing a combination, it will rewrite the questions in the
	 * Survey object passed in the parameter.
	 *
	 * @param Survey $survey
	 * @return void
	 */
	public function randomize($survey) {
		shuffle($survey->surveyQuestions);
		return $survey;
		
		//first separates questions by type
		$questions = $survey->surveyQuestions;
		//array that holds arrays of questions separated by type
		$questonArrayArray = $this->arrangeByType($questions);
		
		//randomly pulls from types and checks as it goes
		$t = count($questonArrayArray);
		//$w = $survey->surveyProperties["surveyTableProperties_pseudoRandomWidth"];
		$w = 2;
		//stack of item code types (only first part)
		$wStack = array();
		
		$randomizedQuestionArray = array();
		
		//$counter = 0;
		while (count($questonArrayArray) > 0) {
			
			reset($questonArrayArray);
			$max = &current(&$questonArrayArray);
			$current = &$max;
			while ($current != null) {
				if (count($current) > count($max) ) {
					$max = &$current;
				}
				$current = &next(&$questonArrayArray);
			}
			
			//$positionQuestionArrayArray = array_rand($questonArrayArray);
			$questionArray = &$max; //&$questonArrayArray[$positionQuestionArrayArray];
			
			if (count($questionArray) > 0) {
				
				$positionQuestionArray = &array_rand(&$questionArray);
				$question = &$questionArray[$positionQuestionArray];
							
				//var_dump($questionArray);
				//var_dump($question);
				
				$partItemCode = substr($question->itemCode, 0, strpos($question->itemCode, '.'));
				
				if ( !(in_array($partItemCode, $wStack)) ) {
						// remove from current type array
						//unset($questionArray[$positionQuestionArray]);
						
						// add to return array
						$randomizedQuestionArray[] = $question;
						//var_dump($question);
						
						if (count($wStack) >= $w) {
							array_shift($wStack);
						}
						array_push($wStack, $partItemCode);
						
						//unset($questionArray[$positionQuestionArray]);
						unset($question);
				}
				
				//if (count($question) == 0) {
				//	unset($questionArray[$positionQuestionArray]);
				//}
				
				
				
				//$counter++;
				//echo count($questionArray);
				//echo '<br/>';
				//echo count($questonArrayArray);
				//echo '<br/>';
				//echo $counter;
				//var_dump($wStack);
				//var_dump($questonArrayArray);
			}
			else {
				//unset($questonArrayArray[$positionQuestionArrayArray]);
				unset($questionArray);
			}
			
			var_dump($questonArrayArray);
			var_dump($randomizedQuestionArray);
		}
		
		var_dump($randomizedQuestionArray);
		$survey->surveyQuestions = $randomizedQuestionArray;
		return $survey;
			
			//foreach($letterTypes as &$letter) {
			//	$question2 = reset($letter);
			//	var_dump($question2);
			//	$partItemCode2 = substr($question2->itemCode, 0, strpos($question2->itemCode, '.'));
				//die;
				
			/*	if ( !(in_array($partItemCode2, $wStack)) ) {
					// remove from current type array
					$questionRandomNumber = array_rand($letter);
					$questionRandom = $letter[$questionRandomNumber];
					unset($letter[$questionRandomNumber]);
					
					// add to return array
					$randomizedQuestionArray[] = $questionRandom;
					
					if (count($letter) == 0) {
						//unset($letter);
						unset($letterTypes[$letter]);
					}
					
					if (count($wStack) == $w) {
						array_shift($wStack);
					}
					array_push($wStack, $partItemCode2);
				}
				
				$letter = next($letterTypes);
			}
			
			if (count($letterTypes) == 0) {
				unset($letterTypes);
			}
			*/
		//}
		
		
	}
	
	private function current_by_ref(&$arr) {
	    return $arr[key($arr)];
	}
	
	/**
	 * @return double array separated by types
	 */
	private function arrangeByType($questions) {
		$questonArrayArray = array();
		foreach($questions as &$question) {
			$partItemCode = substr($question->itemCode, 0, strpos($question->itemCode, '.'));
			
			$found = false;
			foreach($questonArrayArray as &$letter) {
				//add to type array that already exists
				$question2 = reset($letter);
				$partItemCode2 = substr($question2->itemCode, 0, strpos($question2->itemCode, '.'));
				if ( $partItemCode == $partItemCode2 ) {
					$letter[] = $question;
					$found = true;
				}				
			}
			if (!$found) {
				// add as new array
				$newArray = array();
				$newArray[] = $question;
				$questonArrayArray[] = $newArray;
			}
		}
		var_dump($questonArrayArray);
		return $questonArrayArray;
	}
	
	private function smartArrayPermutations($items, $perms = array()) {
		static $permuted_array;
		if (empty($items)) {
			$permuted_array[] = $perms;
		} else {
			for ($i = count($items) - 1; $i >= 0; --$i) {
				$newitems = $items;
				$newperms = $perms;
				list($foo) = array_splice($newitems, $i, 1);
				array_unshift($newperms, $foo);
				$this->array_permutations($newitems, $newperms);
			}
			return $permuted_array;
		}
	}
	
	private function array_permutations($items, $perms = array()) {
		static $permuted_array;
		if (empty($items)) {
			$permuted_array[] = $perms;
		} else {
			for ($i = count($items) - 1; $i >= 0; --$i) {
				$newitems = $items;
				$newperms = $perms;
				list($foo) = array_splice($newitems, $i, 1);
				array_unshift($newperms, $foo);
				$this->array_permutations($newitems, $newperms);
			}
			return $permuted_array;
		}
	}
	private function isValidQuestionArray($questions) {
		
	}

}