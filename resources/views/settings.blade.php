@push("styles")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@include('header', ['title' => 'Settings'])

<div id="modal" class="modal">
    <div class="modal-content">
        <h4>Update Image</h4>

        <form id="file-form">
            <div class="file-field input-field">
                <div class="btn">
                    <span>File</span>
                    <input type="file" id="upload" value="Choose a file" accept="image/*">
                </div>

                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Upload image file...">
                </div>
            </div>
        </form>

        <div id="img-upload"></div>
        <button class="waves-effect waves-light btn" id="upload-btn" disabled>Upload</button>
    </div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-red btn-flat">CLOSE</a>
    </div>
</div>

<div class="container">
    <ul class="tabs tabs-fixed-width tab-demo z-depth-1">
        <li class="tab"><a class="active" href="#data">Change data</a></li>
        <li class="tab"><a href="#profile-image-container">Change Image</a></li>
    </ul>

    <div id="profile-image-container">
        <div class="avatar-container">
            <img src="{{ URL::asset('storage/' . Auth::user()->avatar) }}" class="image-user-setting" id="profile-image">

            <a class="waves-effect waves-light btn modal-trigger" href="#modal">Update Image</a>
        </div>
    </div>

    <div id="data">
        @if (Session::has('success'))
            <div class="materialert success">
                <div class="material-icons">done</div>
                {!! Session::get('success') !!}
            </div>
        @endif

        @if ($errors->any())
            <div class="materialert error">
                <div class="material-icons">error_outline</div>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('setName') }}">
            @csrf
            <div class="input-field" id="name-setting">
                <i class="material-icons prefix">assignment_ind</i>
                <input id="name" type="text" class="validate" name="name" value="{{ Auth::user()->name }}">
                <label for="name">Name</label>
            </div>

            <div class="settings-button">
                <button class="btn waves-effect waves-light" type="submit">
                    save
                    <i class="material-icons right" style="font-size: 25px;">save</i>
                </button>
            </div>
        </form>

        <div class="divider"></div>

        <form method="POST" action="{{ route('setPassword') }}">
            @csrf
            <div class="settings-passwords">
                <div class="input-field">
                    <i class="material-icons prefix">no_encryption</i>
                    <input id="oldPassword" type="password" name="oldPassword">
                    <label for="oldPassword">Current password</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">no_encryption</i>
                    <input id="password" type="password" name="password">
                    <label for="password">Password</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">no_encryption</i>
                    <input id="passwordConfirm" type="password">
                    <label for="passwordConfirm">Password confirm</label>
                </div>
            </div>

            <div class="captcha-container">
                <div style="display: flex; align-items: center">
                    <img src="{{ Captcha::src() }}" id="captcha">
                    <a id="refreshCaptcha">
                        <i class="material-icons right" style="font-size: 40px;">rotate_right</i>
                    </a>
                </div>

                <div class="input-field">
                    <i class="material-icons prefix">edit</i>
                    <input id="captchaCode" type="text" name="captcha">
                    <label for="captchaCode">Captcha code</label>
                </div>
            </div>

            <div class="settings-button">
                <button class="btn waves-effect waves-light" type="submit">
                    save
                    <i class="material-icons right" style="font-size: 25px;">save</i>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/exif-js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let modalInstance = M.Modal.init(document.querySelector('#modal'));

            let image = document.getElementById('img-upload');
            let upload = document.getElementById('upload');

            let uploadButton = document.getElementById('upload-btn');
            let profileImage = document.getElementById('profile-image');

            let croppie = new Croppie(image, {
                enableExif: true,
                viewport: {
                    width: 200,
                    height: 200,
                    type: 'circle'
                },
                boundary: {
                    width: 300,
                    height: 300
                },
                forceBoundary: true,
                enableOrientation: false
            });

            function toast(text) {
                M.toast({
                    html: text,
                    classes: 'rounded'
                });
            }

            uploadButton.addEventListener('click', () => {
                croppie.result({
                    type: 'blob',
                    size: 'viewport',
                    format: 'jpeg',
                    circle: false,
                    quality: 0.9
                }).then(function (blob) {
                    let data = new FormData();
                    data.append('image', blob, 'image.jpg');

                    fetch("upload_image", {
                        method: 'POST',
                        body: data,
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.error != null) {
                                toast('Error: ' + data.error);
                            } else {
                                let form = document.getElementById('file-form');
                                form.reset();

                                image.style.display = 'none';
                                uploadButton.disabled = true;

                                modalInstance.close();
                                profileImage.src = data.src;

                                toast('Avatar updated');
                            }
                        })
                        .catch(error => {
                            toast('Error: ' + error);
                        });
                });
            });

            upload.addEventListener('change', e => {
                let target = e.target;
                const [file] = target.files;

                if (file) {
                    image.style.display = 'block';
                    uploadButton.disabled = false;

                    croppie.bind({
                        url: URL.createObjectURL(file),
                        zoom: 0.1
                    });
                }
            });

            let refreshCaptcha = document.getElementById('refreshCaptcha');
            let captcha = document.getElementById('captcha');

            refreshCaptcha.addEventListener('click', () => {
                fetch('{{ route('refreshCaptcha') }}')
                .then(response => {
                    if (response.status === 200) {
                        response.json().then(function(data) {
                            captcha.src = data.captcha;
                        });
                    }
                }).catch(function(error) {
                    toast('Error: ' + error);
                });
            });
        });

    </script>
@endpush

@include('footer')

