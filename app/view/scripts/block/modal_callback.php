<div class="modal" id="modal_callback" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title"><i class=" icon-mail-2"></i> Заполните все поля и мы обязательно с Вами свяжемся </h4>
            </div>
            <div class="modal-body">
                <form id="order-callback" method="post" action="/callback">
                    <div class="form-group" id="callback-form-name">
                        <label for="recipient-name2" class="control-label">Имя:</label>
                        <input class="form-control" id="recipient-name2" placeholder="Ваше имя"
                               data-placement="top" data-trigger="manual"
                               data-content="Must be at least 3 characters long, and must only contain letters."
                               type="text" name="name">
                    </div>
                    <div class="form-group" id="callback-form-phone">
                        <label for="recipient-Phone-Number2" class="control-label">Телефон*:</label>
                        <input type="text" maxlength="60" class="form-control" id="recipient-Phone-Number2" placeholder="Ваш телефон" name="phone">
                    </div>
                    <div class="form-group">
                        <p class="pull-left text-danger hide" id="callback-form-error">&nbsp; Заполните все поля, отмеченные <strong>*</strong> </p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="sendclose2">Отмена</button>
                <input type="submit" class="btn btn-success pull-right" id="sendcallback" value="Отправить">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#sendcallback').click(function () {
            if ($('#callback-form-phone input').val() != '') {
                $.post("/callback", $("#order-callback").serialize());
                $('#modal_sent_button').click();
                $('#sendclose2').click();
            } else {
                $('#callback-form-error').removeClass('hide');
            }
        });
    });
</script>