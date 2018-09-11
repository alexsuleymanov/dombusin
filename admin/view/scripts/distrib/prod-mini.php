								<td align="center"> 
									<table cellpadding="0" cellspacing="0"> 
										<tr valign="top">
											<td class="prod_title"><a href="http://<?=$_SERVER['HTTP_HOST']?>/catalog/prod-<?=$this->prod->id?>"><?=$this->prod->name?></a></td>
										</tr> 
										<tr> 
											<td><a href="http://<?=$_SERVER['HTTP_HOST']?>/catalog/prod-<?=$this->prod->id?>"><img src="http://<?=$_SERVER['HTTP_HOST']?>/thumb?src=pic/prod/<?=$this->prod->id?>.jpg&width=150&height=150" width="150" height="150" alt="" /></a></td>
										</tr>
										<tr>
											<td class="prod_price"><?=Func::fmtmoney($this->prod->price)." ".$this->sett["valuta"]?></td>
										</tr>
									</table>
								</td>

