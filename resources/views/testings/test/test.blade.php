@push("styles")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@include('header', ['title' => 'Test'])

<div class="questions">

    <div class="card">
        <div class="card-content">
            <span class="card-title" style="font-weight: unset;font-size: 17px;text-align: center;">{{ $result->activateTesting->testing->title }}</span>
            <p>{{ $result->activateTesting->testing->description }}</p>
        </div>
        <div class="card-action">
            <span>Time: </span><b id="time">{{ Carbon\Carbon::now()->getTimestamp() - $result->start_time->getTimestamp() }}</b>
        </div>
    </div>

    <form class="flex-column" method="POST" action="" id="form">
        @csrf
        <input type="hidden" name="hidden" id="hidden">
        @foreach ($result->getResultQuestions()->getQuestions() as $key => $question)
            <div class="card question">
                <div class="card-content">
                    <p>{{ $question->getText() }}</p>
                    <div class="answers">
                        @foreach ($question->getAnswers() as $answer)
                            <div class="answer">
                                <p>
                                    <label>
                                        <input type="{{ $question->getInputType() }}"
                                               name="{{ $key }}[]"
                                               value="{{ $answer->id }}"
                                               class="filled-in with-gap"
                                               {{ $answer->userChecked ? "checked" : "" }}>
                                        <span></span>
                                    </label>
                                </p>
                                <textarea class="materialize-textarea" readonly>{{ $answer->text }}</textarea>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
        <button class="btn waves-effect waves-light button-auth" type="button" id="submit" style="margin-top: 10px;">complete
            <i class="material-icons right" style="font-size: 25px;">save</i>
        </button>
    </form>
</div>

@push('scripts')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script>
    const submit = document.getElementById('submit');
    submit.addEventListener('click', () => {
        let questions = document.getElementsByClassName('question');

        let send = true;
        for (let question of questions) {
            let inputs = question.querySelectorAll('input');

            // если не выбрали ни одного варианта
            if (Array.from(inputs).find(item => item.checked) == null) {
                question.style.border = '1px solid palevioletred';
                send = false;
            } else {
                question.style.border = null;
            }
        }

        if (send) {
            let hidden = document.getElementById('hidden');
            hidden.value = 'true';
            submit.type = 'submit';
        } else {
            M.toast({
                html: 'You haven\'t answered all the questions',
                classes: 'rounded'
            });
        }
    });

    function runTimer() {
        const time = document.getElementById("time");

        function format(sec) {
            let hours = Math.floor(sec / 60 / 60);
            let minutes = Math.floor(sec / 60) - (hours * 60);
            let seconds = sec % 60;

            let result = [];

            if (hours > 0) result.push(hours.toString().padStart(2, '0'));
            if (minutes > 0) result.push(minutes.toString().padStart(2, '0'));

            result.push(result.length === 0 ? seconds : seconds.toString().padStart(2, '0'));

            return result.join(':');
        }

        let timestamp = parseInt(time.textContent);
        function update() {
            timestamp++;
            time.textContent = format(timestamp);
        }

        update();
        setInterval(update, 1000);
    }
    runTimer();


    let form = document.getElementById('form');

    setInterval(function () {
        $.ajax({
            url: form.action,
            type: "POST",
            dataType: "text",
            data: $("#" + form.id).serialize()
        })
    }, 10000);

</script>
@endpush

@include('footer')

