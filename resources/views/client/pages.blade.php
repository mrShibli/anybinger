@extends('client.layouts.app')

@section('headers')
    <title>{{ $pages->name }}</title>

    <meta name="keywords" content="{{ $pages->meta_keyword }}" />
    <meta name="description" content="{{ $pages->meta_description }}" />

    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Shibli Raihan">

    <!-- og meta tag -->
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index, follow, archive, snippet" />
    <meta name="googlebot-news" content="snippet" />
    <meta name="googlebot-mobile" content="index, follow, archive" />
    <meta name="msnbot" content="index, follow" />
    <meta name="slurp" content="archive, ydir, snippet" />
    <meta name="revisit-after" content="0 days" />
    <meta name="copyright" content="©{{ $pages->name }}" />
    <meta property='og:locale' content='en_US' />
    <meta property="og:locale:alternate" content='bn_BD' />
    <meta property="og:title" content="{{ $pages->name }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.anybringr.com/" />
    <meta property="og:image" content="" />
    <meta property="og:site_name" content="Anybringr" />
    <meta property="fb:app_id" content="235034696605750" />

    <style>
        .no-tailwind {
            all: unset !important;
        }

        .no-tailwind h1 {
            font-size: 30px !important;
            font-weight: bold !important;
        }

        .no-tailwind h2 {
            font-size: 26px !important;
            font-weight: bold !important;
        }

        .no-tailwind h3 {
            font-size: 22px !important;
            font-weight: bold !important;
        }

        .no-tailwind h4 {
            font-size: 17px !important;
            font-weight: bold !important;
        }

        .no-tailwind h5 {
            font-size: 15px !important;
            font-weight: bold !important;
        }

        .no-tailwind h6 {
            font-size: 14px !important;
            font-weight: bold !important;
        }
    </style>
@endsection

@section('contents')

    <main class="max-w-[1400px] mx-auto px-3 sm:px-6 md:px-8">
      <div class="bg-white inline-block mt-3">
        <div class="flex flex-row items-center justify-between">
          <a href="{{ route('index') }}" class="link">Home</a>
          <i
            class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"
          ></i>
          <a href="" class="link">{{ $pages->name }}</a>
        </div>
      </div>

      <div class="mt-4 max-w-[1200px] mx-auto">
        <h2 class="text-[25px] font-medium mb-2 text-center">{{ $pages->name }}</h2>

        <div class="my-4 no-tailwind">
          {!! $pages->description !!}
        </div>
      </div>
    </main>
@endsection

@section('customJs')
    @include('client.layouts.javascripts')
@endsection
