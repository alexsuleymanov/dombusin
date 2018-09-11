<!-- Featured -->
<div class="title"><span>Рекомендуемые категории</span></div>
<?
$Action = new Model_Page('actions');
$actions = $Action->getall(array("where" => "visible = 1", "limit" => "8", "order" => "tstamp desc"));
$i = 0;
foreach ($actions as $action) {?>
	<div class="col-xs-6 col-sm-4 col-lg-3 box-product-outer bpo-rc">
		<div class="box-product">
			<div class="img-wrapper">
				<a href="<?=$action->href ?>">
					<?if(file_exists('pic/actions/'.$action->id.'.jpg')) {?>
					<img alt="<?=$action->name?>" src="/thumb?src=pic/actions/<?= $action->id ?>.jpg&amp;width=201&amp;height=201">
					<?} else {?>
						<img alt="<?=$action->name?>" src="<?=$this->path?>/img/tr.gif">
					<?}?>
				</a>
			</div>
			<h2 class="h6"><a href="<?=$action->href ?>"><?=$action->name?></a></h2>
		</div>
	</div>
<? } ?>
<!-- End Featured -->
<div class="clearfix"></div>