@extends('aplication.layouts')

@section('content')
    <section class="content" style="margin-top: 70px">
        <div class="container-fluid">
            @include('aplication.pages.dashboard')
            @include('aplication.pages.user')
        </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @include('aplication.pages.script')
@endsection
