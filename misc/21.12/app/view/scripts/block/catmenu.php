<?
$Prod = new Model_Prod();
$Char = new Model_Char();
$Charval = new Model_Charval();
$Cat = new Model_Cat();
$cat = $Cat->get($this->cat);
$parent = $Cat->get($cat->cat);

$supcats = $Cat->getall(array("where" => "cat = 0 and visible = 1", "order" => "prior desc, name asc"));

$prodcounts = array();

$supurl = '';
if(($this->args[1] === 'new') || ($this->args[1] === 'action') || ($this->args[1] === 'pop')) {
	$supurl = $this->args[1]."/";
}

?>

	<div class="left-tab" id="left-tab-1" <?if($this->chars_count && count($this->prods)){?>style="display: none;"<?}else{?>style="display: block;"<?}?>>
		<ul>
			<? foreach ($supcats as $k => $supcat_r) { ?>
				<li <?if($parent->id==$supcat_r->id) { echo "class=\"cat-active\""; }else{ echo "class=\"cat-active\"";}?>>
					<?
					$cats = $Cat->getall(array("where" => "cat = $supcat_r->id and visible = 1", "order" => "prior desc, name asc"));
					?>
					<a href="/catalog/<?=$supurl?>cat-<?= $supcat_r->id ?>-<?= $supcat_r->intname ?>"
					   data-prodcount="0"
					   data-id="<?= $supcat_r->id ?>">
						<div class="pa">
							<div class="pa catplus<?=count($cats)?' cat-plus':''?>" onclick="$(this).parent().parent().parent().toggleClass('cat-active');return false;"></div>
						</div>
						<?= $supcat_r->name ?>
					</a>
					<?$i = 0;
					if (count($cats)) {
						if($this->args[1] == 'new'){
							if(!$prodcounts = $this->cache->load('prodcount_new'.$supcat_r->id)){
								foreach ($cats as $sk => $cat_r) {
									$prodcounts[$cat_r->id] = $Prod->getnum(array(
										"where" => "visible = 1 and (num > 0 or num2 > 0 or num3 > 0) and changed > " . (time() - 45 * 86400),
										"relation" => array(
											"select" => "relation",
											"where" => "`type` = 'cat-prod' and obj = '" . $cat_r->id . "'"
										),
									));
								}
								$this->cache->save($prodcounts, 'prodcount_new'.$supcat_r->id, array("model_prod"));
							}						
						}
						if($this->args[1] == 'pop'){
							if(!$prodcounts = $this->cache->load('prodcount_pop'.$supcat_r->id)){
								foreach ($cats as $sk => $cat_r) {
									$prodcounts[$cat_r->id] = $Prod->getnum(array(
										"where" => "visible = 1 and (num > 0 or num2 > 0 or num3 > 0) and pop = 1",
										"relation" => array(
											"select" => "relation",
											"where" => "`type` = 'cat-prod' and obj = '" . $cat_r->id . "'"
										),
									));
								}
								$this->cache->save($prodcounts, 'prodcount_pop'.$supcat_r->id, array("model_prod"));
							}						
						}
						if($this->args[1] == 'action'){
							if(!$prodcounts = $this->cache->load('prodcount_action'.$supcat_r->id)){
								foreach ($cats as $sk => $cat_r) {
									$prodcounts[$cat_r->id] = $Prod->getnum(array(
										"where" => "visible = 1 and (num > 0 or num2 > 0 or num3 > 0) and skidka > 0",
										"relation" => array(
											"select" => "relation",
											"where" => "`type` = 'cat-prod' and obj = '" . $cat_r->id . "'"
										),
									));
								}
								$this->cache->save($prodcounts, 'prodcount_action'.$supcat_r->id, array("model_prod"));
							}						
						}
						//echo "111pc"; print_r($prodcounts);
						?>
						<ul id="jsddm" class="jsddm">
							<? foreach ($cats as $sk => $cat_r) {
								$subcats = $Cat->getall(array("where" => "cat = $cat_r->id and visible=1", "order" => "prior desc"));
								$prodcount = $prodcounts[$cat_r->id];
//								print_r($prodcounts);
								?>
								<li<?if(($this->cat==$cat_r->id)||($cat_r->id==$parent->id)) {?> class="hover"<?}?>>
									<a href="/catalog/<?=$supurl?>cat-<?= $cat_r->id ?>-<?= $cat_r->intname ?>"
									   data-prodcount="<?=0+$prodcount?>"
									   data-id="<?= $cat_r->id ?>">
										<?= $cat_r->name ?>
									</a>
									<?
									if(count($subcats)!=0){?>
										<div class="sc4" style="border-right: 0px;">
											<ul style="padding: 10px 10px 10px 0px;">
												<?		$p=0;
												foreach($subcats as $sk1 => $scat_r) {
													switch ($this->args[1]) {
														case 'new':
															$prodcount = $Prod->getnum(array(
																"where" => "visible = 1 and (num > 0 or num2 > 0 or num3 > 0) and changed > " . (time() - 45 * 86400),
																"relation" => array(
																	"select" => "relation",
																	"where" => "`type` = 'cat-prod' and obj = '" . $scat_r->id . "'"
																),
															));
															break;
														case 'pop':
															$prodcount = $Prod->getnum(array(
																"where" => "visible = 1 and (num > 0 or num2 > 0 or num3 > 0) and pop = 1",
																"relation" => array(
																	"select" => "relation",
																	"where" => "`type` = 'cat-prod' and obj = '" . $scat_r->id . "'"
																),
															));
															break;
														case 'action':
															$prodcount = $Prod->getnum(array(
																"where" => "visible = 1 and (num > 0 or num2 > 0 or num3 > 0) and skidka > 0",
																"relation" => array(
																	"select" => "relation",
																	"where" => "`type` = 'cat-prod' and obj = '" . $scat_r->id . "'"
																),
															));
															break;
													}
													?>
													<li class="sc2"<?if($p++%3==0){?> style="clear: both;"<?}?>>
														<a href="/catalog/<?=$supurl?>cat-<?=$scat_r->id?>-<?=$scat_r->intname?>"<?=($this->cat==$scat_r->id)?' class="sub-active"':''?>
														   data-prodcount="<?=0+$prodcount?>"
														   data-id="<?= $scat_r->id ?>">
															<?=$scat_r->name?>
															<?
															if (($this->args[1]=='new')||($this->args[1]=='pop')||($this->args[1]=='action')) {
																echo '('.$prodcount.')';
															}
															?>

														</a>
													</li>
												<?		}?>
												<li style="clear: both;"></li>
											</ul>
										</div>
									<?}?>

									<?	$chars = $Char->getall(array("where" => "cat = $cat_r->id and incat = 1", "order" => "prior desc"));

									if(count($chars)!=0){?>
										<div class="sc4" style="border-right: 0px;">
											<ul style="padding: 10px 10px 10px 0px;">
												<?		$i=0;
												foreach($chars as $sk2 => $char_r){
													$charvals = $Charval->getall(array("where" => "`char` = ".$char_r->id));
													foreach($charvals as $cv_r){
														?>
														<li class="sc2"><a href="/catalog/cat-<?=$cat_r->id?>-<?=$cat_r->intname?>/char-<?=$char_r->id?>-<?=$cv_r->id?>"><?=$cv_r->value?></a></li>

													<?			}
												}?>
											</ul>
										</div>
									<?}?>

								</li>
							<? } ?>
						</ul>
					<? } ?>
				</li>
			<? } ?>
		</ul>
	</div>
<?if (($this->args[1]=='new')||($this->args[1]=='pop')||($this->args[1]=='action')) {?>
	<script>
		$('.side_menu ul li a').mouseover(function(){
			$(this).find('.cat-plus').addClass('cat-plus-hover');
		});
		$('.side_menu ul li a').mouseout(function(){
			$(this).find('.cat-plus').removeClass('cat-plus-hover');
		});
		$(document).ready(function() {
			$('#left-tab-1 > ul > li > ul > li').each(function(){
				var prodcount = 0;
				var pthis = $(this);
				$(this).find('ul > li > a').each(function(){
					prodcount = prodcount + parseInt($(this).attr('data-prodcount'));
					var qthis = $(this);
					$('.sl-item').each(function () {
						if(parseInt($(this).attr('data-id')) == parseInt(qthis.attr('data-id'))) {
							$(this).append(' (' + parseInt(qthis.attr('data-prodcount')) + ')');
							$(this).attr('data-prodcount', parseInt(qthis.attr('data-prodcount')));
						}
					});
				});
				//prodcount = prodcount + parseInt(pthis.children('a').first().attr('data-prodcount'));
				if(prodcount == 0) {
					pthis.remove();
				} else {
					pthis.children('a').append(' (' + prodcount + ')');
					pthis.children('a').attr('data-prodcount', prodcount);
				}
				$('.sl-item').each(function () {
					if(parseInt($(this).attr('data-id')) == parseInt(pthis.children('a').attr('data-id'))) {
						$(this).append(' (' + prodcount + ')');
						$(this).attr('data-prodcount', prodcount);
					}
				});
			});
			$('#left-tab-1 > ul > li').each(function(){
				var prodcount = 0;
				var pthis = $(this);
				$(this).find(' > ul > li > a').each(function(){
					prodcount = prodcount + parseInt($(this).attr('data-prodcount'));
				});
				if(prodcount == 0) {
					pthis.remove();
				} else {
					pthis.children('a').append(' (' + prodcount + ')');
					pthis.children('a').attr('data-prodcount', prodcount);
				}
				$('.sl-item').each(function () {
					if(parseInt($(this).attr('data-id')) == parseInt(pthis.children('a').attr('data-id'))) {
						$(this).append(' (' + prodcount + ')');
						$(this).attr('data-prodcount', prodcount);
					}
				});
			});
			$('.sl-item').each(function () {
				if(parseInt($(this).attr('data-prodcount')) == 0) {
					$(this).parent().remove();
				}
			});
			$('#left-tab-1 li.sc2 a').each(function() {
				if(parseInt($(this).attr('data-prodcount')) == 0) {
					$(this).parent().remove();
				}
			});
			$('#left-tab-1 li.sc2').each(function() {
				$(this).removeAttr('style');
			});
		});
	</script>
<?}?>