@php
    $style = $settings['style'] ?? 'underline';
    $align = $settings['align'] ?? 'left';
    $activeColor = $settings['active_color'] ?? '#8b5cf6';
    $inactiveColor = $settings['inactive_color'] ?? '#64748b';
    $textColor = $settings['text_color'] ?? '#334155';

    $alignClass = $align === 'center' ? 'justify-center' : 'justify-start';
@endphp

<style>
    #{{ $uid }} .rj-tab-btn {
        color: {{ $inactiveColor }};
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    #{{ $uid }} .rj-tab-btn:hover {
        color: {{ $activeColor }};
    }

    @if($style === 'underline')
        #{{ $uid }} .rj-tab-btn {
            border-bottom: 2px solid transparent;
            padding-bottom: 10px;
        }
        #{{ $uid }} .rj-tab-btn.is-active {
            color: {{ $activeColor }} !important;
            border-bottom-color: {{ $activeColor }};
        }
    @elseif($style === 'pills')
        #{{ $uid }} .rj-tab-btn {
            border-radius: 9999px;
            padding: 10px 24px;
        }
        #{{ $uid }} .rj-tab-btn:hover {
            background-color: rgba(0,0,0,0.05);
        }
        #{{ $uid }} .rj-tab-btn.is-active {
            color: #ffffff !important;
            background-color: {{ $activeColor }} !important;
        }
    @elseif($style === 'boxed')
        #{{ $uid }} .rj-tab-btn {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 24px;
            background-color: #f8fafc;
        }
        #{{ $uid }} .rj-tab-btn.is-active {
            color: #ffffff !important;
            background-color: {{ $activeColor }} !important;
            border-color: {{ $activeColor }} !important;
        }
    @endif

    #{{ $uid }} .rj-tab-pane {
        display: none;
        animation: rjFadeIn-{{ $uid }} 0.4s ease-in-out forwards;
    }
    #{{ $uid }} .rj-tab-pane.is-active {
        display: block;
    }

    @keyframes rjFadeIn-{{ $uid }} {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div id="{{ $uid }}" class="w-full py-8">
    <!-- Tab Navigation -->
    <div class="flex flex-wrap gap-4 md:gap-8 mb-8 border-b border-slate-200 pb-2 {{ $alignClass }}">
        @foreach($tabs as $index => $tab)
            <button type="button"
                    class="rj-tab-btn text-sm md:text-base font-bold focus:outline-none {{ $index === 0 ? 'is-active' : '' }}"
                    data-target="pane-{{ $index }}">
                @if(!empty($tab['icon']))
                    {!! rj_icon($tab['icon'], 'w-5 h-5') !!}
                @endif
                <span>{{ $tab['title'] }}</span>
            </button>
        @endforeach
    </div>

    <!-- Tab Content -->
    <div class="rj-tab-content w-full" style="color: {{ $textColor }};">
        @foreach($tabs as $index => $tab)
            <div id="pane-{{ $index }}" class="rj-tab-pane {{ $index === 0 ? 'is-active' : '' }}">
                <div class="prose prose-slate max-w-none">
                    {!! $tab['content'] !!}
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
(function() {
    function initTabs_{{ str_replace('-', '_', $uid) }}() {
        const root = document.getElementById('{{ $uid }}');
        if (!root || root.dataset.initialized) return;
        root.dataset.initialized = 'true';

        const buttons = root.querySelectorAll('.rj-tab-btn');
        const panes = root.querySelectorAll('.rj-tab-pane');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.dataset.target;

                buttons.forEach(b => b.classList.remove('is-active'));
                panes.forEach(p => p.classList.remove('is-active'));

                btn.classList.add('is-active');
                const targetPane = root.querySelector('#' + targetId);
                if (targetPane) {
                    targetPane.classList.add('is-active');
                }
            });
        });
    }

    initTabs_{{ str_replace('-', '_', $uid) }}();
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTabs_{{ str_replace('-', '_', $uid) }});
    }
})();
</script>
