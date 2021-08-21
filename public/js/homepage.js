$(document).ready(() => {


    $('.add-to-wishlist').click(async function() {
        // e.preventDefault();
        let user = $('#user_id').val();
        let product = $(this).closest('.item-wrap').find('.item-info .item-id').html();

        let param = {
            user_id: user,
            product_id: product
        }

        console.log(param);

        const result = await addToWishlist(param);
        function addToWishlist(param) {
            return $.ajax({
                type: 'POST',
                data: param,
                url: '/user-product/add',
            });
        };
    });

    $('.add-to-cart').click(async function() {
        // e.preventDefault();
        let user = $('#user_id').val();
        let product = $(this).closest('.item-wrap').find('.item-info .item-id').html();
        let price = $(this).closest('.item-wrap').find('.item-info .item-price').html();
        let amount = 1;

        let param = {
            user_id: user,
            product_id: product,
            price: price,
            amount: amount
        }

        const result = await addToCart(param);
        function addToCart(param) {
            return $.ajax({
                type: 'POST',
                data: param,
                url: '/homepage/cart/add',
            });
        };
    });

    $('.add-to-order').click(async function() {
        // e.preventDefault();
        let user = $('#user_id').val();
        let product = $(this).closest('.item-wrap').find('.item-info .item-id').html();
        let price = $(this).closest('.item-wrap').find('.item-info .item-price').html();
        let amount = 1;

        let param = {
            user_id: user,
            product_id: product,
            price: price,
            amount: amount
        }

        const result = await addToCart(param);
        function addToCart(param) {
            return $.ajax({
                type: 'POST',
                data: param,
                url: '/homepage/cart/add',
            });
        };
    });
});
