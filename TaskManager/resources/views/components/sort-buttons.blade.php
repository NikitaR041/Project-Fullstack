@props([
    'baseRoute' => 'dashboard',
    'sortParam' => 'sort',
    'currentSort' => 'latest',
    'options' => []
])

<div class="sort-buttons">
    @foreach($options as $value => $label)
        <form action="{{ route($baseRoute) }}" method="GET" class="sort-form">
            @foreach(request()->except($sortParam) as $key => $val)
                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
            @endforeach
            <input type="hidden" name="{{ $sortParam }}" value="{{ $value }}">
            <button type="submit" class="btn btn-sm {{ $currentSort === $value ? 'btn-primary' : 'btn-outline-secondary' }}">
                {{ $label }}
            </button>
        </form>
    @endforeach
</div>
