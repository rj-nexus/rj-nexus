<template x-if="field.type === 'text' || field.type === 'textarea' || field.type === 'rich_text'">
    <div class="rj-quill" x-data="{
        editor() {
            return this.$refs.quillEditor ? this.$refs.quillEditor._rjq : null;
        },

        loadQuill() {
            if (window.Quill) return Promise.resolve();
            if (window.__rjQuillPromise) return window.__rjQuillPromise;

            window.__rjQuillPromise = new Promise((resolve, reject) => {
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = 'https://cdn.quilljs.com/1.3.6/quill.snow.css';
                document.head.appendChild(link);

                const script = document.createElement('script');
                script.src = 'https://cdn.quilljs.com/1.3.6/quill.js';
                script.onload = resolve;
                script.onerror = reject;
                document.head.appendChild(script);
            });

            return window.__rjQuillPromise;
        },

        initEditor() {
            this.loadQuill().then(() => this.setupQuill());
        },

        setupQuill() {
            const host = this.$refs.quillEditor;
            if (!host || host._rjq) return;

            const quill = new Quill(host, {
                theme: 'snow',
                placeholder: field.placeholder || 'Write something beautiful...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'align': [] }],
                        ['link', 'image', 'video'],
                        ['clean']
                    ]
                }
            });

            host._rjq = quill;

            const initial = fieldValue(field) || '';
            if (initial) {
                quill.setContents(quill.clipboard.convert(initial), 'silent');
            }

            quill.on('text-change', () => {
                let html = quill.root.innerHTML;
                if (html === '<p><br></p>') html = '';
                updateSetting(field.name, html);
            });
        },

        syncEditor() {
            const next = fieldValue(field) || '';
            const quill = this.editor();
            if (!quill) return;

            let current = quill.root.innerHTML;
            if (current === '<p><br></p>') current = '';

            if (next !== current) {
                quill.setContents(quill.clipboard.convert(next), 'silent');
            }
        }
    }"
    x-init="initEditor()"
    x-effect="syncEditor()">

        <style>
            .rj-quill .ql-toolbar.ql-snow {
                position: sticky;
                top: 0;
                z-index: 5;
                display: flex;
                flex-wrap: wrap;
                padding: 8px;
                border-color: var(--line);
                background: var(--bg2);
                border-radius: 8px 8px 0 0;
            }
            .rj-quill .ql-container.ql-snow {
                height: 320px;
                border-color: var(--line);
                border-radius: 0 0 8px 8px;
                background: #ffffff;
                color: #111827;
                font-family: inherit;
                font-size: 14px;
            }
            .rj-quill .ql-editor {
                height: 100%;
                overflow-y: auto;
                line-height: 1.7;
                font-size: 15px;
            }
            .rj-quill .ql-editor.ql-blank::before {
                color: #9ca3af;
                font-style: normal;
            }
            .rj-quill .ql-snow .ql-stroke { stroke: #e5e7eb; }
            .rj-quill .ql-snow .ql-fill { fill: #e5e7eb; }
            .rj-quill .ql-snow .ql-picker { color: #e5e7eb; }
            .rj-quill .ql-snow .ql-picker-options { background-color: var(--bg2); border-color: var(--line); }
            .rj-quill .ql-snow .ql-picker-item { color: var(--text); }
            .rj-quill .ql-snow .ql-picker-item:hover { color: #a78bfa; }
            .rj-quill .ql-snow.ql-toolbar button:hover .ql-stroke,
            .rj-quill .ql-snow.ql-toolbar button.ql-active .ql-stroke { stroke: #a78bfa; }
            .rj-quill .ql-snow.ql-toolbar button:hover .ql-fill,
            .rj-quill .ql-snow.ql-toolbar button.ql-active .ql-fill { fill: #a78bfa; }
        </style>

        <div x-ref="quillEditor"></div>

        <p class="rj-help" x-show="field.help" x-text="field.help" style="margin-top: 8px;"></p>
    </div>
</template>