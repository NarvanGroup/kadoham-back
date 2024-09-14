<div>
    <ul>
        @if($getState())
            @foreach($getState() as $variable => $value)
                <li>
                    <strong>{{ $variable }}:</strong>
                    @if(is_array($value) || is_object($value))
                        <pre>{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                    @elseif(is_null($value))
                        null
                    @else
                        {{ $value }}
                    @endif
                </li>
            @endforeach
        @endif
    </ul>
</div>
