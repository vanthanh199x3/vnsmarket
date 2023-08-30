<!-- Start Shop Newsletter  -->
<section class="shop-newsletter section">
    <div class="container">
        <div class="inner-top">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <!-- Start Newsletter Inner -->
                    <div class="inner">
                        <h4>{{ __('web.newsletter') }}</h4>
                        <p>{{ __('web.newsletter_title') }}</p>
                        <form id="formNewsletter" action="{{ route('subscribe') }}" method="post" class="newsletter-inner">
                            @csrf
                            <div class="input-group">
                                <input name="email" placeholder="{{ __('web.email') }}" required="" type="email">
                                <button class="btn submitNewsletter" type="submit">{{ __('web.register') }}</button>
                            </div>
                            <p class="mt-2 mb-0 result"></p>
                        </form>
                    </div>
                    <!-- End Newsletter Inner -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Shop Newsletter -->
@push('scripts')
<script>
    $("#formNewsletter").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
        },
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
    });

    // $('.submitNewsletter').click(function() {
    //     var _this = $(this);
    //     var email = $('#formNewsletter input[name="email"]').val().trim();
    //     $.ajax({
    //         url: "{{ route('subscribe') }}",
    //         type: "POST",
    //         data: {
    //             email: email,
    //         },
    //         beforeSend: function() {
    //             _this.prop('disabled'. true);
    //         }
    //         success:function(res) {
    //             if(res.status){
    //                 $('#formNewsletter .result').text(res.message)
    //             }
    //         }
    //     }).done(function() {
    //         _this.prop('disabled'. false);
    //     });
    // })
</script>
@endpush