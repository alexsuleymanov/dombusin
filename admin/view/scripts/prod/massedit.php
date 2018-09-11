<?
	$cats = array();
	$Cat = new Model_Cat();
	$rc = $Cat->getall(array("order" => "name"));
	foreach($rc as $k => $v){
		$cats['items'][] = array("id" => $v->id, "par" => $v->cat, "name" => $v->name);
	}

?>

<div id="mn">
	<form action="?mass_edit=1" method="post" id="masseditform">
    <span>Редактируемые опции товаров в формате пакетного редактирования</span>
    <br/>
    <span id="mess" style="background:green;color:white;"></span>
    <br/>
    <table>
        <tr>
            <td>
				<div style="border: 1px solid #999999; background-color: #ffffff; overflow: auto; height: 100px; width: 250px; padding: 10px;">
<?
				function draw_tree($k, $tree, $rel, $par){
					echo "<ul style=\"padding-left: 20px;\">";
					foreach($tree as $kk => $item){
						if($item['par'] == $par){
							unset($tree[$kk]);
							echo "<li><input type=\"checkbox\" name=\"".$k."[]\" value=\"".$item['id']."\"";
							echo ">";
							echo $item['name'];
							draw_tree($k, $tree, $rel, $item['id']);
							echo "</li>";
						}
					}
					echo "</ul>";
				}

				$rel = array();

				$tree = $cats['items'];
				draw_tree('cats', $tree, $rel, 0);?>
				</div>
            </td>
            <td><input type="checkbox" name="onsite" id="onsite">Отображать на сайте</td>
            <td><input type="checkbox" name="onnew" id="onnew">Отображать в новых товарах</td>
            <td><input type="checkbox" name="ontop" id="ontop">Отображать в топе продаж</td>      
            <!--<td><input type="checkbox" id="onnewm">Отображать в новинках(главная)</td>-->
        </tr>
        <tr>
            <td>
                <select name="skidka" id="skidka">
                    <option value="-1">Скидка</option>
                    <option value="0">0%</option>
                    <option value="5">5%</option>
                    <option value="10">10%</option>
                    <option value="15">15%</option>
                    <option value="20">20%</option>
                    <option value="25">25%</option>
                    <option value="30">30%</option>
                    <option value="35">35%</option>
                    <option value="40">40%</option>
                    <option value="45">45%</option>
                    <option value="50">50%</option>
                    <option value="55">55%</option>
                    <option value="60">60%</option>
                    <option value="65">65%</option>
                    <option value="70">70%</option>
                </select>
            </td>

            <td><input type="checkbox" name="offsite" id="offsite"><b style="color:red">НЕ</b>Отображать на сайте</td>
            <td><input type="checkbox" name="offnew" id="offnew"><b style="color:red">НЕ</b>Отображать в новых товарах</td>
            <td><input type="checkbox" name="offtop" id="offtop"><b style="color:red">НЕ</b>Отображать в топе продаж</td>
            <td></td>
            <td><input type="button" id="sbmt" value="Применить" /></td>
        </tr>    
    </table>
	</form>
</div>

<script>
	$('#sbmt').click(function(){
		var q1 = $("#masseditform").serialize();
		var q = new String("");
		var index = q;
		$(".inpcheck").each(function(q){
			if($(this).attr("checked"))
				index = index.concat("&prod%5B%5D=" + $(this).attr("id"));
		});
		q = q1 + index;
		$.post("/admin/adm_prod.php?mass_edit=1", q, function(data){
			alert(data);
			location.reload();
		});
	});

    $('#cats').click(function() {
        $(this).css('height','150px');
    });
//alert($('#masseditform').serialize());
/// get catlist
/// check/uncheck all
// fuck this!!!!!!!!!
function checkAll() {
     var checkboxes = new Array();
     checkboxes = document.getElementsByName('pro');

     for (var i = 0; i < checkboxes.length; i++) {
         if (checkboxes[i].type === 'checkbox') {
             var id = checkboxes[i].id;
             if ($('#'+id).attr('checked')) {
             document.getElementById(id).removeAttribute('checked');    
             } else {
             checkboxes[i].setAttribute('checked', true);
             }
         }
     }
 }

</script>
<style>
    #mn {
		background: gainsboro;
		padding: 10px;
		font-size: 16px;
		text-align: center;
	}
	#mn table {
    	margin-top: 10px;
	}
	#mn span {
    	text-shadow: 1px 1px white;
	}
	#mn table tr td {
    	padding: 5px;
	}
</style>
        