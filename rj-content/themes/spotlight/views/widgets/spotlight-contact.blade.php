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
                    <form method="POST" action="{{ route('plugin.form.submit', $form->slug) }}" class="rj-custom-form">
                        @csrf

                        @if($errors->any())
                            <div class="rj-form-alert rj-alert-error">
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

                                <div class="rj-form-group {{ $fieldClass }}">
                                    @if(!$isCheckbox)
                                        <label class="rj-form-label">
                                            {{ __($field->label) }}
                                            @if($field->is_required) <span class="rj-req">*</span> @endif
                                        </label>
                                    @endif

                                    @if($isTextarea)
                                        <textarea name="{{ $field->name }}"
                                                  class="rj-form-input rj-form-textarea"
                                                  placeholder="{{ __($field->placeholder) }}"
                                                  {{ $field->is_required ? 'required' : '' }}
                                                  rows="4">{{ old($field->name) }}</textarea>

                                    @elseif($isCheckbox)
                                        <label class="rj-form-checkbox-wrap">
                                            <input type="checkbox" name="{{ $field->name }}" value="1" {{ $field->is_required ? 'required' : '' }}>
                                            <span class="rj-form-checkbox-text">
                                                {{ __($field->placeholder ?: $field->label) }}
                                                @if($field->is_required) <span class="rj-req">*</span> @endif
                                            </span>
                                        </label>

                                    @else
                                        <input type="{{ $inputType }}"
                                               name="{{ $field->name }}"
                                               class="rj-form-input"
                                               value="{{ old($field->name) }}"
                                               placeholder="{{ __($field->placeholder) }}"
                                               {{ $field->is_required ? 'required' : '' }}>
                                    @endif

                                    @if($field->help_text)
                                        <div class="rj-form-help">{{ __($field->help_text) }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="rj-form-actions">
                            <button type="submit" class="rj-form-submit">
                                {{ __('Send') }}
                            </button>
                        </div>
                    </form>
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
        /* Ümumi Bölmə */
        #{{ $uid }}.rj-contact-section {
            position: relative;
            z-index: 1;
            padding: 120px 24px;
            background: transparent;
        }

        #{{ $uid }} .rj-contact-inner {
            max-width: var(--rj-container);
            margin: 0 auto;
        }

        #{{ $uid }} .rj-contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 100px;
            align-items: start;
        }

        /* Sol tərəf (Məlumatlar) */
        #{{ $uid }} .rj-contact-title {
            font-size: clamp(40px, 4vw, 56px);
            font-weight: 500;
            color: #fff;
            margin: 0 0 64px;
            letter-spacing: -0.04em;
            line-height: 1.1;
        }

        #{{ $uid }} .rj-contact-info-list {
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        #{{ $uid }} .rj-contact-info-item {
            display: flex;
            flex-direction: column;
            gap: 14px;
            padding-bottom: 32px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        #{{ $uid }} .rj-contact-info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        #{{ $uid }} .rj-contact-label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 400;
            letter-spacing: 0.02em;
        }

        #{{ $uid }} .rj-contact-value {
            font-size: clamp(20px, 2vw, 24px);
            color: #fff;
            font-weight: 500;
            line-height: 1.4;
            text-decoration: none;
            letter-spacing: -0.02em;
        }

        #{{ $uid }} .rj-contact-link {
            transition: color 0.3s;
        }

        #{{ $uid }} .rj-contact-link:hover {
            color: #3b82f6;
        }

        /* Sağ tərəf (Glassmorphism Form) */
        #{{ $uid }} .rj-custom-form {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        #{{ $uid }} .rj-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        #{{ $uid }} .rj-form-col-half {
            grid-column: span 1;
        }

        #{{ $uid }} .rj-form-col-full {
            grid-column: 1 / -1;
        }

        #{{ $uid }} .rj-form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        #{{ $uid }} .rj-form-label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            margin-left: 2px;
        }

        #{{ $uid }} .rj-req {
            color: #3b82f6;
        }

        /* Şüşə Effektli Inputlar */
        #{{ $uid }} .rj-form-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 18px 20px;
            color: #fff;
            font-size: 15px;
            transition: all 0.3s ease;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.05);
        }

        #{{ $uid }} .rj-form-input::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }

        #{{ $uid }} .rj-form-input:hover {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.2);
        }

        #{{ $uid }} .rj-form-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.05);
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15), inset 0 1px 0 rgba(255,255,255,0.05);
        }

        #{{ $uid }} .rj-form-textarea {
            resize: vertical;
            min-height: 140px;
        }

        /* Checkbox */
        #{{ $uid }} .rj-form-checkbox-wrap {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            cursor: pointer;
            margin-top: 8px;
        }

        #{{ $uid }} .rj-form-checkbox-wrap input {
            margin-top: 4px;
            accent-color: #3b82f6;
            width: 18px;
            height: 18px;
            border-radius: 4px;
        }

        #{{ $uid }} .rj-form-checkbox-text {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.5;
        }

        #{{ $uid }} .rj-form-help {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.3);
            margin-left: 2px;
        }

        /* Düymə */
        #{{ $uid }} .rj-form-actions {
            margin-top: 16px;
        }

        #{{ $uid }} .rj-form-submit {
            background: #3b82f6;
            color: #fff;
            border: none;
            padding: 18px 40px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: max-content;
            box-shadow: 0 4px 14px rgba(59, 130, 246, 0.3);
        }

        #{{ $uid }} .rj-form-submit:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        #{{ $uid }} .rj-form-submit:active {
            transform: translateY(0);
        }

        #{{ $uid }} .rj-form-alert {
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 14px;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            margin-bottom: 8px;
            backdrop-filter: blur(8px);
        }

        /* Fallback Box */
        #{{ $uid }} .rj-contact-fallback {
            background: rgba(255, 255, 255, 0.02);
            border: 1px dashed rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            padding: 56px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            backdrop-filter: blur(12px);
        }

        #{{ $uid }} .rj-fallback-icon { width: 48px; height: 48px; color: #3b82f6; margin-bottom: 24px; }
        #{{ $uid }} .rj-fallback-title { font-size: 20px; font-weight: 600; color: #fff; margin: 0 0 12px; }
        #{{ $uid }} .rj-fallback-text { font-size: 15px; color: rgba(255, 255, 255, 0.5); line-height: 1.6; margin: 0 0 32px; max-width: 400px; }
        #{{ $uid }} .rj-fallback-links { display: flex; gap: 12px; flex-wrap: wrap; justify-content: center; }
        #{{ $uid }} .rj-fallback-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 14px 28px; border-radius: 10px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s; }
        #{{ $uid }} .rj-fallback-btn.primary { background: #3b82f6; color: #fff; }
        #{{ $uid }} .rj-fallback-btn.primary:hover { background: #2563eb; }
        #{{ $uid }} .rj-fallback-support { margin-top: 32px; padding-top: 24px; border-top: 1px solid rgba(255, 255, 255, 0.1); font-size: 13px; color: rgba(255, 255, 255, 0.4); display: flex; flex-direction: column; gap: 8px; }
        #{{ $uid }} .rj-fallback-support a { color: #3b82f6; text-decoration: none; }
        #{{ $uid }} .rj-fallback-support a:hover { text-decoration: underline; }

        @media (max-width: 1024px) {
            #{{ $uid }} .rj-contact-grid { gap: 60px; }
        }

        @media (max-width: 968px) {
            #{{ $uid }}.rj-contact-section { padding: 80px 24px; }
            #{{ $uid }} .rj-contact-grid { grid-template-columns: 1fr; gap: 64px; }
            #{{ $uid }} .rj-contact-title { margin-bottom: 48px; }
        }

        @media (max-width: 640px) {
            #{{ $uid }} .rj-form-row { grid-template-columns: 1fr; }
            #{{ $uid }} .rj-form-submit { width: 100%; }
            #{{ $uid }} .rj-form-input { padding: 16px 18px; }
        }
    </style>
</section>
