@extends('layouts.frontend')

@section('title', 'Wishlist - Shoe Store')

@section('content')
    <!--== Start Page Header Area Wrapper ==-->
    <div class="page-header-area" data-bg-img="{{ asset('img/photos/bg3.webp') }}">
        <div class="container pt--0 pb--0">
            <div class="row">
                <div class="col-12">
                    <div class="page-header-content">
                        <h2 class="title" data-aos="fade-down" data-aos-duration="1000">Wishlist</h2>
                        <nav class="breadcrumb-area" data-aos="fade-down" data-aos-duration="1200">
                            <ul class="breadcrumb">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-sep">//</li>
                                <li>Wishlist</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Wishlist Area ==-->
    <section class="wishlist-area section-padding">
        <div class="container">
            @push('scripts')
            <script src="{{ asset('js/wishlist.js') }}"></script>
            @endpush
                        <div class="wishlist-header d-flex justify-content-between align-items-center">
