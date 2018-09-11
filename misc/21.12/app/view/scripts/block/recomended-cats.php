<ul style="margin-left: 40px;">
	<?
	$Action = new Model_Page('actions');
	$actions = $Action->getall(array("where" => "visible = 1", "limit" => "8", "order" => "tstamp desc"));
	$i = 0;
	foreach ($actions as $action) {?>
		<?if($i++%4==0){?>
			<div class="line clearfix">
		<?}?>
				<div class="tovar-l clearfix" id="tovar-img<?=$action->id?>">
					<div class="tovar-img">
						<a href="<?=$action->href ?>">
							<img src="/pic/actions/<?= $action->id ?>.jpg" width="152" alt="<?= $action->name ?>" id="prodpreview<?=$prod->id?>">
						</a>
					</div>
					<p align="center"><a href="<?=$action->href ?>" title="<?=$action->name?>"><?=Func::fmtname($action->name)?></a></p>
				</div>
		<?if($i%4==0){?>
			</div>
		<?}?>
	<? } ?>
	<?if($i%4!=0){?>
		</div>
	<?}?>
</ul>
