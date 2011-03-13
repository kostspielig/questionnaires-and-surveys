<?php
require_once '../includes/classes.php';

$question = new Question();
echo '<br/>',$question->toString();

$question = new UserQuestion();
echo '<br/>',$question->toString();

$question = new UserQuestion("arg1", "arg2");
echo '<br/>',$question->toString();

$question = new SurveyQuestion();
echo '<br/>',$question->toString();

$question = new SurveyQuestion("arg1", "arg2", "arg3");
echo '<br/>',$question->toString();

//var_dump(get_defined_vars());

?>