<?$prod = $this->prodone?>

<?if (Model_User::userid()) {?>
    <form action="/user/wishlist/add/<?= $prod->id ?>" method="post" id="wishform_<?= $prod->id ?>">
        <input type="hidden" name="id" value="<?= $prod->id ?>" />
        <input type="hidden" name="var" value="<?=$prodvar?>" class="prodvar<?=$prod->id?>"/>
        <input type="hidden" name="ajax" value="1" class="ajax" />
        <input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />
        &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="wishlist(<?= $prod->id ?>); return false;" class="awl"><img src="<?= $this->path ?>/img/add-wish-list.png" alt="" />&nbsp;В список желаний</a>
    </form>
<?}?>