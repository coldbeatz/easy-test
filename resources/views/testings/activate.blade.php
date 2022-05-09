@push("styles")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@include('header', ['title' => 'Activate Testing'])

<div id="modal" class="modal">
    <div class="modal-content">
        <h4>Warning</h4>
        <p>Confirm you action to delete activated testing</p>
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

    @isset($active)
    <ul class="tabs tabs-fixed-width tab-demo z-depth-1" style="margin-bottom: 20px" id="tabs">
        <li class="tab"><a class="change" href="#change">Change data</a></li>
        <li class="tab"><a href="#connection">Connection data</a></li>
        <li class="tab"><a href="#statistic">Statistic</a></li>
    </ul>

    <div id="connection">
        <div class="flex-column">
            <div class="input-field">
                <i class="material-icons prefix">build</i>
                <input id="code" type="text" value="{{ $active->access_code }}" readonly>
                <label for="code">Access code</label>
            </div>
            <img style="margin-top: 10px;" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(150)->generate("todo route")) !!} ">
        </div>
    </div>

    <div id="statistic">
        <div id="chart" style="height: 300px;"></div>
        <div class="collection" id="results-container">
            @include('testings/statistic-list', ['results' => $active->results()])
        </div>
    </div>
    @endisset

    <div id="change">
        <form class="flex-column" method="POST" action="">
            @csrf

            <a class="btn waves-effect waves-light red-button modal-trigger" href="#modal">delete
                <i class="material-icons right" style="font-size: 25px;">delete</i>
            </a>

            <div class="input-field" style="margin-top: 30px;">
                <i class="material-icons prefix">settings</i>
                <input id="title" type="text" class="validate" data-length="255" name="title" value="{{ isset($active) ? $active->title : '' }}">
                <label for="title">Title</label>
            </div>

            <div class="input-field">
                <i class="material-icons prefix">format_italic</i>
                <input id="rating" type="number" class="validate" name="rating" min="1" value="{{ isset($active) ? $active->max_rating : '1' }}">
                <label for="rating">Max rating</label>
            </div>

            <div class="input-field" style="display: flex;justify-content: center">
                <span style="margin-right: 10px;">Show user answers: </span>
                <div class="switch">
                    <label>
                        Off
                        <input type="checkbox" id="answers-switch" name="showUserAnswers" {{ isset($active) && $active->show_user_answers ? 'checked' : '' }}>
                        <span class="lever"></span>
                        On
                    </label>
                </div>
            </div>

            <div class="input-field" style="display: {{ isset($active) && $active->show_user_answers ? 'flex' : 'none' }};justify-content: center" id="correct-answers">
                <span style="margin-right: 10px;">Show correct answers: </span>
                <div class="switch">
                    <label>
                        Off
                        <input type="checkbox" name="showCorrectAnswers" {{ isset($active) && $active->show_correct_answers ? 'checked' : '' }}>
                        <span class="lever"></span>
                        On
                    </label>
                </div>
            </div>

            <div class="input-field" style="display: flex;justify-content: center">
                <span style="margin-right: 10px;">Date to: </span>
                <div class="switch">
                    <label>
                        Off
                        <input type="checkbox" id="date-switch" name="useDate" {{ isset($active) && isset($active->end_time) ? 'checked' : '' }}>
                        <span class="lever"></span>
                        On
                    </label>
                </div>
            </div>

            <div class="input-field" style="display: {{ isset($active) && isset($active->end_time) ? 'flex' : 'none' }}; margin-top: 0px;" id="dates">
                <input type="text" class="datepicker" style="margin: 0 5px;" id="date" name="date" value="{{ isset($active) && isset($active->end_time) ? date('m/d/Y', strtotime($active->end_time)) : '' }}">
                <input type="text" class="timepicker" style="margin: 0 5px;" id="time" name="time" value="{{ isset($active) && isset($active->end_time) ? date('H:i', strtotime($active->end_time)) : '' }}">
            </div>

            <div style="margin-top: 20px;">
                <button class="btn waves-effect waves-light button-auth" type="submit">{{ isset($active) ? 'save' : 'activate' }}
                    <i class="material-icons right" style="font-size: 25px;">send</i>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script src="{{ URL::asset('js/echarts/echarts.min.js') }}"></script>
    <script src="{{ URL::asset('js/echarts/chartisan_echarts.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let textNeedCount = document.querySelectorAll('#input_text, #title');
            M.CharacterCounter.init(textNeedCount);

            let datePicker = document.getElementById('date');
            M.Datepicker.init(datePicker, {
                minDate: new Date(),
                defaultDate: new Date(),
                setDefaultDate: true,
                format: 'mm/dd/yyyy'
            });

            let timePicker = document.getElementById('time');
            let timeInstance = M.Timepicker.init(timePicker, {
                defaultTime: '00:00',
                twelveHour: false
            });

            timeInstance._updateTimeFromInput();
            timeInstance.done();

            let dates = document.getElementById('dates');
            let dateSwitch = document.getElementById('date-switch');

            let answers = document.getElementById('correct-answers');
            let answersSwitch = document.getElementById('answers-switch');

            dateSwitch.addEventListener('change', function (e) {
                let input = e.target;
                dates.style.display = input.checked ? 'flex' : 'none';
            });

            answersSwitch.addEventListener('change', function (e) {
                let input = e.target;
                answers.style.display = input.checked ? 'flex' : 'none';
            });

            let results = document.getElementById('results-container');
            if (results != null) {
                const chart = new Chartisan({
                    el: '#chart',
                    url: window.location.href + "/chart",
                    hooks: new ChartisanHooks()
                        .legend()
                        .colors()
                        .tooltip()
                        .axis(false)
                        .datasets('pie')
                });

                function initTabs() {
                    let autoUpdateInterval = null;

                    function refreshResults() {
                        const request = new XMLHttpRequest();
                        request.responseType = "json";
                        request.open("GET", window.location.href + "/results", true);
                        request.addEventListener("readystatechange", () => {
                            if (request.readyState === 4 && request.status === 200) {
                                results.innerHTML = request.response.html;
                            }
                        });
                        request.send();
                    }

                    let updateStatistic = function () {
                        chart.update();
                        refreshResults();
                    }

                    M.Tabs.init(document.getElementById('tabs'), {
                        onShow: function (e) {
                            if (e.id === 'statistic') {
                                updateStatistic();

                                if (autoUpdateInterval == null) {
                                    autoUpdateInterval = setInterval(updateStatistic, 30000);
                                }
                            } else {
                                clearInterval(autoUpdateInterval);
                                autoUpdateInterval = null;
                            }
                        }
                    });
                }

                initTabs();
            }

        });
    </script>
@endpush

@include('footer')

