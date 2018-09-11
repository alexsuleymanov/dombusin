<?
	$v = 0 + $_POST['vote'];
	$a = 0 + $_POST['answer'];

	$Vote = new Model_Vote();
	$VoteAnswer = new Model_VoteAnswer();

	$vote = $Vote->get($v);
	$answer = $VoteAnswer->get($a);

	$VoteAnswer->update(array("count" => ($answer->count+1)), array("where" => "id = '".$answer->id."'"));

	setcookie("voted".$vote->id, 1, time()+60*60*24*30);

	$answers = $VoteAnswer->getall(array("where" => "vote = ".$vote->id));
	$view->vote = $vote;
	$view->answers = $answers;
	$view->s = $VoteAnswer->totalvotes($vote->id);


	echo $view->render('vote/results.php');

