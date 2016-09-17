/**
 * Created by jennifernodwell on 9/17/16.
 */
$(function () {

    $('#prime_form').on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            var url = "get_primes.php";

            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize(),
                success: function (data)
                {
                    var messageAlert = 'alert-' + data.type;
                    var messageText = data.message;

                    var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><div><p>' + messageText + '</p></div></div>';
                    if (messageAlert && messageText) {
                        $('#prime_form').find('.messages').html(alertBox);
                        $('#prime_form')[0].reset();
                    }
                }
            });
            return false;
        }
    })
});