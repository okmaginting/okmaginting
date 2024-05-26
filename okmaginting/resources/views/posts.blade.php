<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel AJAX CRUD with Tailwind CSS</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-4">Laravel AJAX CRUD</h2>

    <form id="postForm" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                Title
            </label>
            <input type="text" id="title" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="content">
                Content
            </label>
            <textarea id="content" name="content" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Submit
            </button>
        </div>
    </form>

    <table class="min-w-full bg-white">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">ID</th>
                <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Title</th>
                <th class="w-1/2 py-3 px-4 uppercase font-semibold text-sm">Content</th>
                <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Actions</th>
            </tr>
        </thead>
        <tbody id="postsTable" class="text-gray-700">
            <!-- Data will be populated here -->
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        fetchPosts();

        function fetchPosts() {
            $.ajax({
                url: "{{ route('posts.index') }}",
                type: "GET",
                success: function(response) {
                    let postsTable = '';
                    response.forEach(post => {
                        postsTable += `<tr>
                            <td class="border px-4 py-2">${post.id}</td>
                            <td class="border px-4 py-2">${post.title}</td>
                            <td class="border px-4 py-2">${post.content}</td>
                            <td class="border px-4 py-2">
                                <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-4 rounded btn-edit" data-id="${post.id}">Edit</button>
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded btn-delete" data-id="${post.id}">Delete</button>
                            </td>
                        </tr>`;
                    });
                    $('#postsTable').html(postsTable);
                }
            });
        }

        $('#postForm').submit(function(e) {
            e.preventDefault();
            let title = $('#title').val();
            let content = $('#content').val();
            $.ajax({
                url: "{{ route('posts.store') }}",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    title: title,
                    content: content
                },
                success: function(response) {
                    $('#postForm')[0].reset();
                    fetchPosts();
                }
            });
        });

        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            $.ajax({
                url: `{{ url('posts') }}/${id}`,
                type: "GET",
                success: function(response) {
                    $('#title').val(response.title);
                    $('#content').val(response.content);
                    $('#postForm').off('submit').submit(function(e) {
                        e.preventDefault();
                        $.ajax({
                            url: `{{ url('posts') }}/${id}`,
                            type: "PUT",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                title: $('#title').val(),
                                content: $('#content').val()
                            },
                            success: function(response) {
                                $('#postForm')[0].reset();
                                fetchPosts();
                                $('#postForm').off('submit').submit(function(e) {
                                    e.preventDefault();
                                    storePost();
                                });
                            }
                        });
                    });
                }
            });
        });

        $(document).on('click', '.btn-delete', function() {
            let id = $(this).data('id');
            $.ajax({
                url: `{{ url('posts') }}/${id}`,
                type: "DELETE",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    fetchPosts();
                }
            });
        });
    });
</script>
</body>
</html>
