
<!DOCTYPE html>

<html>
<head>
<body>

<p style="font-size: 24px"><b>Post New Comment!</b></p>
<script>
$user = Auth::user();
if($user)
{
document.getElementById("login").innerHTML = "Hello $user->name";
}
</script>
<p id="login"></p>
{!! Form::open(array('route' => 'posts.store')) !!}
    {{ Form::label('title', 'Title: ') }}
    {{ Form::text('title', null) }}
    {{ Form::label('posttext', "Post Text: ") }}
    {{ Form::textarea('posttext', null) }}
    {{ Form::submit('Create New Post') }}
{!! Form::close() !!}

</head>
</body>
</html>
