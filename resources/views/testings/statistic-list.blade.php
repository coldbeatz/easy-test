@foreach ($results as $result)
    <a href="{{ route('test', ['hash' => $result->hash]) }}" class="collection-item">
        <div class="result">
            <div class="result_user">
                <img class="circle" src="{{ URL::asset('storage/' . $result->user->avatar) }}">
                <span>{{ $result->user->name }} <span style="font-size: 14px;">({{ $result->ip }})</span></span>
            </div>
            <div>
                <span>{{ Carbon\Carbon::parse($result->completion_time)->diffForHumans() }}</span>
                <span class="new badge" data-badge-caption="">{{ $result->rating }}</span>
            </div>
        </div>
    </a>
@endforeach
