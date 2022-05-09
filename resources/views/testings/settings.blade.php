@push("styles")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@include('header', ['title' => 'Testing Settings'])

<div id="modal" class="modal">
    <div class="modal-content">
        <h4>Warning</h4>
        <p>Confirm you action to delete question</p>
    </div>
    <div class="modal-footer">
        <form method="post" action="{{ route('delete-question') }}">
            @csrf
            <input type="hidden" id="hiddenId" name="hiddenId" value="">

            <a class="modal-close waves-effect waves-red btn-flat">Disagree</a>
            <button type="submit" class="modal-close waves-effect waves-green btn-flat">Agree</button>
        </form>
    </div>
</div>

<div id="modal2" class="modal">
    <div class="modal-content">
        <h4>Warning</h4>
        <p>Confirm you action to delete testing</p>
    </div>
    <div class="modal-footer">
        <form method="post" action="{{ Request::url() }}/delete">
            @csrf
            <a class="modal-close waves-effect waves-red btn-flat">Disagree</a>
            <button type="submit" class="modal-close waves-effect waves-green btn-flat">Agree</button>
        </form>
    </div>
</div>

<div class="container">
    @include('alerts')

    <ul class="tabs tabs-fixed-width tab-demo z-depth-1">
        <li class="tab"><a class="active" href="#data">Information</a></li>
        <li class="tab"><a href="#testings">Questions</a></li>
        <li class="tab"><a href="#active">Active</a></li>
    </ul>

    <div id="active">
        <div style="text-align: center;margin-top: 30px;">
            <a href="{{ route('activate', ['test' => $test->real_id]) }}" class="waves-effect waves-light btn">Activate new</a>

            <div class="collection">
                @foreach ($test->activatedTestings as $active)
                    <a href="{{ route('edit-activate', ['test' => $test->real_id, 'id' => $active->id]) }}" class="collection-item">{{ $active->title }}
                        <span class="new badge {{ $active->isActive() ? "" : "red" }}" data-badge-caption="">{{ $active->getEndDateTime() }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div id="testings">
        <div style="text-align: center;margin-top: 30px;">
            <a href="{{ route('make-question', ['test' => $test->real_id]) }}" class="waves-effect waves-light btn">Create new</a>
        </div>

        <div class="questions">
            @foreach ($test->questions as $question)
                <div class="card question">
                    <div class="card-content">
                        <p>{{ $question->question }}</p>

                        <div class="answers">
                            @foreach (json_decode($question->json_answers) as $answer)
                                <div class="answer">
                                    <p>
                                        <label>
                                            <input type="{{ App\Data\Question\QuestionType::getCheckBoxType($question->response_type) }}"
                                                   {{ $answer->checked ? "checked" : "" }} class="filled-in with-gap" onclick="return false;">
                                            <span></span>
                                        </label>
                                    </p>
                                    <textarea class="materialize-textarea" readonly>{{ $answer->text }}</textarea>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="#modal" class="modal-trigger" onclick="onDeleteClick({{ $question->id }});">Delete</a>
                        <a href="{{ route('edit-question', ['test' => $test->real_id, 'id' => $question->id]) }}">Edit</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="data" style="margin-top: 20px;">
        <form class="flex-column" method="POST" action="">
            <a class="btn waves-effect waves-light red-button modal-trigger" href="#modal2">delete testing
                <i class="material-icons right" style="font-size: 25px;">delete</i>
            </a>

            @csrf
            <div class="input-field" style="width: 100%;margin-top: 30px;">
                <i class="material-icons prefix">settings</i>
                <input id="title" type="text" class="validate" name="title" value="{{ $test->title }}">
                <label for="title">Title</label>
            </div>

            <div class="input-field" style="width: 100%;">
                <i class="material-icons prefix">create</i>
                <textarea id="textarea" class="materialize-textarea" data-length="255" name="description">{{ $test->description }}</textarea>
                <label for="textarea">Description</label>
            </div>

            <div class="auth_bottom">
                <button class="btn waves-effect waves-light button-auth" type="submit">update
                    <i class="material-icons right" style="font-size: 25px;">save</i>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function onDeleteClick(id) {
        let element = document.getElementById("hiddenId");
        element.value = id;
    }
</script>
@endpush

@include('footer')

