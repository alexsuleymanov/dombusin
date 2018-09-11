<?=$this->page->cont?>
<div class="col-sm-5">
    <?=$this->form?>
    <br class="ce-wide">
    <div class="clear"></div>
</div>
<div class="col-sm-1 blo-1">
    <div style="position: absolute; left: 5px; top: 70px; background: #fff;">или</div>
    <div style="height: 590px; border-right: 1px solid #ddd; width: 1px; margin: 2em 0 0;"></div>
</div>
<div class="col-sm-6">
	<div class="reg-auth--soc">
        <h5>Войти через социальные сети</h5>
        <div class="soc-list__btns">
            <?=$this->render('block/facebook/login-reg.php')?>
            <?=$this->render('block/google/login-reg.php')?>
            <!--<a id="bx_socserv_icon_Odnoklassniki" class="soc-link soc-link__odn" href="javascript:void(0)" onclick="BX.util.popup('http://www.odnoklassniki.ru/oauth/authorize?client_id=1247895808&amp;redirect_uri=http%3A%2F%2F195.201.119.102%2Fbitrix%2Ftools%2Foauth%2Fodnoklassniki.php&amp;response_type=code&amp;state=site_id%3Ds1%26backurl%3D%252Flogin%252Findex.php%253Fcheck_key%253Dea72e54efbfed98b813d9bd0d25f2ebb%2526register%253Dyes%26redirect_url%3D%252Flogin%252Findex.php%26mode%3Dopener', 580, 400)">
                <span class="s-icon"><i class="icon-st__odn"></i></span>
                <span class="s-text">Одноклассники</span>
            </a>
            <a id="bx_socserv_icon_VKontakte" class="soc-link soc-link__vk" href="javascript:void(0)" onclick="BX.util.popup('https://oauth.vk.com/authorize?client_id=6334308&amp;redirect_uri=http%3A%2F%2F195.201.119.102%2Flogin%2Findex.php%3Fauth_service_id%3DVKontakte&amp;scope=friends,offline,email&amp;response_type=code&amp;state=site_id%3Ds1%26backurl%3D%252Flogin%252Findex.php%253Fcheck_key%253Dea72e54efbfed98b813d9bd0d25f2ebb%2526register%253Dyes%26redirect_url%3D%252Flogin%252Findex.php', 660, 425)">
                <span class="s-icon"><i class="icon-st__vk"></i></span>
                <span class="s-text">Вконтакте</span>
            </a>
            <a id="bx_socserv_icon_Facebook" class="soc-link soc-link__fb" href="javascript:void(0)" onclick="BX.util.popup('https://www.facebook.com/dialog/oauth?client_id=1593657530927850&amp;redirect_uri=http%3A%2F%2F195.201.119.102%2Flogin%2Findex.php%3Fauth_service_id%3DFacebook%26check_key%3Dea72e54efbfed98b813d9bd0d25f2ebb%26register%3Dyes%26backurl%3D%252Flogin%252Findex.php&amp;scope=email,publish_actions,user_friends&amp;display=popup', 680, 600)">
                <span class="s-icon"><i class="icon-st__fb"></i></span>
                <span class="s-text">Facebook</span>
            </a>
            <a id="bx_socserv_icon_GoogleOAuth" class="soc-link soc-link__gp" href="javascript:void(0)" onclick="BX.util.popup('https://accounts.google.com/o/oauth2/auth?client_id=875975321197-0mnr4tc3ktl995bhjg7tijrg7gje8s9i.apps.googleusercontent.com&amp;redirect_uri=http%3A%2F%2F195.201.119.102%2Fbitrix%2Ftools%2Foauth%2Fgoogle.php&amp;scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile&amp;response_type=code&amp;access_type=offline&amp;state=provider%3DGoogleOAuth%26site_id%3Ds1%26backurl%3D%252Flogin%252Findex.php%253Fcheck_key%253Dea72e54efbfed98b813d9bd0d25f2ebb%2526register%253Dyes%26mode%3Dopener%26redirect_url%3D%252Flogin%252Findex.php', 580, 400)">
                <span class="s-icon"><i class="icon-st__gp"></i></span>
                <span class="s-text">Google+</span>
            </a>
            -->
        </div>

        <div class="reg-auth--soc--text">
            <p>Входя как пользователь социальной сети вы принимаете <a href="/polzovatelskoe-soglashenie">пользовательское соглашение</a> и политику конфиденциальности магазина.</p>
			<p>Если у вас уже есть учетная запись магазина, вы можете привязать к ней социальные сети в личном кабинете.</p>
        </div>
    </div>
</div>
<br class="ce-wide">
<div class="clear">&nbsp;</div>
