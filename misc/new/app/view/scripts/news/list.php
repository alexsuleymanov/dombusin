	<table cellspacing="15" border="0" width="100%">
		<tr>
<?		foreach($this->news as $k => $v){?>
			<td width="100" valign="top" class="newslistdate"><img src="/pic/news/<?=$v->id?>.jpg" width="100" alt="<?=$v->name?>"></td>
			<td class="newslistname" valign="top">
				<a href="<?=$this->url->mkd(array(1, $v->intname))?>" class="newsh"><span class="date"><?echo date("d.m.Y", $v->tstamp);?></span></a>
				<a href="<?=$this->url->mkd(array(1, $v->intname))?>" class="newsh"><?=$v->name?></a>
				<br><?=substr(strip_tags($v->cont), 0, 200)."...";?>
				<br><br><p align="right"><a href="<?=$this->url->mkd(array(1, $v->intname))?>">Подробнее</a></p>
			</td>
		</tr>
<?
		}?>
	</table>
