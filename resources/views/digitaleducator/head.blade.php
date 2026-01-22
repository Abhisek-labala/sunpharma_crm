<!DOCTYPE html>
<html lang="en"> <!-- Set language for accessibility & SEO -->
<head>
    @php
        $ProjectName = config('app.name', 'SunPharma');
    @endphp

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Prevents quirks mode -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO -->
    <meta name="description" content="Your meta description goes here."> <!-- REQUIRED -->
    <meta name="keywords" content="SunPharma, HR, Employee, Management, Portal"> <!-- Update as needed -->
    <meta name="author" content="Your Company Name">
    <meta name="robots" content="index, follow">

    <!-- Title -->
    <title>{{ $ProjectName }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/logo/logo.png') }}">

    <!-- Stylesheets -->
    <link rel="preload" as="style" href="{{ asset('css/bootstrap/bootstrap.min.css') }}" onload="this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}"></noscript>

    <link rel="stylesheet" href="{{ asset('css/bootstrap/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ui/1.13.1/themes/base/jquery-ui.css') }}">

    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.dataTables.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Preconnect for Fonts (optional, if you're using Google Fonts) -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Defer scripts (put actual <script> tags just before </body> for performance) -->
</head>
<body>
