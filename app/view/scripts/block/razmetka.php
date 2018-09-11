<div style="position: absolute; top: -5000px; height: 1px; overflow: hidden;">

<script type="application/ld+json"> 
	{
		"@context": "https://schema.org",
		"@type": "HobbyShop",
		"name": "Дом Бусин",
		"address": {
			"@type": "PostalAddress",
			"streetAddress": "Молочная, 3",
			"addressLocality": "Харьков",   
			"addressRegion": "",   
			"postalCode": "61000"  
		},  
		"image": "https://www.dombusin.com/app/view/img/logo2.jpg",  
		"email": "office@dombusin.com", 
		"telePhone": "+38 (050) 760-40-98",  
		"url": "https://www.dombusin.com/",  
		"paymentAccepted": [ "cash", "credit card" ],  
		"openingHours": "Mo,Tu,We,Th,Fr,Sa,Su 00:00-23:59",  
		"geo": {   
			"@type": "GeoCoordinates",   
			"latitude": "49.983757",   
			"longitude": "36.258077"  
		},  
		"priceRange": "$" 
	} 
</script>

<div xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Organization">
    <span property="v:name" content="Интернет магазин Dombusin.com"></span>
    <div rel="v:address">
        <div typeof="v:Address">
            <span property="v:street-address" content="г. Харьков, ул. Молочная, 3"></span>
        </div>
    </div>
    <span property="v:tel" content="+38 (050) 760-40-98"></span>
    <span property="v:tel" content="+38 (068) 080-68-70"></span>
    <span property="v:tel" content="+38 (063) 473-10-64"></span>
    <span property="v:url" content="http://dombusin.com/"></span>
</div>

<?if($this->args[0] == 'catalog' && $this->cat && empty($this->prod)){
	$minprice = MAX_VALUE;
	$maxprice = 0;
	//print_r($this->prods);
	foreach($this->prods as $k => $v){
		if($v->price && $v->price < $minprice) $minprice = $v->price;
		if($v->price2 && $v->price2 < $minprice) $minprice = $v->price2;
		if($v->price3 && $v->price3 < $minprice) $minprice = $v->price3;
		if($v->price && $v->price > $maxprice) $maxprice = $v->price;
		if($v->price2 && $v->price2 > $maxprice) $maxprice = $v->price2;
		if($v->price3 && $v->price3 > $maxprice) $maxprice = $v->price3;
	}
	?>
<div itemscope itemtype="http://schema.org/Product">
	<p itemprop="Name"><?=$this->page->h1?></p>
	<div itemtype="http://schema.org/AggregateOffer" itemscope="" itemprop="offers">
	<meta content="<?=$this->cnt?>" itemprop="offerCount">
	<meta content="<?=Func::fmtmoney($maxprice)?>" itemprop="highPrice">
	<meta content="<?=Func::fmtmoney($minprice)?>" itemprop="lowPrice">
	<meta content="UAH" itemprop="priceCurrency">
	</div>
</div>
<?}?>
	
<?if($this->args[0] == 'catalog' && $this->prod){?>

<div itemscope itemtype="http://schema.org/Product">
<span itemprop="name"><?=$this->prod->name?></span>
<img src="/pic/prod/<?=$this->prod->id?>.jpg" />
 
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
<span itemprop="priceCurrency" content="UAH">грн.</span>
<span itemprop="price" content="<?=Func::fmtmoney($this->prod->price)?>"><?=Func::fmtmoney($this->prod->price)?></span>
<link itemprop="availability" href="http://schema.org/InStock" />
</div>
 
<span itemprop="description"><?=$this->page->descr?></span>

<?	if(!empty($this->comments)){?>
<div itemprop="review" itemscope itemtype="http://schema.org/Review">
<?		foreach($this->comments as $k => $v){?>
	<span itemprop="name">Отзыв</span>
	от <span itemprop="author"><?=$v->author?></span>,
	<meta itemprop="datePublished" content="<?=date("Y-m-d", $v->tstamp)?>">
	<span itemprop="description"><?=$v->cont?></span>
<?		}?>
</div>
<?	}?>
</div>
<?	}?>
	
<script type="application/ld+json">
{"@context": "https://schema.org", "@type": "BreadcrumbList", "itemListElement":
  [
<?	
	$i = 0;
	$cou = count($this->bc);

foreach($this->bc as $l => $t){?>
  {"@type": "ListItem", "position": <?=($i+1)?>, "item": {"@id": "<?=$l?>", "name": "<?=$t?>"}}<?if($i++ < $cou-1) echo ",\n";?>
<?	}?>
  ]
}
</script>

</div>