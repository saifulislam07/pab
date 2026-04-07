<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to PAB</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f7f9;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        .header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .content {
            padding: 40px;
        }
        .welcome-text {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1e293b;
        }
        .credentials {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 25px;
            margin: 25px 0;
        }
        .credential-item {
            margin-bottom: 15px;
        }
        .credential-item:last-child {
            margin-bottom: 0;
        }
        .label {
            display: block;
            font-size: 12px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .value {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            font-family: 'Courier New', Courier, monospace;
        }
        .cta-button {
            display: inline-block;
            background-color: #3b82f6;
            color: #ffffff !important;
            padding: 14px 28px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 700;
            text-align: center;
            margin-top: 10px;
            transition: background-color 0.2s;
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            background-color: #f8fafc;
        }
        .note {
            font-size: 13px;
            color: #64748b;
            margin-top: 20px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Photography Association of Bangladesh</h1>
        </div>
        <div class="content">
            <div class="welcome-text">স্বাগতম! {{ $user->name }}</div>
            <p>আপনার অ্যাকাউন্টটি সফলভাবে তৈরি করা হয়েছে। আপনি এখন আমাদের সদস্য পোর্টালে লগইন করতে পারবেন।</p>
            
            <div class="credentials">
                <div class="credential-item">
                    <span class="label">ইমেইল / ইউজার আইডি</span>
                    <span class="value">{{ $user->email }}</span>
                </div>
                <div class="credential-item">
                    <span class="label">পাসওয়ার্ড</span>
                    <span class="value">{{ $password }}</span>
                </div>
            </div>

            <p>অনুগ্রহ করে নিচের বাটনে ক্লিক করে লগইন করুন এবং আপনার প্রোফাইলটি আপডেট করুন।</p>
            
            <a href="{{ url('/login') }}" class="cta-button">লগইন করুন</a>

            <div class="note">
                নির্দেশনা: নিরাপত্তার স্বার্থে লগইন করার পর আপনার পাসওয়ার্ড পরিবর্তন করে নিন।
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Photography Association of Bangladesh. সকল স্বত্ব সংরক্ষিত।
        </div>
    </div>
</body>
</html>
