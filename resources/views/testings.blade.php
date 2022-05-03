@push("styles")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@include('header', ['title' => 'Testings'])

<div class="container">
    <ul class="tabs tabs-fixed-width tab-demo z-depth-1">
        <li class="tab"><a class="active" href="#data">Connection</a></li>
        <li class="tab"><a href="#testings">My testings</a></li>
    </ul>

    <div id="testings">
        <div style="text-align: center;margin-top: 30px;">
            <a href="{{ route('make-test') }}" class="waves-effect waves-light btn">Create new</a>

            <div class="collection">
            @foreach ($testings as $test)
                <a href="{{ route('testing', ['test' => $test->real_id]) }}" class="collection-item">{{ $test->title }}
                    <span class="new badge" data-badge-caption="">{{ $test->created_at }}</span>
                </a>
            @endforeach
            </div>
        </div>
    </div>

    <div id="data">

    </div>
</div>

@push('scripts')

@endpush

@include('footer')

