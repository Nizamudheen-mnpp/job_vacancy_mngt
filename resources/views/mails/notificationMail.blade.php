<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Notification</title>
</head>
<body>
    <h2>Job Notification</h2>
    <p>Hello {{ $user->name }},</p>
    
    <p>We are excited to inform you about a new job opportunity:</p>
    
    <p><strong>Job Title:</strong> {{ $job->job_name }}</p>
    <p><strong>Description:</strong> {{ $vacancy->description }}</p>
    <p><strong>Start Date:</strong> {{ $vacancy->start_date }}</p>
    <p><strong>End Date:</strong> {{ $vacancy->end_date }}</p>

    <p>Please feel free to reach out if you have any questions or would like more information.</p>

    <p>Best regards,<br>
    ABC Company</p>
</body>
</html>
