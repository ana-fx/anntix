<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Job Failed</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 32px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .header { background: #dc2626; padding: 24px 32px; }
        .header h1 { color: #fff; margin: 0; font-size: 20px; letter-spacing: 0.5px; }
        .header p { color: #fecaca; margin: 4px 0 0; font-size: 13px; }
        .body { padding: 32px; }
        .alert-box { background: #fef2f2; border-left: 4px solid #dc2626; border-radius: 4px; padding: 16px 20px; margin-bottom: 24px; }
        .alert-box .error-label { font-size: 11px; font-weight: 700; color: #dc2626; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 6px; }
        .alert-box .error-message { font-size: 14px; color: #1f2937; line-height: 1.6; word-break: break-word; }
        .detail-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .detail-table tr { border-bottom: 1px solid #f3f4f6; }
        .detail-table tr:last-child { border-bottom: none; }
        .detail-table td { padding: 10px 0; vertical-align: top; }
        .detail-table td:first-child { color: #6b7280; width: 40%; font-weight: 500; }
        .detail-table td:last-child { color: #111827; font-weight: 600; word-break: break-all; }
        .footer { background: #f9fafb; padding: 16px 32px; border-top: 1px solid #e5e7eb; font-size: 12px; color: #9ca3af; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>&#9888; Queue Job Failed</h1>
            <p>A background job has failed on your server — {{ config('app.name') }}</p>
        </div>

        <div class="body">
            <div class="alert-box">
                <div class="error-label">Error Message</div>
                <div class="error-message">{{ $errorMessage }}</div>
            </div>

            <table class="detail-table">
                <tr>
                    <td>Job Name</td>
                    <td>{{ $jobName }}</td>
                </tr>
                <tr>
                    <td>Queue</td>
                    <td>{{ $queueName }}</td>
                </tr>
                <tr>
                    <td>Connection</td>
                    <td>{{ $connectionName }}</td>
                </tr>
                <tr>
                    <td>Failed At</td>
                    <td>{{ $failedAt }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            This alert was sent automatically by {{ config('app.name') }}. Check your failed_jobs table for details.
        </div>
    </div>
</body>
</html>
