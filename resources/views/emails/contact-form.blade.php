<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            margin: -30px -30px 30px -30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .field {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e5e5;
        }
        .field:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: 600;
            color: #667eea;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .value {
            color: #333;
            font-size: 16px;
            word-wrap: break-word;
        }
        .message-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #667eea;
            margin-top: 10px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e5e5;
            font-size: 12px;
            color: #999;
            text-align: center;
        }
        .meta-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
            font-size: 13px;
            color: #666;
        }
        .meta-info strong {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 New Contact Form Submission</h1>
        </div>

        <div class="field">
            <div class="label">From</div>
            <div class="value">{{ $contact->name }}</div>
        </div>

        <div class="field">
            <div class="label">Email Address</div>
            <div class="value">
                <a href="mailto:{{ $contact->email }}" style="color: #667eea; text-decoration: none;">
                    {{ $contact->email }}
                </a>
            </div>
        </div>

        <div class="field">
            <div class="label">Subject</div>
            <div class="value">{{ $contact->subject }}</div>
        </div>

        <div class="field">
            <div class="label">Message</div>
            <div class="message-box">
                {!! nl2br(e($contact->message)) !!}
            </div>
        </div>

        <div class="meta-info">
            <strong>Submission Details:</strong><br>
            📅 Received: {{ $contact->created_at->format('F j, Y \a\t g:i A') }}<br>
            🌐 IP Address: {{ $contact->ip_address ?? 'N/A' }}<br>
            💻 User Agent: {{ $contact->user_agent ? Str::limit($contact->user_agent, 80) : 'N/A' }}
        </div>

        <div class="footer">
            <p>This email was sent from the contact form on {{ config('app.name') }}</p>
            <p>To reply to this message, click the reply button in your email client.</p>
        </div>
    </div>
</body>
</html>
