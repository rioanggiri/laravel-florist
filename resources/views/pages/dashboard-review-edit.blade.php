@extends('layouts.dashboard')
@section('review', 'active')

@section('title', 'Review')

@push('addon-style')
    <style>
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

        .rating input:checked~label {
            color: #f90;
        }

        .rating label:hover,
        .rating label:hover~label {
            color: #f90;
        }

        /* Membalikkan urutan bintang */
        .rating {
            direction: rtl;
        }
    </style>
@endpush
@section('content')
    <!-- Page Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Ulasan Saya</h2>
                <p class="dashboard-subtitle" style="color: gray">List Ulasan</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        {{-- Jika Terjadi Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('reviews.update', $item->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Rating : </label>
                                                <div class="rating">
                                                    @for ($i = 5; $i >= 1; $i--)
                                                        <input type="radio" id="star{{ $i }}" name="rating"
                                                            value="{{ $i }}"
                                                            {{ $item->rating == $i ? 'checked' : '' }}>
                                                        <label for="star{{ $i }}"></label>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="comment">Komentar</label>
                                                <textarea name="comment" id="comment" class="form-control" rows="5">{!! $item->comment !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <button type="submit" class="btn btn-store px-5">
                                                Save Now
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".select2").select2();
        });
    </script>
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
@endpush
