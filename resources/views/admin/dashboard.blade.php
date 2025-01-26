<h1>Admin Dashboard</h1>
<table>
    <thead>
        <tr>
            <th>Task</th>
            <th>User</th>
            <th>Category</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->task }}</td>
                <td>{{ $task->user->name }}</td>
                <td>{{ $task->category->name }}</td>
                <td>{{ $task->completed ? 'Completed' : 'Pending' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
