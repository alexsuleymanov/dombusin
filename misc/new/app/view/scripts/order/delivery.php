<?
$_GET["redirect"] = "/order/confirm";
echo $this->page->cont;
$city = 'Харків';
?>
<script>
    var schedule = {};
    function getSchedule() {
        $( "#delivery-np option:selected" ).each(function() {
            var val = $(this).val();
            var schedule_item = '<p>График работы отделения:</p>';
            schedule_item += '<p>Пн.: '+schedule[val].Monday+'</p>';
            schedule_item += '<p>Вт.: '+schedule[val].Tuesday+'</p>';
            schedule_item += '<p>Ср.: '+schedule[val].Wednesday+'</p>';
            schedule_item += '<p>Чт.: '+schedule[val].Thursday+'</p>';
            schedule_item += '<p>Пт.: '+schedule[val].Friday+'</p>';
            schedule_item += '<p>Сб.: '+schedule[val].Saturday+'</p>';
            schedule_item += '<p>Вс.: '+schedule[val].Sunday+'</p>';
            $('#delivery-np-cont').html(schedule_item);
        });
    }
    function npFind() {
        $.ajax({
            url: "https://api.novaposhta.ua/v2.0/json/",
            type: 'POST',
            dataType: 'jsonp',
            data: {
                "modelName": "AddressGeneral",
                "calledMethod": "getWarehouses",
                "methodProperties": {
                    "CityName": "<?=$city?>"
                },
                "apiKey": "fd0a716f9dae7783e905ec3c27d2662f"
            }
        }).done(function(data) {
            $('#delivery-np').html('');
            $('#delivery-np').unbind('change');
            $('#delivery-np').change(function() {
               getSchedule();
            });
            for (index = 0, len = data.data.length; index < len; ++index) {
                schedule[data.data[index].Number] = data.data[index].Schedule;
                $('#delivery-np').append('<option value="'+data.data[index].Number+'">'+data.data[index].DescriptionRu+'</option>');
            }
            getSchedule();
        });

    }
</script>

<h4>Личные данные</h4>
<div class="row order-row">
    <div class="col-sm-8">
        <div class="order-step"><span><span>1</span></span>&nbsp;&nbsp;<strong>Личная информация</strong> - <a href="<?=$this->url->mk('/order')?>" class="active">Редактировать</a></div>
        <div class="order-step-cont"></div>
        <div class="order-step active"><span><span>2</span></span>&nbsp;&nbsp;<strong>Информация о доставке</strong></div>
        <div class="order-step-cont active">
            <form method="POST" action="<?=$this->url->mk('/order/delivery')?>">
                <div class="row">
                    <div class="col-md-12 order-step-block">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <strong>Город</strong>
                            </div>
                            <div class="col-md-9">
                                <strong><?=$city?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 order-step-block">
                        <label for="delivery">Способ доставки</label>
                        <div class="radio">
                            <label><input type="radio" name="delivery" value="1" onchange="$('.delivery-type').hide(); $('#delivery-1').show(); npFind();">Новая почта</label>
                        </div>
                        <div id="delivery-1" class="order-info delivery-type">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <select name="" id="delivery-np" class="form-control">

                                    </select>
                                    <div id="delivery-np-cont"></div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-theme m-b-1 active focus pull-right">Далее</button>
                            <div class="clear"></div>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="delivery" value="2" onchange="$('.delivery-type').hide(); $('#delivery-2').show();">Укрпочта</label>
                        </div>
                        <div id="delivery-2" class="order-info delivery-type">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="city">Улица</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="street">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="city">Дом</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="house">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="city">Квартира</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="flat">
                                </div>
                            </div>
                            <button type="button" class="btn btn-theme m-b-1 active focus pull-right">Далее</button>
                            <div class="clear"></div>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="delivery" value="3" onchange="$('.delivery-type').hide(); $('#delivery-3').show();">Самовывоз</label>
                        </div>
                        <div id="delivery-3" class="order-info delivery-type">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="city">Адрес</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="address">
                                </div>
                            </div>
                            <button type="button" class="btn btn-theme m-b-1 active focus pull-right">Далее</button>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="order-step"><span><span>3</span></span>&nbsp;&nbsp;<strong>Информация об оплате</strong></div>
        <div class="order-step-cont"></div>
        <div class="order-step"><span><span>4</span></span>&nbsp;&nbsp;<strong>Спасибо за заказ</strong></div>
    </div>
    <div class="col-sm-4">
        <?=$this->render('order/block.php')?>
    </div>
</div>