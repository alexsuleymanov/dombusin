<div class="row">
    <?		foreach($this->articles as $k => $v){?>
        <div class="col-md-12">
            <div class="thumbnail blog-list">
                <div class="caption">
                    <h2><?=$v->name?></h2>
                    <small>
                        <span><i class="fa fa-clock-o"></i> <?echo date("d.m.Y", $v->tstamp);?></span>
                    </small>
                    <p><?=mb_substr(strip_tags($v->cont), 0, 200, "UTF-8")."...";?></p>
                    <div class="text-right"><a href="<?=$this->url->mkd(array(1, $v->intname))?>" class="btn btn-theme btn-sm"><i class="fa fa-long-arrow-right"></i> Читать</a></div>
                </div>
            </div>
        </div>
    <?		}?>
</div>
