@push("styles")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/styles/default.min.css">
@endpush
@include('header', ['title' => 'API'])

<div class="container">
    <ul class="tabs tabs-fixed-width tab-demo z-depth-1" style="margin-bottom: 20px;">
        <li class="tab"><a class="active" href="#user">user</a></li>
        <li class="tab"><a href="#testings">testings</a></li>
        <li class="tab"><a href="#questions">questions</a></li>
        <li class="tab"><a href="#activate">activate test</a></li>
        <li class="tab"><a href="#passing">test passing</a></li>
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
                <td>app/testings/delete</td>
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




<div id="questions">
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



<div id="activate">
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
            <td>app/testings/activate</td>
            <td>Post</td>
            <td>
<pre>
<code class="language-json">
{
    "datetime": "05/09/2023 12:00" or null,
    "test_id": 1,
    "title": "14 group",
    "rating": 12,
    "showUserAnswers": true,
    "showCorrectAnswers": false
}
</code>
</pre>
            </td>

            <td>
<pre>
<code class="language-json">
{
    "testing_id": 1,
    "user_id": 1,
    "start_time": "2022-05-08 23:00",
    "end_time": "2023-05-09 12:00",
    "title": "14 group",
    "max_rating": 12,
    "access_code": "ywZuTSs",
    "show_user_answers": true,
    "show_correct_answers": false
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
            <td>app/testings/getActivate</td>
            <td>Post</td>
            <td>
<pre>
<code class="language-json">
{
    "id": 6
}
</code>
</pre>
            </td>

            <td>
<pre>
<code class="language-json">
{
    "id": 6,
    "testing_id": 2,
    "user_id": 1,
    "start_time": "2022-05-08 22:00",
    "end_time": null,
    "title": "gfdsgsdfgsdf",
    "access_code": "BKdib8Lk9",
    "show_user_answers": 0,
    "show_correct_answers": 0,
    "max_rating": 1
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
            <td>app/testings/allActivates</td>
            <td>Post</td>
            <td>
<pre>
<code class="language-json">
{
    "test_id": 1
}
</code>
</pre>
            </td>

            <td>
<pre>
<code class="language-json">
[
    {
        "id": 3,
        "testing_id": 1,
        "user_id": 1,
        "start_time": "2022-05-08 20:00",
        "end_time": null,
        "title": "543hfghf45",
        "access_code": "qJhSWQiM",
        "show_user_answers": 1,
        "show_correct_answers": 1,
        "max_rating": 44
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
            <td>app/testings/updateActivate</td>
            <td>Post</td>
            <td>
<pre>
<code class="language-json">
{
    "id": 1,
    "title": "24 group",
    "rating": 22,
    "showUserAnswers": true,
    "showCorrectAnswers": true,
    "datetime": null
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
            <td>app/testings/deleteActivate</td>
            <td>Post</td>
            <td>
<pre>
<code class="language-json">
{
    "id": 6
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
            <td>app/testings/activateResults</td>
            <td>Post</td>
            <td>
<pre>
<code class="language-json">
{
    "activate_id": 3
}
</code>
</pre>
            </td>

            <td>
<pre>
<code class="language-json">
[
    {
        "id": 1,
        "hash": "wfsdfsd",
        "activate_id": 3,
        "user_id": 1,
        "ip": "127.0.0.1",
        "json_answers": [
            {
                "id": 1 (question id),
                "answers": [
                    {
                        "id": 1 (question->json_answers[id]),
                        "checked": true
                    },
                    {
                        "id": 0,
                        "checked": false
                    }
                ]
            },
            {
                "id": 4,
                "answers": [
                    {
                        "id": 0,
                        "checked": true
                    },
                    {
                        "id": 1,
                        "checked": false
                    }
                ]
            },
            ...
        ],
        "start_time": "2022-05-11 00:00",
        "completion_time": "2022-05-11 01:00",
        "rating": 6
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
            <td>app/result</td>
            <td>Post</td>
            <td>
<pre>
<code class="language-json">
{
    "result_id": 3
}
</code>
</pre>
            </td>

            <td>
<pre>
<code class="language-json">
{
    "id": 3,
    "hash": "C044yHr5N9OZFJFb",
    "activate_id": 3,
    "user_id": 1,
    "ip": "127.0.0.1",
    "json_answers": [
        {
            "id": 1,
            "answers": [
                {
                    "id": 1,
                    "checked": true
                },
                {
                    "id": 0,
                    "checked": false
                }
            ]
        },
        {
            "id": 4,
            "answers": [
                {
                    "id": 0,
                    "checked": true
                },
                {
                    "id": 1,
                    "checked": false
                }
            ]
        },
        ...
    ],
    "start_time": "2022-05-10 22:00",
    "completion_time": "2022-05-10 22:00",
    "rating": 22,
    "activate_testing": {
        "id": 3,
        "testing_id": 1,
        "user_id": 1,
        "start_time": "2022-05-08 20:00",
        "end_time": null,
        "title": "543hfghf45",
        "access_code": "qJhSWQiM",
        "show_user_answers": 1,
        "show_correct_answers": 1,
        "max_rating": 44,
        "testing": {
            "id": 1,
            "title": "fghdfghdfghdfg",
            "description": "dfghdfh",
            "created_at": "2022-05-08 09:00",
            "updated_at": "2022-05-08 09:00"
        }
    }
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
            <td>app/results</td>
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
        "hash": "wfsdfsd",
        "activate_id": 3,
        "user_id": 1,
        "ip": "127.0.0.1",
        "json_answers": [
            {
                "id": 1,
                "answers": [
                    {
                        "id": 1,
                        "checked": true
                    },
                    {
                        "id": 0,
                        "checked": false
                    }
                ]
            },
            {
                "id": 4,
                "answers": [
                    {
                        "id": 0,
                        "checked": true
                    },
                    {
                        "id": 1,
                        "checked": false
                    }
                ]
            }
        ],
        "start_time": "2022-05-11 00:00",
        "completion_time": "2022-05-11 01:00",
        "rating": 6
    },
    ... (all user results)
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

        </tbody>
    </table>
</div>






    <div id="passing">
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
                <td>app/test/connect</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-json">

{
    "code": "qJhSWQiM"
}
</code>
</pre>
                </td>

                <td>
<pre>
<code class="language-json">
{
    "hash": "QdIFFk5UfA5uH0Ab",
    "activate_id": 3,
    "user_id": 1,
    "ip": "127.0.0.1",
    "start_time": "2022-05-11 21:00",
    "json_answers": [
        {
            "id": 1,
            "answers": [
                {
                    "id": 1,
                    "checked": false
                },
                {
                    "id": 0,
                    "checked": false
                }
            ]
        },
        {
            "id": 4,
            "answers": [
                {
                    "id": 0,
                    "checked": false
                },
                {
                    "id": 1,
                    "checked": false
                }
            ]
        }
    ],
    "id": 9
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
                <td>app/test/updateJsonProgress</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-json">
{
    "result_id": 9,
    "json_answers": [
        {
            "id": 1,
            "answers": [
                {
                    "id": 1,
                    "checked": true
                },
                {
                    "id": 0,
                    "checked": false
                }
            ]
        },
        {
            "id": 4,
            "answers": [
                {
                    "id": 0,
                    "checked": true
                },
                {
                    "id": 1,
                    "checked": false
                }
            ]
        },
        .. (all questions answers)
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
                <td>app/test/complete</td>
                <td>Post</td>
                <td>
<pre>
<code class="language-json">
{
    "result_id": 9,
    "json_answers": [
        {
            "id": 1,
            "answers": [
                {
                    "id": 1,
                    "checked": true
                },
                {
                    "id": 0,
                    "checked": false
                }
            ]
        },
        {
            "id": 4,
            "answers": [
                {
                    "id": 0,
                    "checked": true
                },
                {
                    "id": 1,
                    "checked": false
                }
            ]
        },
        ... (all questions answers)
    ]
}
</code>
</pre>
                </td>

                <td>
<pre>
<code class="language-json">
{
    "id": 9,
    "hash": "QdIFFk5UfA5uH0Ab",
    "activate_id": 3,
    "user_id": 1,
    "ip": "127.0.0.1",
    "json_answers": [
        {
            "id": 1,
            "answers": [
                {
                    "id": 1,
                    "checked": true
                },
                {
                    "id": 0,
                    "checked": false
                }
            ]
        },
        {
            "id": 4,
            "answers": [
                {
                    "id": 0,
                    "checked": true
                },
                {
                    "id": 1,
                    "checked": false
                }
            ]
        }
    ],
    "start_time": "2022-05-11 21:00",
    "completion_time": "2022-05-11 21:00",
    "rating": 22,
    "activate_testing": {
        "id": 3,
        "testing_id": 1,
        "user_id": 1,
        "start_time": "2022-05-08 20:00",
        "end_time": null,
        "title": "543hfghf45",
        "access_code": "qJhSWQiM",
        "show_user_answers": 1,
        "show_correct_answers": 1,
        "max_rating": 44
    }
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

