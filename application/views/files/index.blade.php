@layout('layouts.default')

@section('content')

	@foreach ($main_level as $dir)

		<h2>{{ $dir['dir'] }}</h2>
		<ul>
		@foreach ($dir['subdir'] as $subdir)
			<li>{{ HTML::link('content/'.$dir['dir'].'/'.$subdir, $subdir) }}</li>
		@endforeach
		</ul>
	@endforeach

@endsection