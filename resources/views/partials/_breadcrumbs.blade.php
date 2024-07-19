<ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
    @foreach(request()->breadcrumbs()->segments() as $segment)
        <li class="breadcrumb-item">
            <a href="{{ $segment->url() }}">
                {{ optional($segment->model())->title ?: $segment->name() }}
            </a>
        </li>
    @endforeach
</ol>
