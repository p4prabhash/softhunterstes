<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">To-Do List Application</h1>

        <div class="card p-4 mt-4">
            <h4>Add a Task</h4>
            <form id="todo-form">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="" selected disabled>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="form-control" id="task" name="task" placeholder="Type todo item name" required>
                    </div>
                    <div class="col-md-3">
                        <button type="button" id="add-task" class="btn btn-success w-100">Add</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card p-4 mt-4">
            <h4>To-Do List</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Todo Item Name</th>
                        <th>Category</th>
                        <th>Timestamp</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="todo-table">
                    @foreach ($todos as $todo)
                        <tr id="todo-{{ $todo->id }}">
                            <td>{{ $todo->task }}</td>
                            <td>{{ $todo->category->name }}</td>
                            <td>{{ $todo->created_at->format('d M Y') }}</td>
                            <td>
                                <button class="btn btn-danger btn-sm delete-task" data-id="{{ $todo->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            let _token = $('meta[name="csrf-token"]').attr('content');

            // Add Task
            $('#add-task').click(function () {
                let task = $('#task').val();
                let category_id = $('#category_id').val();

                if (task && category_id) {
                    $.ajax({
                        url: "{{ route('user.todos.store') }}",
                        method: "POST",
                        data: { task: task, category_id: category_id, _token: _token },
                        success: function (response) {
                           
                            $('#todo-table').append(`
                                <tr id="todo-${response.id}">
                                    <td>${response.task}</td>
                                    <td>${response.category_name}</td>
                                    <td>${response.created_at}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm delete-task" data-id="${response.id}">Delete</button>
                                    </td>
                                </tr>
                            `);
                            
                            $('#task').val('');
                            $('#category_id').val('');
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            alert("An error occurred. Please try again.");
                        }
                    });
                } else {
                    alert("Both fields are required!");
                }
            });

            // Delete Task
            $(document).on('click', '.delete-task', function () {
                let id = $(this).data('id');
                if (confirm("Are you sure you want to delete this task?")) {
                    $.ajax({
                        url: `/user/todos/${id}`,
                        method: "DELETE",
                        data: { _token: _token },
                        success: function () {
                            $(`#todo-${id}`).remove();
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            alert("An error occurred. Please try again.");
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
