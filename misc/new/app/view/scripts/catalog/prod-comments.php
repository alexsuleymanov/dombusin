<table>
	<tr>
		<td>
			<h3><?=$this->labels["comments"]?></h3>
<?	foreach($this->comments as $comment){?>
			<div>
				<strong class="author"><?=$comment->author?></strong> <span class="date"><?=date("d.m.Y", $comment->tstamp)?></span>
				<p><?=$comment->cont?></p>
			</div>
			<hr>
<?	}?>
		</td>
	</tr>
</table>
<?	echo $this->form;