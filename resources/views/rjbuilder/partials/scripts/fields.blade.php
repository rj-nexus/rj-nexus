<script>
function builderFields() {
    return {
        iconPickerOpen: false,
        iconTargetField: null,
        iconSearch: '',
        iconsLoading: false,
        iconList: [],
        iconError: false,
        iconHost: 'https://api.iconify.design',
        iconHosts: [
            'https://api.iconify.design',
            'https://api.simplesvg.com',
            'https://api.unisvg.com'
        ],
        manualIcon: '',

        repeaterEdit: {
            open: false,
            field: null,
            index: null,
            item: null,
            inputEl: null,
            dropdown: null,
            creatingNewCat: null
        },

        getLocalizedKey(name) {
            return this.activeLocale === this.baseLocale ? name : name + '__' + this.activeLocale;
        },

        openIconPicker(fieldName) {
            this.iconTargetField = fieldName;
            this.iconSearch = '';
            this.iconList = [];
            this.manualIcon = '';
            this.iconPickerOpen = true;
            this.searchIcons();
        },

        selectIcon(iconName) {
            if (this.iconTargetField) {
                this.updateSetting(this.iconTargetField, iconName);
            }
            this.iconPickerOpen = false;
        },

        useManualIcon() {
            const v = (this.manualIcon || '').trim();
            if (!v) return;
            this.selectIcon(v);
            this.manualIcon = '';
        },

        getIconSvg(iconName) {
            if (!iconName) return '';
            let urlName = iconName.replace(':', '/');
            return '<img src="' + this.iconHost + '/' + urlName + '.svg?color=%2364748b" style="width:100%; height:100%; object-fit:contain;" onerror="this.style.visibility=\'hidden\'" />';
        },

        async searchIcons() {
            this.iconsLoading = true;
            this.iconError = false;
            const q = (this.iconSearch || '').trim() || 'home';
            let ok = false;

            for (const host of this.iconHosts) {
                try {
                    const ctrl = new AbortController();
                    const timer = setTimeout(() => ctrl.abort(), 6000);
                    const res = await fetch(host + '/search?query=' + encodeURIComponent(q) + '&limit=64', { signal: ctrl.signal });
                    clearTimeout(timer);
                    if (!res.ok) continue;
                    const data = await res.json();
                    this.iconList = data.icons || [];
                    this.iconHost = host;
                    ok = true;
                    break;
                } catch (e) {
                    console.error('Icon host failed:', host, e);
                }
            }

            if (!ok) {
                this.iconList = [];
                this.iconError = true;
            }
            this.iconsLoading = false;
        },

        dimDefaults() {
            return { top: '', right: '', bottom: '', left: '', unit: 'px', linked: false };
        },

        dimGet(field) {
            const b = this.currentBlock;
            if (!b) return this.dimDefaults();
            const key = this.getLocalizedKey(field.name);
            const v = this.getBlockField(b, key);
            if (v && typeof v === 'object') {
                return Object.assign(this.dimDefaults(), v);
            }
            return this.dimDefaults();
        },

        dimSet(field, patch) {
            const b = this.currentBlock;
            if (!b) return;
            const cur = this.dimGet(field);
            const next = Object.assign({}, cur, patch);
            if (next.linked) {
                let v = null;
                if (patch.top !== undefined) v = patch.top;
                else if (patch.right !== undefined) v = patch.right;
                else if (patch.bottom !== undefined) v = patch.bottom;
                else if (patch.left !== undefined) v = patch.left;
                if (v !== null) {
                    next.top = v;
                    next.right = v;
                    next.bottom = v;
                    next.left = v;
                }
            }
            this.updateSetting(field.name, next);
            this.commitSoon(this.t('Edited') + ' ' + this.blockLabel(b.type));
        },

        dimToggleLink(field) {
            const cur = this.dimGet(field);
            const linked = !cur.linked;
            if (linked) {
                const v = cur.top || cur.right || cur.bottom || cur.left || '';
                this.dimSet(field, { linked: true, top: v, right: v, bottom: v, left: v });
            } else {
                this.dimSet(field, { linked: false });
            }
        },

        dimFieldCss(field) {
            const v = this.dimGet(field);
            const u = v.unit || 'px';
            const t = v.top !== '' ? v.top + u : '0';
            const r = v.right !== '' ? v.right + u : '0';
            const b = v.bottom !== '' ? v.bottom + u : '0';
            const l = v.left !== '' ? v.left + u : '0';
            return t + ' ' + r + ' ' + b + ' ' + l;
        },

        dimEmpty(field) {
            const v = this.dimGet(field);
            return v.top === '' && v.right === '' && v.bottom === '' && v.left === '';
        },

        addRepeaterItem(field) {
            const key = this.getLocalizedKey(field.name);
            const cur = [...(this.currentSettings[key] || [])];
            const empty = {};
            (field.fields || []).forEach(f => { empty[f.name] = ''; });
            cur.push(empty);
            this.updateSetting(field.name, cur);
            this.repeaterEdit = {
                open: true,
                field: field,
                index: cur.length - 1,
                item: Object.assign({}, empty),
                inputEl: null,
                dropdown: null,
                creatingNewCat: null
            };
        },

        openRepeaterItem(field, idx) {
            const key = this.getLocalizedKey(field.name);
            const cur = this.currentSettings[key] || this.currentSettings[field.name] || [];
            if (!cur[idx]) return;
            this.repeaterEdit = {
                open: true,
                field: field,
                index: idx,
                item: Object.assign({}, cur[idx]),
                inputEl: null,
                dropdown: null,
                creatingNewCat: null
            };
        },

        removeRepeaterItem(field, idx) {
            const key = this.getLocalizedKey(field.name);
            const cur = [...(this.currentSettings[key] || this.currentSettings[field.name] || [])];
            cur.splice(idx, 1);
            this.updateSetting(field.name, cur);
            if (this.repeaterEdit.open && this.repeaterEdit.field && this.repeaterEdit.field.name === field.name && this.repeaterEdit.index === idx) {
                this.repeaterEdit.open = false;
            }
        },

        setRepeaterField(name, value) {
            if (!this.repeaterEdit.open || !this.repeaterEdit.field) return;
            const fieldName = this.repeaterEdit.field.name;
            const key = this.getLocalizedKey(fieldName);
            const cur = [...(this.currentSettings[key] || this.currentSettings[fieldName] || [])];
            if (!cur[this.repeaterEdit.index]) return;
            cur[this.repeaterEdit.index] = Object.assign({}, cur[this.repeaterEdit.index], { [name]: value });
            this.repeaterEdit.item = cur[this.repeaterEdit.index];
            this.updateSetting(fieldName, cur);
        },

        saveNewCategory(sub) {
            if (!this.repeaterEdit.open || !this.repeaterEdit.field) return;
            const val = (this.repeaterEdit.item[sub.name] || '').trim();

            if (!val) {
                this.repeaterEdit.creatingNewCat = null;
                return;
            }

            this.setRepeaterField(sub.name, val);

            if (sub.source) {
                const sourceKey = this.getLocalizedKey(sub.source);
                let currentList = (this.currentSettings[sourceKey] || this.currentSettings[sub.source] || '')
                    .split(',')
                    .map(s => s.trim())
                    .filter(Boolean);

                if (!currentList.includes(val)) {
                    currentList.push(val);
                    this.updateSetting(sub.source, currentList.join(', '));
                }
            }

            this.repeaterEdit.creatingNewCat = null;
        },

        pickRepeaterMedia(subName) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.dataset.repeaterSub = subName;
            this.repeaterEdit.inputEl = input;
            window.dispatchEvent(new CustomEvent('open-media-picker', { detail: { value: input } }));
        },

        onRepeaterMedia(e) {
            if (!this.repeaterEdit.open || !this.repeaterEdit.inputEl) return;
            if (e.detail.target !== this.repeaterEdit.inputEl) return;
            const subName = this.repeaterEdit.inputEl.dataset.repeaterSub;
            this.setRepeaterField(subName, e.detail.url);
            this.repeaterEdit.inputEl = null;
        }
    };
}
</script>
