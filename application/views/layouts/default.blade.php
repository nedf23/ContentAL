<!doctype html>
<html>
<head>
	<title>{{ $title }}</title>
    {{ HTML::style('css/main.css') }}
</head>
<body>
    <header>
        <h1>Learning Resources</h1>
    </header>
	<article>
		@yield('content')
	</article>
</body>
</html>