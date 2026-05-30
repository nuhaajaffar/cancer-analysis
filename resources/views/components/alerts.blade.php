@if(session('success'))
    <p style="color: green;">
        {{ session('success') }}
    </p>
@endif

@if($errors->any())
    <p style="color: red;">
        {{ $errors->first() }}
    </p>
@endif