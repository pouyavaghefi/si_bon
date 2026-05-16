@extends('frontend.layouts.master')

@section('pageTitle','چاپ سی بن - آنلاین')

@section('wrapper')
    @include('frontend.layouts.includes.sections.modal')

    @include('frontend.layouts.includes.gadgets.banner')

    @include('frontend.layouts.includes.gadgets.slider')

    @include('frontend.layouts.includes.gadgets.categories')

    @include('frontend.layouts.includes.gadgets.blogs')
@endsection
