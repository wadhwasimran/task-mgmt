@extends('common/common')

@section('content')
    <!-- Form to add a new task -->
    <input type="text" id="taskInput" placeholder="Enter task">
    <button id="enterButton">Enter</button>

    <!-- List to display tasks -->
    <table id="taskList" border="1px solid #000">
        <tr>
            <th>Task</th>
            <th>Status</th>
            <th>Action</th>

        </tr>
        @if(isset($task) && count($task) > 0 )
            @foreach ($task as $key => $taskData)
                <tr>
                    <td>
                        {{$taskData->task}}
                    </td>
                    <td>
                        {{$taskData->status==1 ? 'Done' : 'Not Done'}}
                    </td>
                    <td>
                        <input type="checkbox" class="taskCheckbox" data-task-id="{{ $taskData->id}}" {{ $taskData->status==1 ? ' checked' : ''}} > <button class="deleteButton" data-task-id="{{ $taskData->id}}">Delete</button>
                    </td>
                </tr>
            @endforeach
            <tr>
            </tr>
        @endif
     
        
    </table>

    <!-- Button to show all tasks -->
    <button id="showAllButton">Show All Tasks</button>
    @include('Tasks.js')

 
@endsection
