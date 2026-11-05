@php
    $uid = 'contact_' . substr(md5(uniqid('', true)), 0, 8);
    $title = $settings['title'] ?? '';
@endphp

<section class="rj-ct-section" id="{{ $uid }}">
    <div class="rj-ct-bg" aria-hidden="true">
        <span class="rj-ct-blob rj-ct-blob-a"></span>
        <span class="rj-ct-blob rj-ct-blob-b"></span>
    </div>

    <div class="rj-ct-inner">
        <div class="rj-ct-grid">

            <div class="rj-ct-left">
                @if($title)
                    <h2 class="rj-ct-title rj-ct-reveal" style="--i:0;">{{ $title }}</h2>
                @endif

                <div class="rj-ct-list">
                    @if(!empty($settings['office_label']) || !empty($settings['office_address']))
                        <div class="rj-ct-item rj-ct-reveal" style="--i:1;">
                            <span class="rj-ct-label">{{ $settings['office_label'] ?? '' }}</span>
                            <span class="rj-ct-value">{!! nl2br(e($settings['office_address'] ?? '')) !!}</span>
                        </div>
                    @endif

                    @if(!empty($settings['email_label']) || !empty($settings['email_address']))
                        <div class="rj-ct-item rj-ct-reveal" style="--i:2;">
                            <span class="rj-ct-label">{{ $settings['email_label'] ?? '' }}</span>
                            <a href="mailto:{{ $settings['email_address'] ?? '' }}" class="rj-ct-value rj-ct-link">{{ $settings['email_address'] ?? '' }}</a>
                        </div>
                    @endif

                    @if(!empty($settings['phone_label']) || !empty($settings['phone_number']))
                        <div class="rj-ct-item rj-ct-reveal" style="--i:3;">
                            <span class="rj-ct-label">{{ $settings['phone_label'] ?? '' }}</span>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings['phone_number'] ?? '') }}" class="rj-ct-value rj-ct-link">{{ $settings['phone_number'] ?? '' }}</a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="rj-ct-panel rj-ct-reveal" style="--i:2;">
                @if(isset($form) && $form)
                    <form method="POST" action="{{ route('plugin.form.submit', $form->slug) }}" class="rj-custom-form">
                        @csrf

                        @if($errors->any())
                            <div class="rj-form-alert">
                                {{ __('Please check the fields below and try again.') }}
                            </div>
                        @endif

                        <div class="rj-form-row">
                            @foreach($form->fields as $field)
                                @php
                                    $isTextarea = $field->type === 'textarea';
                                    $isCheckbox = $field->type === 'checkbox';
                                    $isFull = $isTextarea || $isCheckbox;

                                    $fieldClass = $isFull ? 'rj-form-col-full' : 'rj-form-col-half';
                                    $inputType = in_array($field->type, ['text', 'email', 'tel', 'url', 'number']) ? $field->type : 'text';
                                @endphp

                                <div class="rj-form-group {{ $fieldClass }} rj-ct-reveal" style="--i: {{ $loop->iteration + 2 }};">
                                    @if(!$isCheckbox)
                                        <label class="rj-form-label">
                                            {{ __($field->label) }}
                                            @if($field->is_required) <span class="rj-req">*</span> @endif
                                        </label>
                                    @endif

                                    @if($isTextarea)
                                        <div class="rj-form-control">
                                            <textarea name="{{ $field->name }}"
                                                      class="rj-form-input rj-form-textarea"
                                                      placeholder="{{ __($field->placeholder) }}"
                                                      {{ $field->is_required ? 'required' : '' }}
                                                      rows="3">{{ old($field->name) }}</textarea>
                                            <span class="rj-form-bar"></span>
                                        </div>

                                    @elseif($isCheckbox)
                                        <label class="rj-form-checkbox-wrap">
                                            <input type="checkbox" name="{{ $field->name }}" value="1" {{ $field->is_required ? 'required' : '' }}>
                                            <span class="rj-form-checkbox-text">
                                                {{ __($field->placeholder ?: $field->label) }}
                                                @if($field->is_required) <span class="rj-req">*</span> @endif
                                            </span>
                                        </label>

                                    @else
                                        <div class="rj-form-control">
                                            <input type="{{ $inputType }}"
                                                   name="{{ $field->name }}"
                                                   class="rj-form-input"
                                                   value="{{ old($field->name) }}"
                                                   placeholder="{{ __($field->placeholder) }}"
                                                   {{ $field->is_required ? 'required' : '' }}>
                                            <span class="rj-form-bar"></span>
                                        </div>
                                    @endif

                                    @if($field->help_text)
                                        <div class="rj-form-help">{{ __($field->help_text) }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="rj-form-actions">
                            <button type="submit" class="rj-form-submit">
                                <span>{{ __('Send') }}</span>
                            </button>
                        </div>
                    </form>
                @else
                    <div class="rj-ct-fallback">
                        <h3 class="rj-fallback-title">{{ __('Form is not configured or plugin is missing.') }}</h3>
                        <p class="rj-fallback-text">{{ __('To display a form here, please ensure the Form Builder plugin is installed and a form is selected in the widget settings.') }}</p>

                        <div class="rj-fallback-links">
                            <a href="https://github.com/mr-ruhid/rj-plugin-form-builder/releases" target="_blank" class="rj-fallback-btn">
                                {{ __('Install Plugin') }}
                            </a>
                        </div>

                        <div class="rj-fallback-support">
                            <p>{{ __('Having issues?') }}</p>
                            <a href="https://github.com/mr-ruhid/rj-plugin-form-builder/discussions/2" target="_blank">
                                {{ __('Plugin Support') }} ↗
                            </a>
                            <a href="https://github.com/rj-nexus/spotlight/discussions/1" target="_blank">
                                {{ __('Widget Support') }} ↗
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <style>
        @property --rj-ct-angle {
            syntax: '<angle>';
            inherits: false;
            initial-value: 0deg;
        }

        #{{ $uid }}.rj-ct-section {
            --a1: #3b82f6;
            --a2: #6366f1;
            --a3: #22d3ee;
            position: relative;
            z-index: 1;
            padding: 56px 24px;
            background: transparent;
            overflow: hidden;
            isolation: isolate;
            contain: paint;
        }

        #{{ $uid }} .rj-ct-bg {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            width: min(100%, var(--rj-container));
            transform: translateX(-50%);
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
            -webkit-mask-image: linear-gradient(180deg, transparent 0%, #000 24%, #000 76%, transparent 100%), linear-gradient(90deg, transparent 0%, #000 14%, #000 86%, transparent 100%);
            -webkit-mask-composite: source-in;
            mask-image: linear-gradient(180deg, transparent 0%, #000 24%, #000 76%, transparent 100%), linear-gradient(90deg, transparent 0%, #000 14%, #000 86%, transparent 100%);
            mask-composite: intersect;
        }
        #{{ $uid }} .rj-ct-blob {
            position: absolute;
            width: min(360px, 52%);
            aspect-ratio: 1;
            border-radius: 50%;
            mix-blend-mode: screen;
        }
        #{{ $uid }} .rj-ct-blob-a {
            top: 14%;
            left: 6%;
            background: radial-gradient(circle, rgba(59, 130, 246, .26), transparent 65%);
            animation: rjCtDriftA 18s ease-in-out infinite alternate;
        }
        #{{ $uid }} .rj-ct-blob-b {
            bottom: 14%;
            right: 6%;
            background: radial-gradient(circle, rgba(139, 92, 246, .22), transparent 65%);
            animation: rjCtDriftB 22s ease-in-out infinite alternate;
        }

        #{{ $uid }} .rj-ct-inner {
            position: relative;
            z-index: 1;
            max-width: var(--rj-container);
            margin: 0 auto;
        }

        #{{ $uid }} .rj-ct-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1.25fr);
            gap: 56px;
            align-items: center;
        }

        #{{ $uid }}.rj-ct-ready .rj-ct-reveal:not(.is-in) { opacity: 0; }
        #{{ $uid }} .rj-ct-reveal.is-in {
            animation: rjCtReveal .8s cubic-bezier(.2, .7, .2, 1) backwards;
            animation-delay: calc(var(--i, 0) * 70ms);
        }

        #{{ $uid }} .rj-ct-title {
            font-size: clamp(28px, 3.4vw, 44px);
            font-weight: 600;
            line-height: 1.1;
            letter-spacing: -.035em;
            margin: 0 0 28px;
            color: transparent;
            background: linear-gradient(110deg, #fff 25%, #93c5fd 40%, #c4b5fd 50%, #67e8f9 60%, #fff 75%);
            background-size: 250% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            animation: rjCtTitle 9s ease-in-out infinite alternate;
        }
        #{{ $uid }} .rj-ct-title.is-in {
            animation: rjCtReveal .8s cubic-bezier(.2, .7, .2, 1) backwards, rjCtTitle 9s ease-in-out .8s infinite alternate;
            animation-delay: calc(var(--i, 0) * 70ms), 0s;
        }

        #{{ $uid }} .rj-ct-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        #{{ $uid }} .rj-ct-item {
            display: flex;
            flex-direction: column;
            gap: 6px;
            padding: 16px 20px;
            border-radius: 18px;
            background: linear-gradient(160deg, rgba(255, 255, 255, .07), rgba(255, 255, 255, .02));
            border: 1px solid rgba(255, 255, 255, .09);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .12);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            transition: translate .4s cubic-bezier(.2, .7, .2, 1), border-color .4s, box-shadow .4s;
        }
        #{{ $uid }} .rj-ct-item:hover {
            translate: 4px 0;
            border-color: rgba(96, 165, 250, .45);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .18), 0 0 32px rgba(59, 130, 246, .14);
        }
        #{{ $uid }} .rj-ct-label {
            display: flex;
            align-items: center;
            gap: 9px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 11px;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .5);
        }
        #{{ $uid }} .rj-ct-label::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--a3);
            box-shadow: 0 0 10px var(--a3);
            animation: rjCtDot 2.4s ease-in-out infinite;
        }
        #{{ $uid }} .rj-ct-value {
            font-size: clamp(16px, 1.6vw, 19px);
            font-weight: 500;
            line-height: 1.45;
            letter-spacing: -.015em;
            color: #fff;
            text-decoration: none;
        }
        #{{ $uid }} .rj-ct-link { transition: color .3s; }
        #{{ $uid }} .rj-ct-link:hover { color: #7dd3fc; }

        #{{ $uid }} .rj-ct-panel {
            position: relative;
            isolation: isolate;
            padding: 32px;
            border-radius: 28px;
            background: linear-gradient(160deg, rgba(255, 255, 255, .09), rgba(255, 255, 255, .025));
            border: 1px solid rgba(255, 255, 255, .09);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .16), 0 24px 56px rgba(0, 0, 0, .32);
            backdrop-filter: blur(22px) saturate(140%);
            -webkit-backdrop-filter: blur(22px) saturate(140%);
        }
        #{{ $uid }} .rj-ct-panel::before {
            content: '';
            position: absolute;
            inset: -1px;
            padding: 1px;
            border-radius: inherit;
            background: conic-gradient(from var(--rj-ct-angle), transparent 0deg, transparent 200deg, var(--a2) 260deg, var(--a3) 320deg, transparent 360deg);
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            mask-composite: exclude;
            opacity: .5;
            transition: opacity .5s;
            animation: rjCtAngle 8s linear infinite;
            pointer-events: none;
            z-index: 2;
        }
        #{{ $uid }} .rj-ct-panel:focus-within::before { opacity: 1; }
        #{{ $uid }} .rj-ct-panel::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: radial-gradient(340px circle at var(--mx, 50%) var(--my, 0%), rgba(99, 102, 241, .16), transparent 65%);
            opacity: 0;
            transition: opacity .4s;
            pointer-events: none;
            z-index: 0;
        }
        #{{ $uid }} .rj-ct-panel:hover::after { opacity: 1; }

        #{{ $uid }} .rj-custom-form {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 22px;
        }
        #{{ $uid }} .rj-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px 28px;
        }
        #{{ $uid }} .rj-form-col-half { grid-column: span 1; }
        #{{ $uid }} .rj-form-col-full { grid-column: 1 / -1; }

        #{{ $uid }} .rj-form-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 0;
        }
        #{{ $uid }} .rj-form-label {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 11px;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .55);
            transition: color .3s;
        }
        #{{ $uid }} .rj-form-group:focus-within .rj-form-label { color: var(--a3); }
        #{{ $uid }} .rj-req { color: var(--a1); }

        #{{ $uid }} .rj-form-control { position: relative; }
        #{{ $uid }} .rj-form-input {
            display: block;
            width: 100%;
            background: transparent;
            border: 0;
            border-bottom: 1px solid rgba(255, 255, 255, .15);
            border-radius: 0;
            padding: 9px 0 11px;
            color: #fff;
            font-size: 16px;
            outline: none;
            transition: border-color .3s;
        }
        #{{ $uid }} .rj-form-input::placeholder { color: rgba(255, 255, 255, .28); }
        #{{ $uid }} .rj-form-input:hover { border-bottom-color: rgba(255, 255, 255, .32); }
        #{{ $uid }} .rj-form-input:-webkit-autofill {
            -webkit-text-fill-color: #fff;
            transition: background-color 9999s ease-out;
        }
        #{{ $uid }} .rj-form-textarea {
            resize: vertical;
            min-height: 84px;
        }
        #{{ $uid }} .rj-form-bar {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, var(--a1), var(--a3));
            box-shadow: 0 0 14px rgba(34, 211, 238, .6);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .55s cubic-bezier(.2, .7, .2, 1);
            pointer-events: none;
        }
        #{{ $uid }} .rj-form-control:focus-within .rj-form-bar { transform: scaleX(1); }

        #{{ $uid }} .rj-form-checkbox-wrap {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            cursor: pointer;
        }
        #{{ $uid }} .rj-form-checkbox-wrap input {
            -webkit-appearance: none;
            appearance: none;
            position: relative;
            flex-shrink: 0;
            width: 20px;
            height: 20px;
            margin: 1px 0 0;
            border-radius: 7px;
            border: 1px solid rgba(255, 255, 255, .26);
            background: rgba(255, 255, 255, .04);
            cursor: pointer;
            transition: background .3s, border-color .3s, box-shadow .3s;
        }
        #{{ $uid }} .rj-form-checkbox-wrap input::after {
            content: '';
            position: absolute;
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid #fff;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg) scale(0);
            transition: transform .3s cubic-bezier(.2, 1.4, .4, 1);
        }
        #{{ $uid }} .rj-form-checkbox-wrap input:checked {
            background: linear-gradient(135deg, var(--a1), var(--a2));
            border-color: transparent;
            box-shadow: 0 0 18px rgba(59, 130, 246, .5);
        }
        #{{ $uid }} .rj-form-checkbox-wrap input:checked::after { transform: rotate(45deg) scale(1); }
        #{{ $uid }} .rj-form-checkbox-wrap input:focus-visible { box-shadow: 0 0 0 3px rgba(59, 130, 246, .35); }
        #{{ $uid }} .rj-form-checkbox-text {
            font-size: 14px;
            line-height: 1.5;
            color: rgba(255, 255, 255, .62);
        }
        #{{ $uid }} .rj-form-help {
            font-size: 12px;
            color: rgba(255, 255, 255, .34);
        }

        #{{ $uid }} .rj-form-actions { margin-top: 4px; }
        #{{ $uid }} .rj-form-submit {
            position: relative;
            overflow: hidden;
            width: max-content;
            padding: 14px 34px;
            border: 0;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: -.01em;
            color: #fff;
            cursor: pointer;
            background: linear-gradient(135deg, var(--a1), var(--a2));
            box-shadow: 0 8px 24px rgba(59, 130, 246, .35), inset 0 1px 0 rgba(255, 255, 255, .28);
            transition: transform .35s cubic-bezier(.2, .7, .2, 1), box-shadow .35s;
        }
        #{{ $uid }} .rj-form-submit span { position: relative; z-index: 1; }
        #{{ $uid }} .rj-form-submit::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: -70%;
            width: 45%;
            background: linear-gradient(105deg, transparent, rgba(255, 255, 255, .35), transparent);
            transform: skewX(-12deg);
            transition: left .8s cubic-bezier(.2, .7, .2, 1);
        }
        #{{ $uid }} .rj-form-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 32px rgba(59, 130, 246, .5), inset 0 1px 0 rgba(255, 255, 255, .34);
        }
        #{{ $uid }} .rj-form-submit:hover::after { left: 130%; }
        #{{ $uid }} .rj-form-submit:active { transform: translateY(0); }
        #{{ $uid }} .rj-form-submit.is-sending { animation: rjCtSending 1s ease-in-out infinite alternate; }
        #{{ $uid }} .rj-form-submit:disabled { cursor: progress; }

        #{{ $uid }} .rj-form-alert {
            padding: 12px 16px;
            border-radius: 14px;
            font-size: 14px;
            background: rgba(239, 68, 68, .1);
            border: 1px solid rgba(239, 68, 68, .3);
            color: #fca5a5;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        #{{ $uid }} .rj-ct-fallback {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 16px 8px;
        }
        #{{ $uid }} .rj-fallback-title { font-size: 19px; font-weight: 600; color: #fff; margin: 0 0 10px; letter-spacing: -.015em; }
        #{{ $uid }} .rj-fallback-text { font-size: 14px; line-height: 1.6; color: rgba(255, 255, 255, .55); margin: 0 0 22px; max-width: 400px; }
        #{{ $uid }} .rj-fallback-links { display: flex; gap: 12px; flex-wrap: wrap; justify-content: center; }
        #{{ $uid }} .rj-fallback-btn {
            display: inline-flex;
            padding: 12px 26px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
            background: linear-gradient(135deg, var(--a1), var(--a2));
            box-shadow: 0 8px 22px rgba(59, 130, 246, .3), inset 0 1px 0 rgba(255, 255, 255, .26);
            transition: transform .3s, box-shadow .3s;
        }
        #{{ $uid }} .rj-fallback-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(59, 130, 246, .45), inset 0 1px 0 rgba(255, 255, 255, .3); }
        #{{ $uid }} .rj-fallback-support {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-top: 22px;
            padding-top: 18px;
            width: 100%;
            border-top: 1px solid rgba(255, 255, 255, .1);
            font-size: 13px;
            color: rgba(255, 255, 255, .4);
        }
        #{{ $uid }} .rj-fallback-support p { margin: 0; }
        #{{ $uid }} .rj-fallback-support a { color: #7dd3fc; text-decoration: none; }
        #{{ $uid }} .rj-fallback-support a:hover { text-decoration: underline; }

        @keyframes rjCtReveal {
            from { opacity: 0; transform: translateY(18px); filter: blur(6px); }
            to { opacity: 1; transform: none; filter: blur(0); }
        }
        @keyframes rjCtAngle { to { --rj-ct-angle: 360deg; } }
        @keyframes rjCtTitle {
            from { background-position: 0% 50%; }
            to { background-position: 100% 50%; }
        }
        @keyframes rjCtDot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .4; transform: scale(.7); }
        }
        @keyframes rjCtSending {
            from { box-shadow: 0 8px 24px rgba(59, 130, 246, .3), inset 0 1px 0 rgba(255, 255, 255, .28); }
            to { box-shadow: 0 8px 44px rgba(34, 211, 238, .6), inset 0 1px 0 rgba(255, 255, 255, .28); }
        }
        @keyframes rjCtDriftA {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(40px, 24px) scale(1.1); }
        }
        @keyframes rjCtDriftB {
            from { transform: translate(0, 0) scale(1.05); }
            to { transform: translate(-36px, -20px) scale(.95); }
        }

        @media (max-width: 968px) {
            #{{ $uid }}.rj-ct-section { padding: 44px 20px; }
            #{{ $uid }} .rj-ct-grid { grid-template-columns: 1fr; gap: 32px; }
        }
        @media (max-width: 640px) {
            #{{ $uid }} .rj-ct-panel { padding: 24px 20px; border-radius: 24px; }
            #{{ $uid }} .rj-form-row { grid-template-columns: 1fr; gap: 18px; }
            #{{ $uid }} .rj-form-submit { width: 100%; }
        }
        @media (prefers-reduced-motion: reduce) {
            #{{ $uid }} *,
            #{{ $uid }} *::before,
            #{{ $uid }} *::after { animation: none !important; transition: none !important; }
            #{{ $uid }}.rj-ct-ready .rj-ct-reveal:not(.is-in) { opacity: 1; }
            #{{ $uid }} .rj-ct-title { color: #fff; background: none; }
        }
    </style>

    <script>
        (function () {
            var root = document.getElementById('{{ $uid }}');
            if (!root) return;
            root.classList.add('rj-ct-ready');

            var items = root.querySelectorAll('.rj-ct-reveal');
            if (!('IntersectionObserver' in window)) {
                items.forEach(function (el) { el.classList.add('is-in'); });
            } else {
                var io = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-in');
                            io.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.12 });
                items.forEach(function (el) { io.observe(el); });
            }

            var panel = root.querySelector('.rj-ct-panel');
            if (panel) {
                panel.addEventListener('pointermove', function (e) {
                    var r = panel.getBoundingClientRect();
                    panel.style.setProperty('--mx', (e.clientX - r.left) + 'px');
                    panel.style.setProperty('--my', (e.clientY - r.top) + 'px');
                });
            }

            var form = root.querySelector('.rj-custom-form');
            if (form) {
                form.addEventListener('submit', function () {
                    var btn = form.querySelector('.rj-form-submit');
                    if (!btn) return;
                    btn.classList.add('is-sending');
                    setTimeout(function () { btn.disabled = true; }, 0);
                });
            }
        })();
    </script>
</section>
