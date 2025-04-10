jQuery(document).ready(function ($) {
    $(document).on('click', '#make_as_paid', function (e) {
        e.preventDefault();
        var paymentId = $(this).data('payment-id');
        var paymentStatus = $(this).data('payment-status');
        var transaction_id = $('#TB_ajaxContent').find('#transaction_id').val();
        var transaction_amount = $('#TB_ajaxContent').find('#transaction_amount').val();
        var transaction_msg = $('#TB_ajaxContent').find('#transaction_msg').val();
        var order_id = $('#TB_ajaxContent').find('input[name=order_id]').val();
        var product_id = $('#TB_ajaxContent').find('input[name=product_id]').val();
        var seller_id = $('#TB_ajaxContent').find('input[name=seller_id]').val();
        var payment_method = $('#TB_ajaxContent').find('input[name=payment_method]').val();
        var transaction_type = $('#TB_ajaxContent').find('input[name=transaction_type]').val();
        var admin_commission = $('#TB_ajaxContent').find('input[name=admin_commission]').val();
        if (order_id) {
            $.ajax({
                type: 'POST',
                url: sellerAdminOrderData.ajax_url,
                data: {
                    action: 'seller_product_payment',
                    order_id: order_id,
                    product_id: product_id,
                    payment_id: paymentId,
                    transaction_id: transaction_id,
                    transaction_amount: transaction_amount,
                    transaction_msg: transaction_msg,
                    payment_status: paymentStatus,
                    seller_id: seller_id,
                    payment_method: payment_method,
                    transaction_type: transaction_type,
                    admin_commission: admin_commission,
                },
                success: function (response) {
                    $('#TB_ajaxContent').find('#payment-details-container').show();
                    $('#TB_ajaxContent').find('#payment-details-container').html(response);
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                },
            });
        }
    });
});

