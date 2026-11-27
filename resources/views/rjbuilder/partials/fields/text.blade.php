<template x-if="field.type === 'text' || field.type === 'textarea' || field.type === 'rich_text'">
    <div x-data="{
        initEditor() {
            // Quill.js-in yüklənməsini yoxlayırıq
            if (typeof Quill === 'undefined') {
                let link = document.createElement('link');
                link.href = 'https://cdn.quilljs.com/1.3.6/quill.snow.css';
                link.rel = 'stylesheet';
                document.head.appendChild(link);

                let script = document.createElement('script');
                script.src = 'https://cdn.quilljs.com/1.3.6/quill.js';
                script.onload = () => this.setupQuill();
                document.head.appendChild(script);
            } else {
                this.setupQuill();
            }
        },
        setupQuill() {
            const editorElement = this.$refs.quillEditor;
            
            // Quill-i konfiqurasiya edirik
            const quill = new Quill(editorElement, {
                theme: 'snow',
                placeholder: field.placeholder || 'Write something beautiful...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'align': [] }],
                        ['link', 'image', 'video'],
                        ['clean']
                    ]
                }
            });

            // Köhnə yazılmış mətni (əgər varsa) redaktora yükləyirik
            let initialContent = currentSettings[field.name] || field.default || '';
            if (initialContent) {
                quill.clipboard.dangerouslyPasteHTML(initialContent);
            }

            // Hər dəfə mətn dəyişəndə Alpine.js-ə xəbər veririk
            quill.on('text-change', () => {
                let html = quill.root.innerHTML;
                if (html === '<p><br></p>') html = ''; // Əgər boşdursa təmizləyirik
                updateSetting(field.name, html);
            });
        }
    }" x-init="initEditor()">
        
        <style>
            /* Quill Redaktorunun RJBuilder-in tünd temasına uyğunlaşdırılması */
            .ql-toolbar.ql-snow { 
                border-color: var(--line); 
                background: var(--bg2); 
                border-radius: 8px 8px 0 0; 
                padding: 8px;
            }
            .ql-container.ql-snow { 
                border-color: var(--line); 
                border-radius: 0 0 8px 8px; 
                font-family: inherit; 
                font-size: 14px; 
                min-height: 200px; 
                background: #ffffff; /* Ağ fon */
                color: #111827; /* Tünd yazı */
            }
            .ql-editor { 
                min-height: 200px; 
                line-height: 1.6;
            }
            .ql-editor.ql-blank::before { 
                color: #9ca3af; 
                font-style: normal; 
            }
            /* İkonların rəngi (tünd temada görünməsi üçün) */
            .ql-snow .ql-stroke { stroke: #e5e7eb; }
            .ql-snow .ql-fill { fill: #e5e7eb; }
            .ql-snow .ql-picker { color: #e5e7eb; }
            
            /* Dropdown menyuları */
            .ql-snow .ql-picker-options { background-color: var(--bg2); border-color: var(--line); }
            .ql-snow .ql-picker-item { color: var(--text); }
            .ql-snow .ql-picker-item:hover { color: #a78bfa; }
        </style>

        <div class="rj-field" style="margin-bottom: 0;">
            <div class="rj-lbl">
                <span x-text="field.label"></span>
            </div>
            
            {{-- Quill-in yerləşəcəyi div --}}
            <div x-ref="quillEditor"></div>
            
            <p class="rj-help" x-show="field.help" x-text="field.help" style="margin-top: 8px;"></p>
        </div>
    </div>
</template>