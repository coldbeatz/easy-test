@push("styles")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@include('header', ['title' => 'Make Testing'])

<div class="container">
    @include('alerts')

    <form class="flex-column" method="POST" action="create">
        @csrf
        <div class="input-field">
            <i class="material-icons prefix">settings</i>
            <input id="title" type="text" class="validate" name="title">
            <label for="title">Title</label>
        </div>

        <div class="input-field">
            <i class="material-icons prefix">create</i>
            <textarea id="textarea" class="materialize-textarea" data-length="255" name="description"></textarea>
            <label for="textarea">Description</label>
        </div>

        <div class="auth_bottom">
            <button class="btn waves-effect waves-light button-auth" type="submit">Create
                <i class="material-icons right" style="font-size: 25px;">send</i>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let textNeedCount = document.querySelectorAll('#input_text, #textarea');
        M.CharacterCounter.init(textNeedCount);
    });
</script>
@endpush

@include('footer')

