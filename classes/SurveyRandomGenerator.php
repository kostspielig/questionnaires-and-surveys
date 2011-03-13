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
		
	}
	
}