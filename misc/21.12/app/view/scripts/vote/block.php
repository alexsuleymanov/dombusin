<script>
	function vote_result(data){
		$("#voteblock").html(data);
	}

	function voteclick(){
		$.post($("#voteform").attr('action'), $("#voteform").serialize(), vote_result);
	}
</script>
<?
	$Vote = new Model_Vote();
	$VoteAnswer = new Model_VoteAnswer();

	$this->vote = $Vote->getone(array("where" => "visible = 1", "order" => "rand()"));

    $voted = $_COOKIE['voted'.$this->vote->id];
	
	$this->answers = $VoteAnswer->getall(array("where" => "vote = ".$this->vote->id));
	$this->s = $VoteAnswer->totalvotes($this->vote->id);

	if($voted){
		echo $this->render('vote/results.php');
	}else{?>
<div id="voteblock">
<h2>Голосование</h2>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td style="padding: 0 0 2 10;" valign="top" align="left"><b><?=$this->vote->name?></b></td>
	</tr>
	<form action="/vote" method='POST' name="voteform" id="voteform">
	<tr>
		<td style="padding: 0 0 0 0;" valign="top">
			<table width="100%" border=0 cellspacing=0>

<?		foreach($this->answers as $k => $v) {?>
				<tr>
					<td class="votet" id="ans_<?=$v->id?>">
						<input type="radio" name="answer" value="<?=$v->id?>"> <?=$v->name?>
					</td>
				</tr>
<?		}?>
			</table>
		</td>
	</tr>
	<tr>
		<td align='center' id="vote_submit">
			<input type='hidden' name='vote' value='<?=$this->vote->id?>'>
			<div align="center"><input type="submit" name="butvote" value="Ответить" onClick="voteclick(); return false;"></div>
		</td>
	</tr>
	</form>
</table>
</div>
<?	}?>