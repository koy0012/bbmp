<!DOCTYPE html>
<html lang="en">

<head>
    <title>Membership Approval</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container-fluid p-5 bg-dark text-white text-center">
        <h1>Membership Request Approved</h1>
    </div>

    <div class="container mt-5">

        <p>Dear {{$name}},</p>

        <p>Congratulations! Your membership request for {{$organization}} has been approved. We're thrilled to welcome you to our community.</p>

        <p>We've generated a unique ID for you. You can find it and explore your membership details by following this link - <a href="{{$generated_id_link}}" target="_blank">{{$generated_id_link}}</a>
        <p>

        <p>
            Feel free to explore upcoming events and resources on {{$website}}.
        </p>

        <p>Looking forward to your active participation!</p>

        <p>Best Regards,
            <br>{{$approver['name']}}
            <br>{{$approver['position'] ?? 'Review Officer'}} / {{$approver['role']}} Officer 
            <br>{{$organization}}
        </p>


    </div>

</body>

</html>