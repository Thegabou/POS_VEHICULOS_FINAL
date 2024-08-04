<div class="container">
    @if(isset($message))
        <h1>{{ $message }}</h1>
    @else
        <h1>Global Variables</h1>

        <div id="message"></div>

        <form id="globalVariableForm" action="{{route('global_variables.store')}}" method="POST">
            @csrf
            <label for="key">Key:</label>
            <input type="text" id="key" name="key" required>
            <label for="value">Value:</label>
            <input type="text" id="value" name="value" required>
            <button type="submit">Save</button>
        </form>

        <h2>Existing Variables</h2>
        <ul id="variablesList">
            @foreach($variables as $key => $value)
                <li id="variable-{{ $key }}">
                    <strong>{{ $key }}:</strong> {{ $value }}
                    <button class="deleteVariable" data-key="{{ $key }}">Delete</button>
                </li>
            @endforeach
        </ul>

    @endif
</div>

<script src="{{ asset('js/admin-var.js') }}"></script>

