@php $pinfo = $platforms[$it['platform']]; @endphp

<a href="{{ $it['url'] ?: '#' }}"
   class="rj-sf-card"
   data-platform="{{ $it['platform'] }}"
   @if($it['url']) target="_blank" rel="noopener noreferrer" @endif>
    <img src="{{ $it['image'] }}" alt="" class="rj-sf-card-img" loading="lazy">

    <div class="rj-sf-card-veil">
        <div class="rj-sf-card-top">
            @if($showPlatform)
                <span class="rj-sf-badge" style="--badge-color: {{ $pinfo['color'] }};">
                    @if(!empty($pinfo['svg']))
                        {!! $pinfo['svg'] !!}
                    @elseif(!empty($pinfo['image']))
                        <img src="{{ $pinfo['image'] }}" alt="{{ $pinfo['name'] }}" loading="lazy" onerror="this.closest('.rj-sf-badge').classList.add('is-fallback')">
                    @endif
                    <span class="rj-sf-badge-fallback">{{ $pinfo['fallback'] }}</span>
                </span>
            @else
                <span></span>
            @endif

            @if($showDate && $it['date'] !== '')
                <span class="rj-sf-card-date">{{ $it['date'] }}</span>
            @endif
        </div>

        @if($showCaption && $it['caption'] !== '')
            <p class="rj-sf-card-caption">{{ $it['caption'] }}</p>
        @endif
    </div>
</a>
