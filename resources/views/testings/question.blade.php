@push("styles")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@include('header', ['title' => 'Question'])

<div class="container">
    @include('alerts')

    <form id="form" class="flex-column" method="POST" action="">
        @csrf
        <div class="input-field" style="width: 100%;">
            <i class="material-icons prefix">create</i>
            <textarea id="textarea" class="materialize-textarea" data-length="2000" name="question">{{ isset($question) ? $question->question : '' }}</textarea>
            <label for="textarea">Question text</label>
        </div>

        <input type="hidden" id="jsonHidden" name="jsonHidden">

        <button class="btn waves-effect waves-light button-auth" type="button" id="addQuestionBtn">new answer
            <i class="material-icons right" style="font-size: 25px;">create</i>
        </button>

        <div id="answers" class="flex-column">
            @isset($question)
                @foreach (json_decode($question->json_answers) as $answer)
                    <div class="answer">
                        <p>
                            <label>
                                <input type="checkbox" class="filled-in" {{ $answer->checked ? "checked" : "" }}>
                                <span></span>
                            </label>
                        </p>
                        <textarea class="materialize-textarea">{{ $answer->text }}</textarea>
                        <i class="large material-icons" data-remove="false">close</i>
                    </div>
                @endforeach
            @endisset
        </div>

        <button class="btn waves-effect waves-light button-auth" type="button" id="saveButton">save
            <i class="material-icons right" style="font-size: 25px;">save</i>
        </button>
    </form>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let textNeedCount = document.querySelectorAll('#input_text, #textarea');
            M.CharacterCounter.init(textNeedCount);

            let addQuestionBtn = document.getElementById('addQuestionBtn');
            let saveButton = document.getElementById('saveButton');

            let text = document.getElementById('textarea');
            let answers = document.getElementById('answers');

            function createAnswer() {
                let answer = document.createElement('DIV');
                answer.className = 'answer';

                let createCheckbox = function () {
                    let p = document.createElement('P');
                    let label = document.createElement('LABEL');
                    let span = document.createElement('SPAN');

                    let input = document.createElement('INPUT');
                    input.type = 'checkbox';
                    input.className = 'filled-in';
                    input.addEventListener('input', checkButtonState);

                    label.append(input, span);
                    p.append(label);

                    return p;
                }

                answer.appendChild(createCheckbox());

                let textarea = document.createElement('TEXTAREA');
                textarea.className = 'materialize-textarea';
                textarea.addEventListener('input', checkButtonState);

                answer.appendChild(textarea);

                let icon = document.createElement('I');
                icon.className = 'large material-icons';
                icon.textContent = 'close';

                icon.setAttribute('data-remove', 'false');
                icon.addEventListener('click', () => onRemove(icon, answer));

                answer.appendChild(icon);
                answers.appendChild(answer);

                checkButtonState();
            }

            addQuestionBtn.addEventListener('click', createAnswer);
            text.addEventListener('input', checkButtonState);

            function onRemove(elem, answer) {
                let remove = elem.getAttribute('data-remove');

                if (remove === 'false') {
                    elem.setAttribute('data-remove', 'true');

                    fade(answer, () => {
                        answers.removeChild(answer);
                        checkButtonState();
                    });
                }
            }

            function checkButtonState() {
                let validateAnswers = function () {
                    if (answers.childElementCount < 2)
                        return false;

                    let areas = answers.querySelectorAll('textarea');
                    for (let area of areas) {
                        if (area.value === '') {
                            return false;
                        }
                    }

                    return true;
                }

                saveButton.disabled = !validateAnswers() || text.value === '';
            }

            checkButtonState();

            if (answers.childElementCount === 0) {
                createAnswer();
                createAnswer();
            }

            saveButton.addEventListener('click', () => {
                let result = [];
                for (let answer of answers.querySelectorAll('.answer')) {
                    result.push({
                        checked: answer.querySelector('input').checked,
                        text: answer.querySelector('textarea').value
                    })
                }

                let jsonHidden = document.getElementById('jsonHidden');
                let form = document.getElementById('form');

                jsonHidden.value = JSON.stringify(result);
                form.submit();
            });

            for (let answer of answers.querySelectorAll('.answer')) {
                let icon = answer.querySelector('i');
                if (icon) {
                    icon.addEventListener('click', () => onRemove(answer.querySelector('i'), answer))
                }
            }
        });
    </script>
@endpush

@include('footer')

