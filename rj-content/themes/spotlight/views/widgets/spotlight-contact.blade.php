@php
    $uid = 'contact_' . substr(md5(uniqid('', true)), 0, 8);
    $title = $settings['title'] ?? '';
    $formId = $settings['form_id'] ?? '';
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
                @if($formId)
                    @if(function_exists('rj_render_form'))
                        {!! rj_render_form($formId) !!}
                    @elseif(function_exists('do_shortcode'))
                        {!! do_shortcode('[rj_form id="' . $formId . '"]') !!}
                    @else
                        <div class="rj-contact-no-form">{{ __('Form rendering function not found.') }}</div>
                    @endif
                @else
                    <div class="rj-contact-no-form">
                        {{ __('Please select an RJ Form from the widget settings.') }}
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

        #{{ $uid }} .rj-contact-no-form {
            padding: 40px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px dashed rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            color: rgba(255, 255, 255, 0.5);
            text-align: center;
        }

        /* RJ Form Builder Dizaynını Şəkildəki Kimi Etmək Üçün */
        #{{ $uid }} .rj-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        #{{ $uid }} .rj-form-field-full,
        #{{ $uid }} .rj-form-field-textarea,
        #{{ $uid }} .rj-form-actions {
            grid-column: 1 / -1;
        }

        #{{ $uid }} .rj-form-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        #{{ $uid }} .rj-form-label {
            font-size: 14px;
            color: #fff;
            font-weight: 500;
        }

        #{{ $uid }} .rj-form-input,
        #{{ $uid }} .rj-form textarea,
        #{{ $uid }} .rj-form select {
            width: 100%;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 16px 20px;
            color: #fff;
            font-size: 15px;
            transition: border-color 0.2s, background 0.2s;
        }

        #{{ $uid }} .rj-form-input::placeholder,
        #{{ $uid }} .rj-form textarea::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        #{{ $uid }} .rj-form-input:focus,
        #{{ $uid }} .rj-form textarea:focus {
            border-color: var(--rj-primary);
            outline: none;
            background: rgba(255, 255, 255, 0.02);
        }

        #{{ $uid }} .rj-form textarea {
            min-height: 140px;
            resize: vertical;
        }

        #{{ $uid }} .rj-form-checkbox {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            align-items: flex-start;
        }

        #{{ $uid }} .rj-form-checkbox input {
            margin-top: 4px;
        }

        #{{ $uid }} .rj-form-submit {
            background: #3b82f6;
            color: #fff;
            border: none;
            padding: 16px 40px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
            display: inline-flex;
            justify-content: center;
            width: max-content;
            min-width: 140px;
        }

        #{{ $uid }} .rj-form-submit:hover {
            background: #2563eb;
            transform: translateY(-2px);
        }

        @media (max-width: 968px) {
            #{{ $uid }}.rj-contact-section { padding: 64px 24px; }
            #{{ $uid }} .rj-contact-grid {
                grid-template-columns: 1fr;
                gap: 60px;
            }
            #{{ $uid }} .rj-contact-title { margin-bottom: 40px; }
        }

        @media (max-width: 640px) {
            #{{ $uid }} .rj-form {
                grid-template-columns: 1fr;
            }
        }
    </style>
</section>
