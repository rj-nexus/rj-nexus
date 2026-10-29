@php
    $form = \RjPlugins\FormBuilder\Models\Form::with('fields')->find($settings['form_id'] ?? 0);
@endphp

@if($form)
    <div class="rj-form-widget-container w-full max-w-2xl mx-auto">
        <style>
            .rj-f-anim {
                animation: rjFadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                opacity: 0;
                transform: translateY(20px);
            }
            @keyframes rjFadeInUp {
                to { opacity: 1; transform: translateY(0); }
            }
            .rj-input-modern {
                width: 100%;
                background-color: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 0.75rem;
                padding: 0.875rem 1rem;
                font-size: 0.95rem;
                color: #1e293b;
                transition: all 0.25s ease;
                outline: none;
                font-family: inherit;
            }
            .rj-input-modern:focus {
                background-color: #ffffff;
                border-color: #8b5cf6;
                box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15);
            }
            .rj-btn-modern {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, #7c3aed 0%, #6366f1 100%);
                color: white;
                font-weight: 600;
                padding: 0.875rem 2rem;
                border-radius: 0.75rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
                border: none;
                cursor: pointer;
                width: 100%;
                font-family: inherit;
            }
            .rj-btn-modern:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4);
                background: linear-gradient(135deg, #6d28d9 0%, #4f46e5 100%);
            }
            .rj-btn-modern:active {
                transform: translateY(0);
            }
            .rj-btn-modern:disabled {
                opacity: 0.7;
                cursor: not-allowed;
                transform: none;
            }
        </style>

        <form class="rj-form flex flex-col gap-5" action="{{ route('frontend.form.submit', $form->slug ?? $form->id) }}" method="POST">
            @csrf

            @foreach($form->fields as $index => $field)
                <div class="rj-form-field rj-f-anim" style="animation-delay: {{ $index * 0.08 }}s;">
                    <label class="rj-form-label block text-sm font-semibold text-slate-700 mb-2">
                        {{ __($field->label) }}
                        @if($field->required) <span class="text-red-500">*</span> @endif
                    </label>

                    @if($field->type === 'textarea')
                        <textarea name="{{ $field->name }}" class="rj-input-modern" rows="4" placeholder="{{ __($field->placeholder ?? 'Enter ' . $field->label) }}" {{ $field->required ? 'required' : '' }}></textarea>
                    @elseif($field->type === 'select')
                        <select name="{{ $field->name }}" class="rj-input-modern" {{ $field->required ? 'required' : '' }}>
                            <option value="">{{ __('— Select an option —') }}</option>
                            @foreach($field->options ?? [] as $opt)
                                <option value="{{ $opt }}">{{ $opt }}</option>
                            @endforeach
                        </select>
                    @elseif($field->type === 'checkbox' || $field->type === 'radio')
                        <div class="flex items-center gap-3 mt-2">
                            <input type="{{ $field->type }}" name="{{ $field->name }}" class="w-5 h-5 accent-purple-600 rounded cursor-pointer" {{ $field->required ? 'required' : '' }}>
                            <span class="text-sm text-slate-600">{{ __($field->placeholder ?? '') }}</span>
                        </div>
                    @else
                        <input type="{{ $field->type }}" name="{{ $field->name }}" class="rj-input-modern" placeholder="{{ __($field->placeholder ?? 'Enter ' . $field->label) }}" {{ $field->required ? 'required' : '' }}>
                    @endif
                </div>
            @endforeach

            <div class="rj-form-message mt-2" style="display:none;"></div>

            <div class="rj-form-actions rj-f-anim mt-2" style="animation-delay: {{ (count($form->fields) + 1) * 0.08 }}s;">
                <button type="submit" class="rj-btn-modern rj-form-submit">
                    {{ __($settings['button_text'] ?? 'Submit') }}
                </button>
            </div>
        </form>
    </div>
@else
    <div class="text-center p-8 bg-slate-50 border border-dashed border-slate-300 rounded-2xl">
        <svg class="w-12 h-12 mx-auto text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        <p class="text-slate-500 font-medium">{{ __('No form selected. Please select a form in the settings panel.') }}</p>
    </div>
@endif
