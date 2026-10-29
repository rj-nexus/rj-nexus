@php
    $title       = $settings['title'] ?? '';
    $subtitle    = $settings['subtitle'] ?? '';
    $placeholder = $settings['placeholder'] ?? __('Enter your email');
    $btnLabel    = $settings['btn_label'] ?? __('Subscribe');
    $successMsg  = $settings['success_msg'] ?? __('Thanks for subscribing!');
    $layout      = $settings['layout'] ?? 'inline';
    $align       = $settings['align'] ?? 'left';
    $accent      = $settings['accent'] ?? '#8b5cf6';
    $textColor   = $settings['text_color'] ?? '#ffffff';
    $mutedColor  = $settings['muted_color'] ?? '#94a3b8';
    $inputBg     = $settings['input_bg'] ?? '#1e293b';
    $radius      = $settings['radius'] ?? 'md';

    $radiusMap = ['none' => '0px', 'sm' => '6px', 'md' => '10px', 'lg' => '14px', 'full' => '9999px'];
    $radiusCss = $radiusMap[$radius] ?? '10px';

    $justify = 'flex-start';
    $textAlign = 'left';
    if ($align === 'center') {
        $justify = 'center';
        $textAlign = 'center';
    } elseif ($align === 'right') {
        $justify = 'flex-end';
        $textAlign = 'right';
    }

    $formDir = $layout === 'inline' ? 'row' : 'column';
@endphp

<style>
    #{{ $uid }} {
        width: 100%;
    }
    #{{ $uid }} .rj-fn-head {
        text-align: {{ $textAlign }};
        margin-bottom: 16px;
    }
    #{{ $uid }} .rj-fn-title {
        font-size: 18px;
        font-weight: 700;
        color: {{ $textColor }};
        margin: 0 0 6px;
        letter-spacing: -.01em;
    }
    #{{ $uid }} .rj-fn-sub {
        font-size: 13px;
        color: {{ $mutedColor }};
        margin: 0;
        line-height: 1.5;
    }

    #{{ $uid }} .rj-fn-form {
        display: flex;
        flex-direction: {{ $formDir }};
        gap: 10px;
        justify-content: {{ $justify }};
        align-items: {{ $layout === 'inline' ? 'stretch' : 'stretch' }};
        max-width: {{ $layout === 'inline' ? '100%' : '400px' }};
        margin: {{ $align === 'center' ? '0 auto' : ($align === 'right' ? '0 0 0 auto' : '0') }};
    }
    #{{ $uid }} .rj-fn-input {
        flex: 1;
        min-width: 0;
        padding: 12px 16px;
        font-size: 14px;
        background: {{ $inputBg }};
        color: {{ $textColor }};
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: {{ $radiusCss }};
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        font-family: inherit;
    }
    #{{ $uid }} .rj-fn-input::placeholder {
        color: {{ $mutedColor }};
        opacity: 0.7;
    }
    #{{ $uid }} .rj-fn-input:focus {
        border-color: {{ $accent }};
        box-shadow: 0 0 0 3px color-mix(in srgb, {{ $accent }} 25%, transparent);
    }
    #{{ $uid }} .rj-fn-btn {
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 700;
        color: #ffffff;
        background: {{ $accent }};
        border: 0;
        border-radius: {{ $radiusCss }};
        cursor: pointer;
        transition: opacity 0.2s ease, transform 0.15s ease;
        font-family: inherit;
        white-space: nowrap;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    #{{ $uid }} .rj-fn-btn:hover {
        opacity: 0.9;
    }
    #{{ $uid }} .rj-fn-btn:active {
        transform: scale(0.98);
    }
    #{{ $uid }} .rj-fn-btn:disabled {
        opacity: 0.6;
        cursor: wait;
    }
    #{{ $uid }} .rj-fn-spin {
        width: 14px;
        height: 14px;
        animation: rjFnSpin 0.8s linear infinite;
        display: none;
    }
    @keyframes rjFnSpin {
        to { transform: rotate(360deg); }
    }

    #{{ $uid }} .rj-fn-msg {
        display: none;
        margin-top: 12px;
        font-size: 13px;
        font-weight: 500;
        text-align: {{ $textAlign }};
    }
    #{{ $uid }} .rj-fn-msg.is-error {
        display: block;
        color: #fca5a5;
    }
    #{{ $uid }} .rj-fn-msg.is-success {
        display: block;
        color: #86efac;
    }

    @media (max-width: 640px) {
        #{{ $uid }} .rj-fn-form {
            flex-direction: column;
        }
        #{{ $uid }} .rj-fn-btn {
            width: 100%;
        }
    }
</style>

<div id="{{ $uid }}">
    @if($title || $subtitle)
        <div class="rj-fn-head">
            @if($title)
                <h3 class="rj-fn-title">{{ $title }}</h3>
            @endif
            @if($subtitle)
                <p class="rj-fn-sub">{{ $subtitle }}</p>
            @endif
        </div>
    @endif

    <form class="rj-fn-form" data-form>
        <input type="email" class="rj-fn-input" placeholder="{{ $placeholder }}" required data-email>
        <button type="submit" class="rj-fn-btn" data-btn>
            <svg class="rj-fn-spin" data-spinner fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg>
            <span data-btn-text>{{ $btnLabel }}</span>
        </button>
    </form>

    <div class="rj-fn-msg" data-msg></div>
</div>

<script>
(function() {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var form = root.querySelector('[data-form]');
    var emailInput = root.querySelector('[data-email]');
    var btn = root.querySelector('[data-btn]');
    var btnText = root.querySelector('[data-btn-text]');
    var spinner = root.querySelector('[data-spinner]');
    var msg = root.querySelector('[data-msg]');

    var originalText = btnText.textContent;
    var successMsg = @js($successMsg);

    function showMsg(type, text) {
        msg.className = 'rj-fn-msg is-' + type;
        msg.textContent = text;
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        msg.className = 'rj-fn-msg';

        var email = emailInput.value.trim();
        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showMsg('error', @js(__('Please enter a valid email address.')));
            return;
        }

        btn.disabled = true;
        spinner.style.display = 'block';
        btnText.textContent = '';

        try {
            var res = await fetch(@js(route('rj.widget.newsletter', absolute: false)), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': @js(csrf_token())
                },
                body: JSON.stringify({ email: email })
            });

            var data = await res.json();

            if (res.ok && data.ok) {
                form.style.display = 'none';
                showMsg('success', data.message || successMsg);
            } else {
                showMsg('error', data.message || @js(__('Subscription failed. Please try again.')));
                btn.disabled = false;
                spinner.style.display = 'none';
                btnText.textContent = originalText;
            }
        } catch (err) {
            showMsg('error', @js(__('Network error. Please try again.')));
            btn.disabled = false;
            spinner.style.display = 'none';
            btnText.textContent = originalText;
        }
    });
})();
</script>
