@extends('layouts.landing_master')

@section('title', 'Term and Conditions')

@push('style')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap-extended.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/colors.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/components.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/horizontal-menu.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/page-faq.css')}}">
<!--====== Style CSS ======-->
<style>
    .primary-background {
        background: #877DF2;
    }

    @media (max-width:1199px) {
        .app-content {
            margin-top: 90px !important
        }
    }
</style>
@endpush

@section('content')
<div class="horizontal-layout horizontal-menu  navbar-floating footer-static  " data-open="hover" data-menu="horizontal-menu" data-col="">
    <div class="app-content content mb-3">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">

            <div class="content-body">
                <!-- frequently asked questions tabs pills -->
                <section id="faq-tabs">
                    <!-- vertical tab pill -->
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-12">
                            <div class="faq-navigation d-flex justify-content-between flex-column mb-2 mb-md-0">
                                <!-- pill tabs navigation -->
                                <ul class="nav nav-pills nav-left flex-column" role="tablist">
                                    <!-- payment -->
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#terms-download" aria-expanded="true" role="tab">
                                            <i class="fas fa-download fa-fw" class="font-medium-3 mr-1"></i>
                                            <span class="font-weight-bold">Download</span>
                                        </a>
                                    </li>

                                    <!-- delivery -->
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#terms-referral" aria-expanded="false" role="tab">
                                            <i class="fas fa-user-friends fa-fw" class="font-medium-3 mr-1"></i>
                                            <span class="font-weight-bold">Referral</span>
                                        </a>
                                    </li>

                                    <!-- cancellation and return -->
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#terms-withdrawal" aria-expanded="false" role="tab">
                                            <i class="fas fa-dollar-sign fa-fw" class="font-medium-3 mr-1"></i>
                                            <span class="font-weight-bold">Withdrawal</span>
                                        </a>
                                    </li>
                                </ul>

                                <!-- FAQ image -->
                                <img src="{{asset('app-assets/images/illustration/faq-illustrations.svg')}}" class="img-fluid d-none d-md-block" alt="demand img" />
                            </div>
                        </div>

                        <div class="col-lg-9 col-md-8 col-sm-12">
                            <!-- pill tabs tab content -->
                            <div class="tab-content">
                                <!-- payment panel -->
                                <div role="tabpanel" class="tab-pane active" id="terms-download" aria-labelledby="payment" aria-expanded="true">
                                    <!-- icon and header -->
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-tag bg-light-primary mr-1">
                                            <i class="fas fa-download fa-fw" class="font-medium-4"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0">Download</h4>
                                            <span>Which license do I need?</span>
                                        </div>
                                    </div>

                                    <!-- frequent answer and question  collapse  -->
                                    <div class="collapse-margin collapse-icon mt-2" id="faq-payment-qna">
                                        <div class="card">
                                            <div class="card-header" id="paymentOne" data-toggle="collapse" role="button" data-target="#faq-payment-one" aria-expanded="false" aria-controls="faq-payment-one">
                                                <span class="lead collapse-title">Does my subscription automatically renew?</span>
                                            </div>

                                            <div id="faq-payment-one" class="collapse show" aria-labelledby="paymentOne" data-parent="#faq-payment-qna">
                                                <div class="card-body">
                                                    Pastry pudding cookie toffee bonbon jujubes jujubes powder topping. Jelly beans gummi bears sweet roll
                                                    bonbon muffin liquorice. Wafer lollipop sesame snaps. Brownie macaroon cookie muffin cupcake candy
                                                    caramels tiramisu. Oat cake chocolate cake sweet jelly-o brownie biscuit marzipan. Jujubes donut
                                                    marzipan chocolate bar. Jujubes sugar plum jelly beans tiramisu icing cheesecake.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="paymentTwo" data-toggle="collapse" role="button" data-target="#faq-payment-two" aria-expanded="true" aria-controls="faq-payment-two">
                                                <span class="lead collapse-title">Can I store the item on an intranet so everyone has access?</span>
                                            </div>
                                            <div id="faq-payment-two" class="collapse" aria-labelledby="paymentTwo" data-parent="#faq-payment-qna">
                                                <div class="card-body">
                                                    Sweet pie candy jelly. Sesame snaps biscuit sugar plum. Sweet roll topping fruitcake. Caramels
                                                    liquorice biscuit ice cream fruitcake cotton candy tart. Donut caramels gingerbread jelly-o
                                                    gingerbread pudding. Gummi bears pastry marshmallow candy canes pie. Pie apple pie carrot cake.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="paymentThree" data-toggle="collapse" role="button" data-target="#faq-payment-three" aria-expanded="false" aria-controls="faq-payment-three">
                                                <span class="lead collapse-title">What does non-exclusive mean?</span>
                                            </div>
                                            <div id="faq-payment-three" class="collapse" aria-labelledby="paymentThree" data-parent="#faq-payment-qna">
                                                <div class="card-body">
                                                    Tart gummies dragée lollipop fruitcake pastry oat cake. Cookie jelly jelly macaroon icing jelly beans
                                                    soufflé cake sweet. Macaroon sesame snaps cheesecake tart cake sugar plum. Dessert jelly-o sweet
                                                    muffin chocolate candy pie tootsie roll marzipan.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="paymentFour" data-toggle="collapse" role="button" data-target="#faq-payment-four" aria-expanded="false" aria-controls="faq-payment-four">
                                                <span class="lead collapse-title">Is the Regular License the same thing as an editorial license?</span>
                                            </div>
                                            <div id="faq-payment-four" class="collapse" aria-labelledby="paymentFour" data-parent="#faq-payment-qna">
                                                <div class="card-body">
                                                    Cheesecake muffin cupcake dragée lemon drops tiramisu cake gummies chocolate cake. Marshmallow tart
                                                    croissant. Tart dessert tiramisu marzipan lollipop lemon drops. Cake bonbon bonbon gummi bears topping
                                                    jelly beans brownie jujubes muffin. Donut croissant jelly-o cake marzipan. Liquorice marzipan cookie
                                                    wafer tootsie roll. Tootsie roll sweet cupcake.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="paymentFive" data-toggle="collapse" role="button" data-target="#faq-payment-five" aria-expanded="false" aria-controls="faq-payment-five">
                                                <span class="lead collapse-title">
                                                    Which license do I need for an end product that is only accessible to paying users?
                                                </span>
                                            </div>
                                            <div id="faq-payment-five" class="collapse" aria-labelledby="paymentFive" data-parent="#faq-payment-qna">
                                                <div class="card-body">
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                                                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                                    aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                                                    dolore eu fugiat nulla pariatur.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="paymentSix" data-toggle="collapse" role="button" data-target="#faq-payment-six" aria-expanded="false" aria-controls="faq-payment-six">
                                                <span class="lead collapse-title">Which license do I need to use an item in a commercial?</span>
                                            </div>
                                            <div id="faq-payment-six" class="collapse" aria-labelledby="paymentSix" data-parent="#faq-payment-qna">
                                                <div class="card-body">
                                                    At tempor commodo ullamcorper a lacus vestibulum. Ultrices neque ornare aenean euismod. Dui vivamus
                                                    arcu felis bibendum. Turpis in eu mi bibendum neque egestas congue. Nullam ac tortor vitae purus
                                                    faucibus ornare suspendisse sed.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="paymentSeven" data-toggle="collapse" role="button" data-target="#faq-payment-seven" aria-expanded="false" aria-controls="faq-payment-seven">
                                                <span class="lead collapse-title">
                                                    Can I re-distribute an item? What about under an Extended License?
                                                </span>
                                            </div>
                                            <div id="faq-payment-seven" class="collapse" aria-labelledby="paymentSeven" data-parent="#faq-payment-qna">
                                                <div class="card-body">
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                                                    dolore magna aliqua. Euismod lacinia at quis risus sed vulputate odio ut enim. Dictum at tempor
                                                    commodo ullamcorper a lacus vestibulum.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- delivery panel -->
                                <div class="tab-pane" id="terms-referral" role="tabpanel" aria-labelledby="delivery" aria-expanded="false">
                                    <!-- icon and header -->
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-tag bg-light-primary mr-1">
                                            <i class="fas fa-user-friends fa-fw" class="font-medium-4"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0">Referral</h4>
                                            <span>Which license do I need?</span>
                                        </div>
                                    </div>

                                    <!-- frequent answer and question  collapse  -->
                                    <div class="collapse-margin collapse-icon mt-2" id="faq-delivery-qna">
                                        <div class="card">
                                            <div class="card-header" id="deliveryOne" data-toggle="collapse" role="button" data-target="#faq-delivery-one" aria-expanded="false" aria-controls="faq-delivery-one">
                                                <span class="lead collapse-title">Where has my order reached?</span>
                                            </div>

                                            <div id="faq-delivery-one" class="collapse" aria-labelledby="deliveryOne" data-parent="#faq-delivery-qna">
                                                <div class="card-body">
                                                    Pastry pudding cookie toffee bonbon jujubes jujubes powder topping. Jelly beans gummi bears sweet roll
                                                    bonbon muffin liquorice. Wafer lollipop sesame snaps. Brownie macaroon cookie muffin cupcake candy
                                                    caramels tiramisu. Oat cake chocolate cake sweet jelly-o brownie biscuit marzipan. Jujubes donut
                                                    marzipan chocolate bar. Jujubes sugar plum jelly beans tiramisu icing cheesecake.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="deliveryTwo" data-toggle="collapse" role="button" data-target="#faq-delivery-two" aria-expanded="false" aria-controls="faq-delivery-two">
                                                <span class="lead collapse-title">
                                                    The shipment status shows that it has been returned/cancelled. What does it mean and who do I contact?
                                                </span>
                                            </div>
                                            <div id="faq-delivery-two" class="collapse" aria-labelledby="deliveryTwo" data-parent="#faq-delivery-qna">
                                                <div class="card-body">
                                                    Sweet pie candy jelly. Sesame snaps biscuit sugar plum. Sweet roll topping fruitcake. Caramels
                                                    liquorice biscuit ice cream fruitcake cotton candy tart. Donut caramels gingerbread jelly-o
                                                    gingerbread pudding. Gummi bears pastry marshmallow candy canes pie. Pie apple pie carrot cake.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="deliveryThree" data-toggle="collapse" role="button" data-target="#faq-delivery-three" aria-expanded="false" aria-controls="faq-delivery-three">
                                                <span class="lead collapse-title">What if my shipment is marked as lost?</span>
                                            </div>
                                            <div id="faq-delivery-three" class="collapse" aria-labelledby="deliveryThree" data-parent="#faq-delivery-qna">
                                                <div class="card-body">
                                                    Tart gummies dragée lollipop fruitcake pastry oat cake. Cookie jelly jelly macaroon icing jelly beans
                                                    soufflé cake sweet. Macaroon sesame snaps cheesecake tart cake sugar plum. Dessert jelly-o sweet
                                                    muffin chocolate candy pie tootsie roll marzipan. Carrot cake marshmallow pastry. Bonbon biscuit
                                                    pastry topping toffee dessert gummies. Topping apple pie pie croissant cotton candy dessert tiramisu.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="deliveryFour" data-toggle="collapse" role="button" data-target="#faq-delivery-four" aria-expanded="false" aria-controls="faq-delivery-four">
                                                <span class="lead collapse-title">
                                                    My shipment status shows that it’s out for delivery. By when will I receive it?
                                                </span>
                                            </div>
                                            <div id="faq-delivery-four" class="collapse" aria-labelledby="deliveryFour" data-parent="#faq-delivery-qna">
                                                <div class="card-body">
                                                    Cheesecake muffin cupcake dragée lemon drops tiramisu cake gummies chocolate cake. Marshmallow tart
                                                    croissant. Tart dessert tiramisu marzipan lollipop lemon drops. Cake bonbon bonbon gummi bears topping
                                                    jelly beans brownie jujubes muffin. Donut croissant jelly-o cake marzipan. Liquorice marzipan cookie
                                                    wafer tootsie roll. Tootsie roll sweet cupcake.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="deliveryFive" data-toggle="collapse" role="button" data-target="#faq-delivery-five" aria-expanded="false" aria-controls="faq-delivery-five">
                                                <span class="lead collapse-title">
                                                    What do I need to do to get the shipment delivered within a specific timeframe?
                                                </span>
                                            </div>
                                            <div id="faq-delivery-five" class="collapse" aria-labelledby="deliveryFive" data-parent="#faq-delivery-qna">
                                                <div class="card-body">
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                                                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                                    aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                                                    dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                                                    officia deserunt mollit anim id est laborum.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- cancellation return  -->
                                <div class="tab-pane" id="terms-withdrawal" role="tabpanel" aria-labelledby="cancellation-return" aria-expanded="false">
                                    <!-- icon and header -->
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-tag bg-light-primary mr-1">
                                            <i class="fas fa-dollar-sign fa-fw" class="font-medium-4"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-0">Withdrawal</h4>
                                            <span>Which license do I need?</span>
                                        </div>
                                    </div>

                                    <!-- frequent answer and question  collapse  -->
                                    <div class="collapse-margin collapse-icon mt-2" id="faq-cancellation-qna">
                                        <div class="card">
                                            <div class="card-header" id="cancellationOne" data-toggle="collapse" role="button" data-target="#faq-cancellation-one" aria-expanded="false" aria-controls="faq-cancellation-one">
                                                <span class="lead collapse-title">
                                                    Can my security guard or neighbour receive my shipment if I am not available?
                                                </span>
                                            </div>

                                            <div id="faq-cancellation-one" class="collapse" aria-labelledby="cancellationOne" data-parent="#faq-cancellation-qna">
                                                <div class="card-body">
                                                    Pastry pudding cookie toffee bonbon jujubes jujubes powder topping. Jelly beans gummi bears sweet roll
                                                    bonbon muffin liquorice. Wafer lollipop sesame snaps. Brownie macaroon cookie muffin cupcake candy
                                                    caramels tiramisu. Oat cake chocolate cake sweet jelly-o brownie biscuit marzipan. Jujubes donut
                                                    marzipan chocolate bar. Jujubes sugar plum jelly beans tiramisu icing cheesecake.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="cancellationTwo" data-toggle="collapse" role="button" data-target="#faq-cancellation-two" aria-expanded="false" aria-controls="faq-cancellation-two">
                                                <span class="lead collapse-title">How can I get the contact number of my delivery agent?</span>
                                            </div>
                                            <div id="faq-cancellation-two" class="collapse" aria-labelledby="cancellationTwo" data-parent="#faq-cancellation-qna">
                                                <div class="card-body">
                                                    Sweet pie candy jelly. Sesame snaps biscuit sugar plum. Sweet roll topping fruitcake. Caramels
                                                    liquorice biscuit ice cream fruitcake cotton candy tart. Donut caramels gingerbread jelly-o
                                                    gingerbread pudding. Gummi bears pastry marshmallow candy canes pie. Pie apple pie carrot cake.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="cancellationThree" data-toggle="collapse" role="button" data-target="#faq-cancellation-three" aria-expanded="false" aria-controls="faq-cancellation-three">
                                                <span class="lead collapse-title">How can I cancel my shipment?</span>
                                            </div>
                                            <div id="faq-cancellation-three" class="collapse" aria-labelledby="cancellationThree" data-parent="#faq-cancellation-qna">
                                                <div class="card-body">
                                                    Tart gummies dragée lollipop fruitcake pastry oat cake. Cookie jelly jelly macaroon icing jelly beans
                                                    soufflé cake sweet. Macaroon sesame snaps cheesecake tart cake sugar plum. Dessert jelly-o sweet
                                                    muffin chocolate candy pie tootsie roll marzipan. Carrot cake marshmallow pastry. Bonbon biscuit
                                                    pastry topping toffee dessert gummies. Topping apple pie pie croissant cotton candy dessert tiramisu.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="cancellationFour" data-toggle="collapse" role="button" data-target="#faq-cancellation-four" aria-expanded="false" aria-controls="faq-cancellation-four">
                                                <span class="lead collapse-title">I have received a defective/damaged product. What do I do?</span>
                                            </div>
                                            <div id="faq-cancellation-four" class="collapse" aria-labelledby="cancellationFour" data-parent="#faq-cancellation-qna">
                                                <div class="card-body">
                                                    Cheesecake muffin cupcake dragée lemon drops tiramisu cake gummies chocolate cake. Marshmallow tart
                                                    croissant. Tart dessert tiramisu marzipan lollipop lemon drops. Cake bonbon bonbon gummi bears topping
                                                    jelly beans brownie jujubes muffin. Donut croissant jelly-o cake marzipan. Liquorice marzipan cookie
                                                    wafer tootsie roll. Tootsie roll sweet cupcake.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="cancellationFive" data-toggle="collapse" role="button" data-target="#faq-cancellation-five" aria-expanded="false" aria-controls="faq-cancellation-five">
                                                <span class="lead collapse-title">How do I change my delivery address?</span>
                                            </div>
                                            <div id="faq-cancellation-five" class="collapse" aria-labelledby="cancellationFive" data-parent="#faq-cancellation-qna">
                                                <div class="card-body">
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                                                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                                    aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                                                    dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                                                    officia deserunt mollit anim id est laborum.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="cancellationSix" data-toggle="collapse" role="button" data-target="#faq-cancellation-six" aria-expanded="false" aria-controls="faq-cancellation-six">
                                                <span class="lead collapse-title">
                                                    What documents do I need to carry for self-collection of my shipment?
                                                </span>
                                            </div>
                                            <div id="faq-cancellation-six" class="collapse" aria-labelledby="cancellationSix" data-parent="#faq-cancellation-qna">
                                                <div class="card-body">
                                                    At tempor commodo ullamcorper a lacus vestibulum. Ultrices neque ornare aenean euismod. Dui vivamus
                                                    arcu felis bibendum. Turpis in eu mi bibendum neque egestas congue. Nullam ac tortor vitae purus
                                                    faucibus ornare suspendisse sed. Commodo viverra maecenas accumsan lacus vel facilisis volutpat est
                                                    velit. Tortor consequat id porta nibh. Id aliquet lectus proin nibh nisl condimentum id venenatis a.
                                                    Faucibus nisl tincidunt eget nullam non nisi. Enim nunc faucibus a pellentesque. Pellentesque diam
                                                    volutpat commodo sed egestas egestas fringilla phasellus. Nec nam aliquam sem et tortor consequat id.
                                                    Fringilla est ullamcorper eget nulla facilisi. Morbi tristique senectus et netus et.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="cancellationSeven" data-toggle="collapse" role="button" data-target="#faq-cancellation-seven" aria-expanded="false" aria-controls="faq-cancellation-seven">
                                                <span class="lead collapse-title">
                                                    What are the timings for self-collecting shipments from the Delhivery Branch?
                                                </span>
                                            </div>
                                            <div id="faq-cancellation-seven" class="collapse" aria-labelledby="cancellationSeven" data-parent="#faq-cancellation-qna">
                                                <div class="card-body">
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                                                    dolore magna aliqua. Euismod lacinia at quis risus sed vulputate odio ut enim. Dictum at tempor
                                                    commodo ullamcorper a lacus vestibulum.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
                <!-- / frequently asked questions tabs pills -->

            </div>
        </div>
    </div>
</div>

@endsection

@push('script')

@endpush