@push("styles")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/styles/default.min.css">
@endpush
@include('header', ['title' => 'API'])

<div class="container">
    <ul class="tabs tabs-fixed-width tab-demo z-depth-1">
        <li class="tab"><a class="active" href="#user">user</a></li>
        <li class="tab"><a href="#testings">testings</a></li>
    </ul>

    <div id="user">
        <table class="striped">
            <thead>
            <tr>
                <th>URI</th>
                <th>Method</th>
                <th>Input data</th>
                <th>Output data</th>
            </tr>
            </thead>

            <tbody>



            <tr>
                <td>app/auth</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-json">
{
    "email": "user email",
    "password": "user password"
}
</code>
</pre>
                </td>

                <td>
<pre>
<code class="language-json">
{
    "remember_token": "..."
}
</code>
</pre>
                    <pre>
<code class="language-json">
{
    "error": "Invalid email/
              Email not confirmed/
              Invalid password..."
}
</code>
</pre>
                </td>
            </tr>



            <tr>
                <td>app/logout</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-json">
empty
</code>
</pre>
                </td>

                <td>
<pre>
<code class="language-json">
{
    "message": "success"
}
</code>
</pre>
                    <pre>
<code class="language-json">
{
    "error": "..."
}
</code>
</pre>
                </td>
            </tr>















            <tr>
                <td>app/setName</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-json">
{
    "name": "text"
}
</code>
</pre>
                </td>

                <td>
<pre>
<code class="language-json">
{
    "message": "success"
}
</code>
</pre>
                    <pre>
<code class="language-json">
{
    "error": "..."
}
</code>
</pre>
                </td>
            </tr>


            <tr>
                <td>app/changePassword</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-json">
{
    "oldPassword": "current password",
    "password": "new password"
}
</code>
</pre>
                </td>

                <td>
<pre>
<code class="language-json">
{
    "message": "success"
}
</code>
</pre>
                    <pre>
<code class="language-json">
{
    "error": "..."
}
</code>
</pre>
                </td>
            </tr>



            <tr>
                <td>app/uploadImage</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-html">
name: image (for post request)
size: 200x200
</code>
</pre>
                </td>

                <td>
<pre>
<code class="language-json">
{
    "src": "src to upload image"
}
</code>
</pre>
                    <pre>
<code class="language-json">
{
    "error": "..."
}
</code>
</pre>
                </td>
            </tr>




            <tr>
                <td>app/user</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-html">
empty
</code>
</pre>
                </td>

                <td>
<pre>
<code class="language-json">
{
    "name": "...",
    "email": "...",
    "avatar": "url to image"
}
</code>
</pre>
                    <pre>
<code class="language-json">
{
    "error": "..."
}
</code>
</pre>
                </td>
            </tr>



            </tbody>
        </table>
    </div>











    <div id="testings">
        <table class="striped">
            <thead>
            <tr>
                <th>URI</th>
                <th>Method</th>
                <th>Input data</th>
                <th>Output data</th>
            </tr>
            </thead>

            <tbody>

            <tr>
                <td>app/testings/all</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-html">
empty
</code>
</pre>
                </td>

                <td>
<pre>
<code class="language-json">
[
    {
        "id": 1,
        "title": "...",
        "description": "...",
        "created_at": "2022-05-03 12:06",
        "updated_at": "2022-05-03 13:29"
    },
    ...
]
</code>
</pre>
                    <pre>
<code class="language-json">
{
    "error": "..."
}
</code>
</pre>
                </td>
            </tr>



            <tr>
                <td>app/testings/new</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-json">
{
    "title": "...",
    "description": "..."
}
</code>
</pre>
                </td>

                <td>
<pre>
<code class="language-json">
{
    "title": "...",
    "description": "...",
    "updated_at": "2022-05-05 18:21",
    "created_at": "2022-05-05 18:21",
    "id": 5
}
</code>
</pre>
                    <pre>
<code class="language-json">
{
    "error": "..."
}
</code>
</pre>
                </td>
            </tr>

            <tr>
                <td>app/testings/get</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-json">
{
    "id": 2
}
</code>
</pre>
                </td>

                <td>
<pre>
<code class="language-json">
{
    "id": 2,
    "title": "...",
    "description": "...",
    "created_at": "2022-05-03 12:00",
    "updated_at": "2022-05-05 18:00"
}
</code>
</pre>
                    <pre>
<code class="language-json">
{
    "error": "..."
}
</code>
</pre>
                </td>
            </tr>



            <tr>
                <td>app/testings/update</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-json">
{
    "id": 2,
    "title": "...",
    "description": "..."
}
</code>
</pre>
                </td>

                <td>
<pre>
<code class="language-json">
{
    "id": 2,
    "title": "...",
    "description": "...",
    "created_at": "2022-05-03 12:07",
    "updated_at": "2022-05-05 18:34"
}
</code>
</pre>
                    <pre>
<code class="language-json">
{
    "error": "..."
}
</code>
</pre>
                </td>
            </tr>




            <tr>
                <td>app/testings/questions</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-json">
{
    "testing_id": 2
}
</code>
</pre>
                </td>

                <td>
<pre>
<code class="language-json">
[
    {
        "id": 4,
        "testing_id": 2,
        "question": "question text...",
        "json_answers": [
            {
                "checked": true,
                "text": "..."
            },
            {
                "checked": false,
                "text": "..."
            },
            ...
        ]
    },
    ...
]
</code>
</pre>
                    <pre>
<code class="language-json">
{
    "error": "..."
}
</code>
</pre>
                </td>
            </tr>


            <tr>
                <td>app/testings/getQuestion</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-json">
{
    "id": 2
}
</code>
</pre>
                </td>

                <td>
<pre>
<code class="language-json">
{
    "id": 2,
    "testing_id": 1,
    "question": "gsdfgfsdgf",
    "json_answers": [
        {
            "checked": true,
            "text": "sdgfsdgsdf"
        },
        {
            "checked": false,
            "text": "sdfgsdfgsdf"
        }
    ]
}
</code>
</pre>
                    <pre>
<code class="language-json">
{
    "error": "..."
}
</code>
</pre>
                </td>
            </tr>

            <tr>
                <td>app/testings/makeQuestion</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-json">
{
    "testing_id": 2,
    "question": "txt",
    "json_answers": [
        {
            "checked": true,
            "text": "1 txt"
        },
        {
            "checked": true,
            "text": "2 txt"
        },
        {
            "checked": false,
            "text": "3 txt"
        }
    ]
}
</code>
</pre>
                </td>

                <td>
<pre>
<code class="language-json">
{
    "created": true,
    "question_id": 14
}
</code>
</pre>
                    <pre>
<code class="language-json">
{
    "error": "..."
}
</code>
</pre>
                </td>
            </tr>


            <tr>
                <td>app/testings/updateQuestion</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-json">
{
    "question_id": 16,
    "question": "txt222222",
    "json_answers": [
        {
            "checked": true,
            "text": "221 txt"
        },
        {
            "checked": true,
            "text": "322 txt"
        }
    ]
}
</code>
</pre>
                </td>

                <td>
<pre>
<code class="language-json">
{
    "message": "success"
}
</code>
</pre>
                    <pre>
<code class="language-json">
{
    "error": "..."
}
</code>
</pre>
                </td>
            </tr>



            <tr>
                <td>app/testings/deleteQuestion</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-json">
{
    "question_id": 16
}
</code>
</pre>
                </td>

                <td>
<pre>
<code class="language-json">
{
    "message": "success"
}
</code>
</pre>
                    <pre>
<code class="language-json">
{
    "error": "..."
}
</code>
</pre>
                </td>
            </tr>



            </tbody>
        </table>
    </div>
</div>


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/highlight.min.js"></script>
    <script>
        hljs.highlightAll();
    </script>
@endpush

@include('footer')

