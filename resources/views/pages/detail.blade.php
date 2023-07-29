@extends('layouts.app')

@section('title')
    Detail
@endsection

@push('addon-style')
    <style>
        .review {
            margin-bottom: 20px;
        }

        .rating {
            display: inline-block;
        }

        .rating input {
            display: none;
        }

        .rating label {
            display: inline-block;
            cursor: pointer;
            color: #ccc;
        }

        .rating label:before {
            content: '\2605';
            font-size: 24px;
        }

        .rating.reverse-1 {
            direction: rtl;
        }

        .rating.reverse-2 {
            direction: rtl;
        }

        .rating.reverse-3 {
            direction: rtl;
        }

        .rating.reverse-4 {
            direction: rtl;
        }

        .rating.reverse-5 {
            direction: rtl;
        }

        .rating input:checked~label {
            color: #f90;
        }

        .rating label:hover,
        .rating label:hover~label {
            color: #f90;
        }
    </style>
@endpush

@section('content')
    <div class="page-content page-details">
        <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">Beranda</a>
                                </li>
                                <li class="breadcrumb-item">
                                    {{ $product->name }}
                                </li>
                                <li class="breadcrumb-item active">
                                    Detail Produk
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section class="store-gallery mb-3" id="gallery">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8" data-aos="zoom-in">
                        <transition name="slide-fade" mode="out-in">
                            <img :src="photos[activePhoto].url" :key="photos[activePhoto].id" class="w-100 main-image"
                                alt="">
                        </transition>
                    </div>
                    <div class="col-lg-2">
                        <div class="row">
                            <div class="col-3 col-lg-12 mt-2 mt-lg-0" v-for="(photo, index) in photos"
                                :key="photo.id" data-aos="zoom-in" data-aos-delay="100">
                                <a href="#" @click="changeActive(index)">
                                    <img :src="photo.url" class="w-100 thumbnail-image"
                                        :class="{ active: index == activePhoto }" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="store-details-container" data-aos="fade-up">
            <section class="store-heading">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <h1>{{ $product->name }}</h1>
                            <div class="price">
                                Rp. {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-lg-2" data-aos="zoom-in">
                            @auth
                                @if (Auth::user()->roles == 'USER')
                                    <form action="{{ route('detail-add', $product->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <button type="submit" class="btn btn-store px-4 text-white btn-block mb-3">
                                            + Keranjang
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-store px-4 text-white btn-block mb-3">
                                    Sign In
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </section>
            <section class="store-description">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>
            </section>
            <section class="store-review">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-8 mt-3 mb-3">
                            <h5>Review &amp; Komentar ({{ count($reviews) }})</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <ul class="list-unstyled">
                                @foreach ($reviews as $review)
                                    <li class="media">
                                        @if ($review->user->photo)
                                            <img src="{{ Storage::url($review->user->photo) }}" alt="Testimonial 1"
                                                class="mr-3 rounded-circle">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ $review->user->roles == 'ADMIN' ? 'Admin' : 'User' }}"
                                                class="mr-3 rounded-circle">
                                        @endif
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-0">{{ $review->user->name }}</h5>
                                            <div class="rating reverse-{{ $review->rating }}">
                                                @for ($i = 5; $i >= 1; $i--)
                                                    <input type="radio" id="star{{ $i }}-{{ $review->id }}"
                                                        name="rating_{{ $review->id }}" value="{{ $i }}"
                                                        {{ $review->rating == $i ? 'checked disabled' : 'disabled' }}>
                                                    <label for="star{{ $i }}-{{ $review->id }}"></label>
                                                @endfor
                                            </div>
                                            <br>
                                            {!! $review->comment !!}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script>
        var gallery = new Vue({
            el: "#gallery",
            mounted() {
                AOS.init();
            },
            data: {
                activePhoto: 0,
                photos: [
                    @foreach ($product->galleries as $gallery)
                        {
                            id: {{ $gallery->id }},
                            url: "{{ Storage::url($gallery->photos) }}"
                        },
                    @endforeach
                ],
            },
            methods: {
                changeActive(id) {
                    this.activePhoto = id;
                },
            }
        });
    </script>
@endpush
