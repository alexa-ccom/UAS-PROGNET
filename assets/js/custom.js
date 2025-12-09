
$(document).ready(function() {
    
    // $('.increment_btn').click(function(e){
    $(document).on('click', '.increment_btn', function(e) {

        e.preventDefault();

        var qty = $(this).closest('.product-data').find('.qty-input').val()

        var value = parseInt(qty, 10)
        value = isNaN(value) ? 0 : value;
        if(value < 10){
            value++;
            $(this).closest('.product-data').find('.qty-input').val(value)
        }
    });


    $(document).on('click', '.decrement_btn', function(e) {
        e.preventDefault();

        var qty = $(this).closest('.product-data').find('.qty-input').val()

        var value = parseInt(qty, 10)
        value = isNaN(value) ? 0 : value;
        if(value > 0){
            value--;
            $(this).closest('.product-data').find('.qty-input').val(value)
        }
    })

    $(document).on('click', '.add-to-cart', function(e) {

        e.preventDefault();

        var qty = $(this).closest('.product-data').find('.qty-input').val()
        var prod_id = $(this).val()


        $.ajax({
            method: "POST",
            url: "proses/proses-cart.php",
            data: {
                "id_produk": prod_id,
                "prod_qty": qty,
                "scope": "add"
            },
            dataType: 'json',
            success: function (response) {
                if (response.status == 201) {
                    showToast(response.message);
                } else {
                    showToast(response.message);
                }
            }
        });

    })

    $(document).on('click', '.updateQty', function() {

        var qty = $(this).closest('.product-data').find('.qty-input').val();
        var prod_id = $(this).closest('.product-data').find('.prodid').val();
        var cart_id = $(this).closest('.product-data').find('.cartid').val();

        $.ajax({
            method: "POST",
            url: "proses/proses-cart.php",
            data: {
                "id_cart": cart_id,
                "id_produk": prod_id,
                "prod_qty": qty,
                "scope": "update"
            },
            dataType: 'json',
            success: function (response) {
            }
        });

    });

    $(document).on('click', '.deleteItem', function() {
        
        var cart_id = $(this).val()


        $.ajax({
            method: "POST",
            url: "proses/proses-cart.php",
            data: {
                "id_cart": cart_id,
                "scope": "delete"
            },
            dataType: 'json',
            success: function (response) {
                if (response.status == 201) {
                    showToast(response.message);
                    $('#mycart').load(location.href + " #mycart")
                } else {
                    showToast(response.message);
                }
            }
        });

    })
})


function showToast(message) {

    $('#dynamic-toast').remove();
    
    var toastHTML = `
        <div id="dynamic-toast" 
            class="fixed bottom-6 right-6 z-50 flex items-center w-[320px] p-4 bg-green-100 text-green-700 rounded-lg shadow-lg transition-all duration-300 animate-slide-up">
            
            <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            
            <span class="text-sm font-medium">${message}</span>
            
            <button onclick="$('#dynamic-toast').fadeOut(300, function(){ $(this).remove(); })" 
                class="ml-auto hover:opacity-75 font-bold">
                ✕
            </button>
        </div>
    `;
    
    $('body').append(toastHTML);
    
    // Auto hide setelah 4 detik
    setTimeout(function() {
        $('#dynamic-toast').fadeOut(400, function() {
            $(this).remove();
        });
    }, 4000);
}