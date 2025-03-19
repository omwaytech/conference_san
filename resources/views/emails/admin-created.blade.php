<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$subject}}</title>
</head>
<body>
    <div>
        <h3>Dear, {{$data['name']}}</h3>
    </div>
    <br>
    <div>
        <p>We hope this message finds you well. We want to inform you that you are assigned as {{$data['role'] == 2 ? "'Scientific Committee'" : "'Expert'"}} for a conference to be held in our society.</p>
        <p>Following are your details to login into conference dashboard. Thank You.</p>
    </div>
    <br>
    <div>
        <p><a href="{{config('app.url')}}/login" target="_blank">Click here for login</a></p>
        <p>Email: {{$data['email']}}</p>
        <p>Password: {{$data['password']}}</p>
    </div>
    <br>
    <div>
        <p>Best Regards,</p>
        <p>SANCON Conference</p>
    </div>
</body>
</html>
