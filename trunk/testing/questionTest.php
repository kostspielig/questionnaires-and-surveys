<?php
require_once '../includes/classes.php';

$question = new Question();
echo '<br/>',$question->toString();

$question = new Question("itemCode123", "item12312", "responseType1212");
echo '<br/>',$question->toString();

?>