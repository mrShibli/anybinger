<script>
    // all reusable javascript are here
    function addToCart(id) {
        const url = "{{ url('add-to-cart') }}/" + id;

        $.ajax({
            url: url,
            type: 'post',
            data: {},
            success: function(response) {
                if (response.status == true) {
                    Swal.fire({
                        icon: "success",
                        title: 'success',
                        text: response.message,
                        confirmButtonText: 'Go to Cart',
                        showCancelButton: true,
                        cancelButtonText: 'Cancel',
                        preConfirm: (() => {
                            window.location.href = "{{ route('cart') }}";
                        })
                    });
                    getCart();
                } else if(response.status == 'inCart') {
                    Swal.fire({
                        icon: "warning",
                        title: 'Warning',
                        text: response.message,
                        confirmButtonText: 'Go to cart',
                        showCancelButton: true,
                        cancelButtonText: 'Cancel',
                        preConfirm: (() => {
                            window.location.href = "{{ route('cart') }}";
                        })
                    });
                }else{
                    Swal.fire({
                        icon: "error",
                        title: 'Error',
                        text: response.error,
                        confirmButtonText: 'Confirm',
                        preConfirm: (() => {
                            window.location.reload();
                        })
                    });
                }
            },
            error: function(error) {
                Swal.fire({
                    icon: "error",
                    title: 'Error',
                    text: 'Something went wrong'
                });
            }
        })

    }

    function addToWishlist(id) {
        $.ajax({
            url: "{{ route('account.addToWishlist') }}",
            type: 'post',
            data: {
                id: id
            },
            success: function(response) {
                if (response.status == true) {
                    Swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'View wishlist',
                        showCancelButton: true,
                        cancelButtonText: 'Confirm',
                        preConfirm: (() => {
                            window.location.href = "{{ route('account.wishlists') }}"
                        })
                    });
                } else if (response.status == 'Unauthorized') {
                    Swal.fire({
                        title: 'Login Required',
                        text: "Login to save on wishlists",
                        icon: 'warning',
                        confirmButtonText: 'Login',
                        showCancelButton: true,
                        cancelButtonText: 'Cancel',
                        preConfirm: (() => {
                            window.location.href = "{{ route('login') }}"
                        })
                    });
                } else {
                    Swal.fire({
                        title: 'Warning',
                        text: response.errors,
                        icon: 'warning',
                        confirmButtonText: 'View wishlist',
                        showCancelButton: true,
                        cancelButtonText: 'Confirm',
                        preConfirm: (() => {
                            window.location.href = "{{ route('account.wishlists') }}"
                        })
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Something went wrong',
                    icon: 'error',
                    confirmButtonText: 'Confirm'
                });
            }
        })
    }
    
</script>