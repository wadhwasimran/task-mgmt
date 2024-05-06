<script>
    // JavaScript to interact with tasks using AJAX
    $(document).ready(function() {
        // Function to fetch all tasks and display them
        function fetchTasks() {
            $.ajax({
                url: '/getTasks',
                method: 'GET',
                success: function(response) {
                    $('#taskList').empty();
                    $('#taskList').append('<tr><th>Task</th><th>Status</th><th>Action</th></tr>');
                    response.forEach(function(task) {
                        $('#taskList').append('<tr><td>' + (task.task)  +'</td><td>' + (task.status==1 ? 'Done' : 'Not Done') +'</td><td><input type="checkbox" class="taskCheckbox" data-task-id="' + task.id + '"' + (task.status==1 ? ' checked' : '') + '> <button class="deleteButton" data-task-id="' + task.id + '">Delete</button></td></tr>');
                    });
                }
            });
        }

        $('#enterButton').click(function() {
                var task = $('#taskInput').val();
                $.ajax({
                    url: '/tasks/store',
                    method: 'POST',
                    data: { task: task },
                    success: function(response) {
                        console.log(response);
                        $('#taskList').append('<tr><td>' + (response.task)  +'</td><td>' + (response.status==1 ? 'Done' : 'Not Done') +'</td><td><input type="checkbox" class="taskCheckbox" data-task-id="' + response.id + '"' + (response.status==1 ? ' checked' : '') + '> <button class="deleteButton" data-task-id="' + response.id + '">Delete</button></td></tr>');
                        $('#taskInput').val('');
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status == 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';
                            for (var key in errors) {
                                errorMessage += errors[key][0] + '\n';
                            }

                            alert(errorMessage);
                        } else {
                            console.error(error);
                        }
                    }
                });
        });

        $(document).on('change', '.taskCheckbox', function() {
                var taskId = $(this).data('task-id');
                var completed = $(this).is(':checked');
                if(completed){
                    $.ajax({
                    url: '/tasks/' + taskId,
                    method: 'PUT',
                    data: { completed: 1 },
                    success: function(response) {
                        $('button[data-task-id="' + taskId + '"]').closest('tr').remove();
                    }
                });
                }
              
        });  


        $(document).on('click', '.deleteButton', function() {
                var taskId = $(this).data('task-id');
                if (confirm('Are you sure to delete this task?')) {
                    $.ajax({
                        url: '/tasks/' + taskId,
                        method: 'DELETE',
                        success: function(response) {
                            fetchTasks(); // Refresh the task list
                        }
                    });
                }
            });
        // fetchTasks();
        $('#showAllButton').click(function() {
                fetchTasks();
        });
    });

</script>