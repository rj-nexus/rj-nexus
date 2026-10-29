@php
    $form = \RjPlugins\FormBuilder\Models\Form::with('fields')->find($settings['form_id'] ?? 0);
@endphp

@if($form)
    <div style="width: 100%; max-width: 600px; margin: 0 auto; padding: 2rem; background: #ffffff; border-radius: 16px; box-shadow: 0 10px 40px -10px rgba(0,0,0,0.08); border: 1px solid #f1f5f9; font-family: system-ui, -apple-system, sans-serif;">

        <form class="rj-form" action="{{ route('frontend.form.submit', $form->slug ?? $form->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem; margin: 0;">
            @csrf

            @forelse($form->fields as $index => $field)
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 0.875rem; font-weight: 600; color: #334155;">
                        {{ __($field->label) }}
                        @if($field->required) <span style="color: #ef4444;">*</span> @endif
                    </label>

                    @if($field->type === 'textarea')
                        <textarea name="{{ $field->name }}" rows="4" placeholder="{{ __($field->placeholder ?? 'Enter ' . $field->label) }}" {{ $field->required ? 'required' : '' }} style="width: 100%; padding: 0.875rem 1rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.95rem; color: #1e293b; outline: none; transition: all 0.2s; font-family: inherit; resize: vertical;"></textarea>
                    @elseif($field->type === 'select')
                        <select name="{{ $field->name }}" {{ $field->required ? 'required' : '' }} style="width: 100%; padding: 0.875rem 1rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.95rem; color: #1e293b; outline: none; transition: all 0.2s; font-family: inherit; cursor: pointer;">
                            <option value="">{{ __('— Select an option —') }}</option>
                            @foreach($field->options ?? [] as $opt)
                                <option value="{{ $opt }}">{{ $opt }}</option>
                            @endforeach
                        </select>
                    @elseif($field->type === 'checkbox' || $field->type === 'radio')
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-top: 0.25rem;">
                            <input type="{{ $field->type }}" name="{{ $field->name }}" {{ $field->required ? 'required' : '' }} style="width: 1.25rem; height: 1.25rem; accent-color: #7c3aed; cursor: pointer;">
                            <span style="font-size: 0.95rem; color: #475569;">{{ __($field->placeholder ?? '') }}</span>
                        </div>
                    @else
                        <input type="{{ $field->type }}" name="{{ $field->name }}" placeholder="{{ __($field->placeholder ?? 'Enter ' . $field->label) }}" {{ $field->required ? 'required' : '' }} style="width: 100%; padding: 0.875rem 1rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.95rem; color: #1e293b; outline: none; transition: all 0.2s; font-family: inherit;">
                    @endif
                </div>
            @empty
                <p style="text-align: center; color: #64748b; font-size: 0.875rem;">No fields added to this form yet.</p>
            @endforelse

            <div class="rj-form-message" style="display:none; padding: 1rem; border-radius: 10px; font-size: 0.875rem;"></div>

            <div class="rj-form-actions" style="margin-top: 0.5rem;">
                <button type="submit" class="rj-form-submit" style="display: inline-flex; align-items: center; justify-content: center; width: 100%; padding: 1rem 2rem; background: linear-gradient(135deg, #7c3aed 0%, #6366f1 100%); color: #ffffff; font-weight: 600; font-size: 1rem; border: none; border-radius: 10px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3); font-family: inherit;">
                    {{ __($settings['button_text'] ?? 'Submit') }}
                </button>
            </div>
        </form>
    </div>

    <style>
        /* Yalnızca focus (fokus) effekti üçün kiçik bir CSS */
        .rj-form input:focus, .rj-form textarea:focus, .rj-form select:focus {
            border-color: #8b5cf6 !important;
            background-color: #ffffff !important;
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15) !important;
        }
        .rj-form-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4) !important;
        }
        .rj-form-submit:active {
            transform: translateY(0);
        }
    </style>
@else
    <div style="text-align: center; padding: 3rem 2rem; background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 16px;">
        <svg style="width: 48px; height: 48px; margin: 0 auto 1rem; color: #94a3b8; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        <p style="color: #64748b; font-weight: 500; font-size: 0.95rem; margin: 0;">{{ __('No form selected. Please select a form in the settings panel.') }}</p>
    </div>
@endif
