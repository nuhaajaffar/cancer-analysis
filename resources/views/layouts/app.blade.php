<!DOCTYPE html>
<html>
<head>
    <title>Hospital System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f5f5f5;
        }
        nav {
            background: #1f2937;
            color: white;
            padding: 15px 30px;
        }
        nav a {
            color: white;
            margin-right: 15px;
            text-decoration: none;
        }
        .container {
            width: 80%;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
        }
        .btn {
            display: inline-block;
            padding: 8px 14px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-danger {
            background: #dc2626;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0 16px;
        }
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('home') }}">Home</a>

        @if(session()->has('user_id'))

            @php
                $isStaff = in_array(session('user_role'), [
                    'admin',
                    'doctor',
                    'radiographer',
                    'radiologist'
                ]);
            @endphp

            <a href="{{ route('dashboard') }}">Dashboard</a>

            @if($isStaff)
                <a href="{{ route('patients.index') }}">Patients</a>
                <a href="{{ route('appointments.index') }}">Appointments</a>
            @endif

            @if(session('user_role') === 'patient')
                <a href="{{ route('patients.my-records') }}">My Records</a>
            @endif

            <span style="margin-right: 15px;">
                Logged in as {{ session('user_name') }}
                ({{ session('user_role') }})
            </span>

            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>

        @else

            <a href="{{ route('login') }}">Login</a>

        @endif
    </nav>

    <div class="container">
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

        @yield('content')
    </div>
    
</body>
</html>