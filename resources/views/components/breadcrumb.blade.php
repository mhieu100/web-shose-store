{{-- Breadcrumb Component --}}
@props(['items' => []])

<div class="modern-breadcrumb">
    <div class="container">
        <div class="breadcrumb-wrapper">
            <div class="breadcrumb-path">
                @foreach($items as $index => $item)
                    @if($index > 0)
                        <span class="breadcrumb-separator">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif

                    @if(isset($item['url']) && !($item['active'] ?? false))
                        <a href="{{ $item['url'] }}" class="breadcrumb-item">
                            @if(isset($item['icon']))
                                <i class="fas fa-{{ $item['icon'] }}"></i>
                            @endif
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @else
                        <span class="breadcrumb-item active">
                            @if(isset($item['icon']))
                                <i class="fas fa-{{ $item['icon'] }}"></i>
                            @endif
                            <span>{{ $item['label'] }}</span>
                        </span>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
