<template x-if="field.type === 'text' || field.type === 'textarea' || field.type === 'rich_text'">
    <div x-data="{
        quill: null,
        isUpdating: false,
        
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
            if (this.quill) return; // Təkrar yüklənmənin qarşısını alırıq

            const quill = new Quill(this.$refs.quillEditor, {
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

            this.quill = quill;

            // Bazadan gələn köhnə mətni yükləyirik
            let initialContent = fieldValue(field) || '';
            if (initialContent) {
                quill.clipboard.dangerouslyPasteHTML(initialContent);
            }

            // Redaktorda dəyişiklik olanda bazaya (Alpine state) yazırıq
            quill.on('text-change', () => {
                if (this.isUpdating) return;
                
                let html = quill.root.innerHTML;
                if (html === '<p><br></p>') html = ''; 
                
                updateSetting(field.name, html);
            });
        },

        // Əgər xaricdən (AI, Undo və s.) mətn dəyişsə, Quill-i yeniləyirik
        syncEditor() {
            if (!this.quill) return;
            
            const newValue = fieldValue(field) || '';
            const currentHtml = this.quill.root.innerHTML;
            
            // Yalnız mətn həqiqətən dəyişibsə yeniləyirik (sonsuz döngənin qarşısını alırıq)
            if (newValue !== currentHtml && newValue !== (currentHtml === '<p><br></p>' ? '' : currentHtml)) {
                this.isUpdating = true;
                this.quill.clipboard.dangerouslyPasteHTML(newValue);
                this.isUpdating = false;
            }
        }
    }" 
    x-init="initEditor()" 
    x-effect="syncEditor()">

        <style>
            /* Quill Redaktorunun RJBuilder tünd temasına tam uyğunlaşdırılması */
            .ql-toolbar.ql-snow { 
                border-color: var(--line); 
                background: var(--bg2); 
                border-radius: 8px 8px 0 0; 
                padding: 8px;
                display: flex;
                flex-wrap: wrap;
            }
            .ql-container.ql-snow { 
                border-color: var(--line); 
                border-radius: 0 0 8px 8px; 
                font-family: inherit; 
                font-size: 14px; 
                min-height: 200px; 
                background: #ffffff; /* Ağ fon (yazılar oxunsun deyə) */
                color: #111827; 
            }
            .ql-editor { 
                min-height: 200px; 
                line-height: 1.7;
                font-size: 15px;
            }
            .ql-editor.ql-blank::before { 
                color: #9ca3af; 
                font-style: normal; 
            }
            .ql-snow .ql-stroke { stroke: #e5e7eb; }
            .ql-snow .ql-fill { fill: #e5e7eb; }
            .ql-snow .ql-picker { color: #e5e7eb; }
            .ql-snow .ql-picker-options { background-color: var(--bg2); border-color: var(--line); }
            .ql-snow .ql-picker-item { color: var(--text); }
            .ql-snow .ql-picker-item:hover { color: #a78bfa; }
        </style>

        {{-- BURADA HEÇ BİR LABEL YOXDUR (Çünki yuxarıdakı əsas fayl onu çap edir) --}}
        
        {{-- Quill-in yerləşəcəyi div --}}
        <div x-ref="quillEditor"></div>
        
        <p class="rj-help" x-show="field.help" x-text="field.help" style="margin-top: 8px;"></p>
    </div>
</template>