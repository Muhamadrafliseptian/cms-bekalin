<div class="section-header-breadcrumb">
    @foreach ($items as $item)
        <div class="breadcrumb-item {{ $loop->last ? '' : 'active' }}">
            @if (isset($item['url']))
                <a href="{{ $item['url'] }} active">{{ $item['title'] }}</a>
            @else
                {{ $item['title'] }}
            @endif
        </div>
    @endforeach
</div>
