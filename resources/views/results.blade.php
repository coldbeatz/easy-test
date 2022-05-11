@push("styles")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@include('header', ['title' => 'Testings'])

<div class="container">
    @include('alerts')

    <div class="collection" id="results-container">
        @foreach ($results as $result)
            <a href="{{ route('test', ['hash' => $result->hash]) }}" class="collection-item">
                <div class="result">
                    <span>{{ $result->activateTesting->testing->title }}</span>
                    <span style="color: coral;">{{ !$result->isCompleted() ? 'not completed' : '' }}</span>
                    <div>
                        <span>{{ $result->isCompleted() ?
                                Carbon\Carbon::parse($result->completion_time)->diffForHumans() :
                                Carbon\Carbon::parse($result->start_time)->diffForHumans()}}
                        </span>
                        <span class="new badge {{ !$result->isCompleted() ? 'red' : '' }}" data-badge-caption="">{{ $result->rating }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    @if ($results->hasPages())
    <ul class="pagination">
        @if ($results->onFirstPage())
            <li class="disabled">
                <a>
                    <i class="material-icons">chevron_left</i>
                </a>
            </li>
        @else
            <li class="waves-effect">
                <a href="{{ $results->previousPageUrl() }}">
                    <i class="material-icons">chevron_left</i>
                </a>
            </li>
        @endif

        @for ($i = 1; $i <= $results->lastPage(); $i++)
            @if ($i == $results->currentPage())
                <li class="active">
                    <a href="?page={{$i}}">{{$i}}</a>
                </li>
            @else
                <li class="waves-effect">
                    <a href="?page={{$i}}">{{$i}}</a>
                </li>
            @endif
        @endfor

        @if ($results->hasMorePages())
            <li class="waves-effect">
                <a href="{{ $results->nextPageUrl() }}">
                    <i class="material-icons">chevron_right</i>
                </a>
            </li>
        @else
            <li class="disabled">
                <a>
                    <i class="material-icons">chevron_right</i>
                </a>
            </li>
        @endif
    </ul>
    @endif
</div>

@push('scripts')

@endpush

@include('footer')

