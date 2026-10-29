@php
    $layoutClass = match($layout) {
        'grid-2' => 'rj-form-grid-2',
        'inline' => 'rj-form-inline',
        default => 'rj-form-stack',
    };
@endphp

<style>
    /* Animasiya */
    @keyframes rjFormFadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .rj-form-wrap { animation: rjFormFadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .rj-form-field { animation: rjFormFadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }

    .rj-form-label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px; display: block; letter-spacing: 0.01em; }
    .rj-form-req { color: #ef4444; margin-left: 2px; }
    .rj-form-help { font-size: 11.5px; color: #6b7280; margin-top: 6px; line-height: 1.4; }

    .rj-form-input, .rj-form-wrap textarea, .rj-form-wrap select {
        width: 100%; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 10px;
        font-size: 14.5px; background: #f8fafc; color: #1e293b; outline: none;
        transition: all 0.25s ease; font-family: inherit; box-shadow: inset 0 1px 2px rgba(0,0,0,0.02);
    }
    .rj-form-input:focus, .rj-form-wrap textarea:focus, .rj-form-wrap select:focus {
        background: #ffffff; border-color: #8b5cf6; box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15);
    }

    /* --- DEFAULT PRESET --- */
    .rj-form-preset-default .rj-form-submit {
        padding: 12px 28px; background: #7c3aed; color: #fff; border: none; border-radius: 10px;
        font-weight: 600; font-size: 14.5px; cursor: pointer; transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(124,58,237,.2);
    }
    .rj-form-preset-default .rj-form-submit:hover { background: #6d28d9; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(124,58,237,.3); }

    /* --- MODERN PRESET (Gradient & Glassmorphism) --- */
    .rj-form-preset-modern { background: #ffffff; padding: 2rem; border-radius: 16px; box-shadow: 0 10px 40px -10px rgba(0,0,0,0.08); border: 1px solid #f1f5f9; }
    .rj-form-preset-modern .rj-form-field { margin-bottom: 24px; }
    .rj-form-preset-modern .rj-form-submit {
        width: 100%; padding: 14px; background: linear-gradient(135deg, #7c3aed 0%, #ec4899 100%);
        color: #fff; border: none; border-radius: 10px; font-weight: 600; font-size: 15px;
        cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(124,58,237,.3);
    }
    .rj-form-preset-modern .rj-form-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(124,58,237,.4); }

    /* --- MINIMAL PRESET --- */
    .rj-form-preset-minimal .rj-form-field { margin-bottom: 28px; }
    .rj-form-preset-minimal .rj-form-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; color: #64748b; }
    .rj-form-preset-minimal .rj-form-input, .rj-form-preset-minimal textarea, .rj-form-preset-minimal select {
        padding: 8px 0; border: none; border-bottom: 2px solid #e2e8f0; border-radius: 0;
        background: transparent; box-shadow: none; font-size: 16px;
    }
    .rj-form-preset-minimal .rj-form-input:focus, .rj-form-preset-minimal textarea:focus, .rj-form-preset-minimal select:focus {
        border-bottom-color: #7c3aed; box-shadow: none;
    }
    .rj-form-preset-minimal .rj-form-submit {
        padding: 12px 0; background: transparent; color: #7c3aed; border: none; border-bottom: 2px solid #7c3aed;
        border-radius: 0; font-weight: 700; font-size: 15px; cursor: pointer; transition: all 0.2s;
    }
    .rj-form-preset-minimal .rj-form-submit:hover { color: #4c1d95; border-bottom-color: #4c1d95; }

    /* --- DARK PRESET --- */
    .rj-form-preset-dark { background: #0f172a; padding: 2.5rem; border-radius: 16px; box-shadow: 0 24px 48px -12px rgba(0,0,0,0.4); }
    .rj-form-preset-dark .rj-form-label { color: #cbd5e1; }
    .rj-form-preset-dark .rj-form-input, .rj-form-preset-dark textarea, .rj-form-preset-dark select {
        background: #1e293b; border: 1px solid #334155; color: #f8fafc; box-shadow: none;
    }
    .rj-form-preset-dark .rj-form-input:focus, .rj-form-preset-dark textarea:focus, .rj-form-preset-dark select:focus {
        border-color: #8b5cf6; background: #1e293b; box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
    }
    .rj-form-preset-dark .rj-form-submit {
        width: 100%; padding: 14px; background: #8b5cf6; color: #fff; border: none; border-radius: 10px;
        font-weight: 600; font-size: 15px; cursor: pointer; transition: background 0.2s;
    }
    .rj-form-preset-dark .rj-form-submit:hover { background: #7c3aed; }

    /* Layout Utils */
    .rj-form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .rj-form-grid-2 .rj-form-field-full { grid-column: 1 / -1; }
    .rj-form-inline { display: flex; gap: 16px; align-items: flex-end; }
    .rj-form-inline .rj-form-field { flex: 1; margin-bottom: 0 !important; }
    .rj-form-inline .rj-form-actions { flex-shrink: 0; }

    @media (max-width: 640px) {
        .rj-form-grid-2 { grid-template-columns: 1fr; }
        .rj-form-inline { flex-direction: column; align-items: stretch; }
    }
</style>

<div class="rj-form-wrap rj-form-preset-{{ $designPreset ?? 'modern' }}">
    <form method="POST" action="{{ route('plugin.form.submit', $form->slug) }}" class="rj-form {{ $layoutClass }}">
        @csrf

        @foreach($form->fields as $index => $field)
            @php
                $required = $field->is_required ? 'required' : '';
                $reqMark = $field->is_required ? '<span class="rj-form-req">*</span>' : '';
                $delay = $index * 0.08;
            @endphp

            @if($field->type === 'textarea')
                <div class="rj-form-field rj-form-field-textarea rj-form-field-full" style="animation-delay: {{ $delay }}s;">
                    <label class="rj-form-label">{{ __($field->label) }} {!! $reqMark !!}</label>
                    <textarea name="{{ $field->name }}" placeholder="{{ __($field->placeholder) }}" {{ $required }} rows="5"></textarea>
                    @if($field->help_text)
                        <div class="rj-form-help">{{ __($field->help_text) }}</div>
                    @endif
                </div>

            @elseif($field->type === 'select')
                <div class="rj-form-field" style="animation-delay: {{ $delay }}s;">
                    <label class="rj-form-label">{{ __($field->label) }} {!! $reqMark !!}</label>
                    <select name="{{ $field->name }}" {{ $required }}>
                        <option value="">{{ __($field->placeholder ?: 'Select an option') }}</option>
                        @if(is_array($field->options))
                            @foreach($field->options as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        @endif
                    </select>
                    @if($field->help_text)
                        <div class="rj-form-help">{{ __($field->help_text) }}</div>
                    @endif
                </div>

            @elseif($field->type === 'checkbox')
                <div class="rj-form-field" style="animation-delay: {{ $delay }}s;">
                    <label class="rj-form-label">{{ __($field->label) }} {!! $reqMark !!}</label>
                    <div class="rj-form-checkbox-group" style="display:flex; flex-direction:column; gap:10px; margin-top: 4px;">
                        @if(is_array($field->options))
                            @foreach($field->options as $option)
                                <label class="rj-form-checkbox" style="display:inline-flex; align-items:center; gap:10px; font-size:14.5px; cursor:pointer; color:#475569;">
                                    <input type="checkbox" name="{{ $field->name }}[]" value="{{ $option }}" {{ $required }} style="accent-color:#7c3aed; width:18px; height:18px; border-radius:4px;">
                                    <span>{{ $option }}</span>
                                </label>
                            @endforeach
                        @else
                            <label class="rj-form-checkbox" style="display:inline-flex; align-items:center; gap:10px; font-size:14.5px; cursor:pointer; color:#475569;">
                                <input type="checkbox" name="{{ $field->name }}" value="1" {{ $required }} style="accent-color:#7c3aed; width:18px; height:18px; border-radius:4px;">
                                <span>{{ __($field->placeholder ?: $field->label) }}</span>
                            </label>
                        @endif
                    </div>
                    @if($field->help_text)
                        <div class="rj-form-help">{{ __($field->help_text) }}</div>
                    @endif
                </div>

            @else
                @php
                    $type = in_array($field->type, ['text', 'email', 'tel', 'url', 'number', 'date', 'time']) ? $field->type : 'text';
                @endphp
                <div class="rj-form-field" style="animation-delay: {{ $delay }}s;">
                    <label class="rj-form-label">{{ __($field->label) }} {!! $reqMark !!}</label>
                    <input type="{{ $type }}" name="{{ $field->name }}" placeholder="{{ __($field->placeholder) }}" class="rj-form-input" {{ $required }}>
                    @if($field->help_text)
                        <div class="rj-form-help">{{ __($field->help_text) }}</div>
                    @endif
                </div>
            @endif
        @endforeach

        <div class="rj-form-actions {{ $layoutClass === 'rj-form-inline' ? 'rj-form-field-full' : '' }}" style="animation-delay: {{ count($form->fields) * 0.08 }}s; opacity: 0; animation: rjFormFadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; animation-delay: {{ count($form->fields) * 0.08 }}s;">
            <button type="submit" class="rj-form-submit">
                {{ __('Submit') }}
            </button>
        </div>

        <div class="rj-form-message" style="display: none; padding: 14px 16px; border-radius: 10px; font-size: 14px; margin-top: 20px; font-weight: 500;"></div>
    </form>
</div>
