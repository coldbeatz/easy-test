@push("styles")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@include('header', ['title' => 'Test'])

<div class="questions">
    <div class="card">
        <div class="card-content">
            <span class="card-title" style="font-weight: unset;font-size: 17px;text-align: center;">{{ $testing->title }}</span>
            <p>{{ $testing->description }}</p>
        </div>

        <div class="card-action">
            <div class="result-image">
                <img class="circle" src="{{ URL::asset('storage/' . $result->user->avatar) }}">
                <b>{{ $user->name }}</b>
            </div>
        </div>

        <div class="card-action">
            <div>
                <span><b>Start time:</b> {{ $result->start_time->format('d/m/Y H:i') }}</span><br>
                <span><b>End time:</b> {{ $result->completion_time->format('d/m/Y H:i') }}</span><br><br>
                <span>{{ $result->parseTotalTime() }}</span>
            </div>
        </div>

        <div class="card-action">
            <div class="center">
                <b class="mx-1">{{ $result->rating }} / {{ $active->max_rating }}</b>
                <span class="mx-1"> scores</span>
            </div>
            <div>
                <div class="progress">
                    <div class="progress-line" style="width: {{ $questionsData->getRatingPercent() }}%">
                        <span>{{ $questionsData->getRatingPercent() }}%</span>
                    </div>
                </div>
                <div class="progress-info">
                    <span>0%</span>
                    <span>100%</span>
                </div>
            </div>

            <div class="result-stat">
                <div>
                    <b>{{ $questionsData->size() }}</b>
                    <span> all</span>
                </div>
                <div>
                    <b>{{ $questionsData->correctSize() }}</b>
                    <span>correct</span>
                </div>
                <div>
                    <b>{{ $questionsData->size() - $questionsData->correctSize() }}</b>
                    <span>wrong</span>
                </div>
            </div>
        </div>
    </div>

    @if ($isCreator || $active->show_user_answers)
    <div class="flex-column">
        @csrf
        <input type="hidden" name="hidden" id="hidden">
        @foreach ($result->getResultQuestions()->getQuestions() as $key => $question)
            <div class="card question {{ ($isCreator || $active->show_correct_answers) && !$question->isCorrectQuestion() ? 'question-red' : '' }}">
                <div class="card-content">
                    <p>{{ $question->getText() }}</p>
                    <div class="answers">
                        @foreach ($question->getAnswers() as $answer)
                            <div class="answer">
                                <label>
                                    @if (($isCreator || $active->show_correct_answers) && !$answer->isCorrect)
                                        <input type="{{ $question->getInputType() }}"
                                               class="filled-in with-gap checkbox-blue-grey {{ $answer->state }}"
                                               {{ $answer->checked ? 'checked' : '' }} onclick="return false;">
                                    @else
                                        <input type="{{ $question->getInputType() }}"
                                               class="filled-in with-gap checkbox-blue-grey"
                                               {{ $answer->userChecked ? "checked" : "" }} onclick="return false;">
                                    @endif
                                    <span class="{{ $answer->state }}"></span>
                                </label>
                                <textarea class="materialize-textarea" readonly>{{ $answer->text }}</textarea>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif
</div>

@push('scripts')

@endpush

@include('footer')

















