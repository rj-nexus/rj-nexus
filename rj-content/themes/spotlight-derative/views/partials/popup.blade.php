@php
    $popup = null;
    try {
        $popup = app(\App\Services\PopupResolver::class)->resolve();
    } catch (\Throwable $e) {
        $popup = null;
    }
@endphp

@if($popup)
    @php
        $popupId = 'rj-popup-' . ($popup->id ?? 'default');
        $popupDelay = (int) ($popup->settings['delay'] ?? 1500);
        $popupFrequency = $popup->settings['frequency'] ?? 'session';
        $popupDismissible = ($popup->settings['dismissible'] ?? '1') === '1';
        $popupBackdrop = ($popup->settings['backdrop_close'] ?? '1') === '1';
    @endphp

    <div
        class="rj-popup"
        id="{{ $popupId }}"
        style="display: none; position: fixed; inset: 0; z-index: 1000; align-items: center; justify-content: center; padding: 24px;"
        data-delay="{{ $popupDelay }}"
        data-frequency="{{ $popupFrequency }}"
        data-backdrop-close="{{ $popupBackdrop ? '1' : '0' }}"
        role="dialog"
        aria-modal="true"
        aria-hidden="true"
    >
        <div class="rj-popup-backdrop" style="position: absolute; inset: 0; background: rgba(5,5,8,.82); backdrop-filter: blur(8px);"></div>

        <div class="rj-popup-dialog" role="document" style="position: relative; z-index: 1; width: 100%; max-width: 560px; max-height: calc(100vh - 48px); overflow-y: auto; background: var(--rj-surface); border: 1px solid var(--rj-border); border-radius: var(--rj-radius-lg); box-shadow: 0 32px 80px -20px rgba(0,0,0,.8);">
            @if($popupDismissible)
                <button type="button" class="rj-popup-close" aria-label="{{ __('Close') }}" style="position: absolute; top: 14px; right: 14px; z-index: 2; display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 50%; background: color-mix(in srgb, var(--rj-bg) 70%, transparent); border: 1px solid var(--rj-border); color: var(--rj-muted); cursor: pointer;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            @endif

            <div class="rj-popup-content">
                {!! rj_render_template($popup) !!}
            </div>
        </div>
    </div>

    <style>
        .rj-popup.rj-popup-open { display: flex !important; }
        .rj-popup-content { color: var(--rj-text); font-size: 15px; line-height: 1.65; }
        .rj-popup-content > * { margin: 0; }
        .rj-popup-content img { max-width: 100%; height: auto; border-radius: var(--rj-radius-sm); }
        .rj-popup-content h2, .rj-popup-content h3 { color: var(--rj-text); margin: 0 0 12px; letter-spacing: -.02em; }
        .rj-popup-content p { color: var(--rj-muted); margin: 0 0 16px; }
        .rj-popup-content p:last-child { margin-bottom: 0; }
        .rj-popup-content a { color: var(--rj-primary); text-decoration: underline; text-underline-offset: 3px; }
        .rj-popup-content .rj-form { padding: 32px; }
        .rj-popup-content > div:not([class]) { padding: 32px; }
        @media (max-width: 640px) {
            .rj-popup { padding: 16px; }
            .rj-popup-dialog { max-height: calc(100vh - 32px); }
            .rj-popup-content .rj-form, .rj-popup-content > div:not([class]) { padding: 24px; }
        }
    </style>

    <script>
    (function () {
        var popup = document.getElementById('{{ $popupId }}');
        if (!popup) return;

        var key = 'rj_popup_{{ $popup->id ?? 'default' }}';
        var frequency = popup.dataset.frequency || 'session';
        var delay = parseInt(popup.dataset.delay || '1500', 10);
        var backdropClose = popup.dataset.backdropClose === '1';

        function shouldShow() {
            try {
                if (frequency === 'once') return !localStorage.getItem(key);
                if (frequency === 'session') return !sessionStorage.getItem(key);
                if (frequency === 'always') return true;
            } catch (e) {}
            return true;
        }

        function markSeen() {
            try {
                if (frequency === 'once') localStorage.setItem(key, '1');
                if (frequency === 'session') sessionStorage.setItem(key, '1');
            } catch (e) {}
        }

        function open() {
            popup.style.display = 'flex';
            popup.classList.add('rj-popup-open');
            popup.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            markSeen();
        }

        function close() {
            popup.style.display = 'none';
            popup.classList.remove('rj-popup-open');
            popup.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        var closeBtn = popup.querySelector('.rj-popup-close');
        if (closeBtn) closeBtn.addEventListener('click', close);

        if (backdropClose) {
            var backdrop = popup.querySelector('.rj-popup-backdrop');
            if (backdrop) backdrop.addEventListener('click', close);
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && popup.classList.contains('rj-popup-open')) close();
        });

        if (shouldShow()) {
            setTimeout(open, delay);
        }
    })();
    </script>
@endif
