<div class="container">
    <h1>Global Variables</h1>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('global_variables.store') }}">
        @csrf
        <label for="key">Key:</label>
        <input type="text" id="key" name="key" required>
        <label for="value">Value:</label>
        <input type="text" id="value" name="value" required>
        <button type="submit">Save</button>
    </form>

    <h2>Existing Variables</h2>
    <ul>
        @foreach($variables as $key => $value)
            <li>
                <strong>{{ $key }}:</strong> {{ $value }}
                <form method="POST" action="{{ route('global_variables.destroy', $key) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>

