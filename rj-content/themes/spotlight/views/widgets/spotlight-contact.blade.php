@php
    $uid = 'contact_' . substr(md5(uniqid('', true)), 0, 8);
    $title = $settings['title'] ?? '';
@endphp

<section class="rj-contact-section" id="{{ $uid }}">
    <div class="rj-contact-inner">
        <div class="rj-contact-grid">

            <div class="rj-contact-left">
                @if($title)
                    <h2 class="rj-contact-title">{{ $title }}</h2>
                @endif

                <div class="rj-contact-info-list">
                    @if(!empty($settings['office_label']) || !empty($settings['office_address']))
                        <div class="rj-contact-info-item">
                            <span class="rj-contact-label">{{ $settings['office_label'] ?? '' }}</span>
                            <span class="rj-contact-value">{!! nl2br(e($settings['office_address'] ?? '')) !!}</span>
                        </div>
                    @endif

                    @if(!empty($settings['email_label']) || !empty($settings['email_address']))
                        <div class="rj-contact-info-item">
                            <span class="rj-contact-label">{{ $settings['email_label'] ?? '' }}</span>
                            <a href="mailto:{{ $settings['email_address'] ?? '' }}" class="rj-contact-value rj-contact-link">{{ $settings['email_address'] ?? '' }}</a>
                        </div>
                    @endif

                    @if(!empty($settings['phone_label']) || !empty($settings['phone_number']))
                        <div class="rj-contact-info-item">
                            <span class="rj-contact-label">{{ $settings['phone_label'] ?? '' }}</span>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings['phone_number'] ?? '') }}" class="rj-contact-value rj-contact-link">{{ $settings['phone_number'] ?? '' }}</a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="rj-contact-right">
                @if(isset($form) && $form)
                    @if(view()->exists('plugin-form-builder::widget'))
                        {!! view('plugin-form-builder::widget', [
                            'form' => $form,
                            'layout' => 'stack',
                            'designPreset' => 'dark',
                            'showMascot' => false,
                            'stageSide' => 'right'
                        ])->render() !!}
                    @else
                        <div class="rj-contact-fallback">
                            <h3 class="rj-fallback-title">{{ __('Form view not found.') }}</h3>
                            <p class="rj-fallback-text">{{ __('The form builder plugin view is missing. Please reinstall the plugin.') }}</p>
                            <div class="rj-fallback-links">
                                <a href="https://github.com/mr-ruhid/rj-plugin-form-builder/releases" target="_blank" class="rj-fallback-btn primary">{{ __('Download Plugin') }}</a>
                                <a href="https://github.com/mr-ruhid/rj-plugin-form-builder/discussions/2" target="_blank" class="rj-fallback-btn secondary">{{ __('Plugin Support') }}</a>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="rj-contact-fallback">
                        <div class="rj-fallback-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <h3 class="rj-fallback-title">{{ __('Form is not configured or plugin is missing.') }}</h3>
                        <p class="rj-fallback-text">{{ __('To display a form here, please ensure the Form Builder plugin is installed and a form is selected in the widget settings.') }}</p>

                        <div class="rj-fallback-links">
                            <a href="https://github.com/mr-ruhid/rj-plugin-form-builder/releases" target="_blank" class="rj-fallback-btn primary">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
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
        #{{ $uid }}.rj-contact-section {
            position: relative;
            z-index: 1;
            padding: 100px 24px;
            background: transparent;
        }

        #{{ $uid }} .rj-contact-inner {
            max-width: var(--rj-container);
            margin: 0 auto;
        }

        #{{ $uid }} .rj-contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 80px;
            align-items: start;
        }

        #{{ $uid }} .rj-contact-title {
            font-size: clamp(36px, 4vw, 52px);
            font-weight: 500;
            color: #fff;
            margin: 0 0 56px;
            letter-spacing: -0.03em;
            line-height: 1.1;
        }

        #{{ $uid }} .rj-contact-info-list {
            display: flex;
            flex-direction: column;
            gap: 36px;
        }

        #{{ $uid }} .rj-contact-info-item {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding-bottom: 32px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        #{{ $uid }} .rj-contact-info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        #{{ $uid }} .rj-contact-label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 500;
        }

        #{{ $uid }} .rj-contact-value {
            font-size: clamp(20px, 2vw, 24px);
            color: #fff;
            font-weight: 500;
            line-height: 1.4;
            text-decoration: none;
        }

        #{{ $uid }} .rj-contact-link {
            transition: color 0.2s;
        }

        #{{ $uid }} .rj-contact-link:hover {
            color: var(--rj-primary);
        }

        /* Fallback Box Styles */
        #{{ $uid }} .rj-contact-fallback {
            background: rgba(255, 255, 255, 0.03);
            border: 1px dashed rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 48px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #{{ $uid }} .rj-fallback-icon {
            width: 48px;
            height: 48px;
            color: #f59e0b;
            margin-bottom: 24px;
        }

        #{{ $uid }} .rj-fallback-title {
            font-size: 20px;
            font-weight: 600;
            color: #fff;
            margin: 0 0 12px;
        }

        #{{ $uid }} .rj-fallback-text {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.6;
            margin: 0 0 32px;
            max-width: 400px;
        }

        #{{ $uid }} .rj-fallback-links {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
        }

        #{{ $uid }} .rj-fallback-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        #{{ $uid }} .rj-fallback-btn svg {
            width: 18px;
            height: 18px;
        }

        #{{ $uid }} .rj-fallback-btn.primary {
            background: #3b82f6;
            color: #fff;
        }

        #{{ $uid }} .rj-fallback-btn.primary:hover {
            background: #2563eb;
        }

        #{{ $uid }} .rj-fallback-btn.secondary {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        #{{ $uid }} .rj-fallback-btn.secondary:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        #{{ $uid }} .rj-fallback-support {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 13px;
            color: rgba(255, 255, 255, 0.4);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        #{{ $uid }} .rj-fallback-support a {
            color: var(--rj-primary);
            text-decoration: none;
        }

        #{{ $uid }} .rj-fallback-support a:hover {
            text-decoration: underline;
        }

        @media (max-width: 968px) {
            #{{ $uid }}.rj-contact-section { padding: 64px 24px; }
            #{{ $uid }} .rj-contact-grid {
                grid-template-columns: 1fr;
                gap: 60px;
            }
            #{{ $uid }} .rj-contact-title { margin-bottom: 40px; }
        }
    </style>
</section>
