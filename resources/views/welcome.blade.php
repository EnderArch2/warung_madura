<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warung Madura - Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Instrument Sans', sans-serif;
        }
        .welcome-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 60px 40px;
            text-align: center;
            max-width: 600px;
            animation: fadeIn 0.6s ease-in;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .welcome-logo {
            font-size: 50px;
            margin-bottom: 20px;
        }
        .welcome-title {
            color: #333;
            font-weight: 600;
            font-size: 36px;
            margin-bottom: 10px;
        }
        .welcome-subtitle {
            color: #666;
            font-size: 16px;
            margin-bottom: 40px;
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: inline-block;
            margin: 10px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .btn-register {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
            margin: 10px;
        }
        .btn-register:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        .user-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #666;
        }
        .dashboard-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 40px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            display: inline-block;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin: 10px;
            border: none;
            cursor: pointer;
        }
        .dashboard-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 15px 40px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            display: inline-block;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin: 10px;
            border: none;
            cursor: pointer;
        }
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.4);
            color: white;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-logo">🏪</div>
        <h1 class="welcome-title">Warung Madura</h1>
        <p class="welcome-subtitle">Management System</p>

        @auth
            <div class="user-info">
                Welcome back, <strong>{{ auth()->user()->name }}</strong>!
                <br>
                You are logged in as <strong>{{ ucfirst(auth()->user()->role) }}</strong>
            </div>
            <div>
                <a href="{{ route('dashboard.index') }}" class="dashboard-btn">
                    Go to Dashboard
                </a>
            </div>
            <br>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">
                    Sign Out
                </button>
            </form>
        @else
            <p style="color: #999; margin-bottom: 30px; font-size: 14px;">
                Manage your business operations efficiently
            </p>
            <div>
                <a href="{{ route('login') }}" class="btn-login">Sign In</a>
                <a href="{{ route('register') }}" class="btn-register">Create Account</a>
            </div>
            <p style="color: #999; margin-top: 30px; font-size: 12px;">
                Demo credentials or register to get started
            </p>
        @endauth
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
