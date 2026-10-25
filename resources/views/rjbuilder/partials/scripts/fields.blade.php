<script>
function builderFields() {
    return {
        iconPickerOpen: false,
        iconTargetField: null,
        iconSearch: '',
        iconsLoading: false,
        iconList: [],

        openIconPicker(fieldName) {
            this.iconTargetField = fieldName;
            this.iconSearch = '';
            this.iconList = [];
            this.iconPickerOpen = true;
            this.searchIcons();
        },

        selectIcon(iconName) {
            if (this.iconTargetField) {
                this.updateSetting(this.iconTargetField, iconName);
            }
            this.iconPickerOpen = false;
        },

        getIconSvg(iconName) {
            if (!iconName) return '';
            let urlName = iconName.replace(':', '/');
            return '<img src="https://api.iconify.design/' + urlName + '.svg?color=%2364748b" style="width:100%; height:100%; object-fit:contain;" />';
        },

        async searchIcons() {
            this.iconsLoading = true;
            try {
                const q = this.iconSearch || 'home';
                const res = await fetch('https://api.iconify.design/search?query=' + encodeURIComponent(q) + '&limit=64');
                const data = await res.json();
                this.iconList = data.icons || [];
            } catch (e) {
                console.error(e);
                this.iconList = [];
            } finally {
                this.iconsLoading = false;
            }
        },

        dimDefaults() {
            return { top: '', right: '', bottom: '', left: '', unit: 'px', linked: false };
        },

        dimGet(field) {
            const b = this.currentBlock;
            if (!b) return this.dimDefaults();
            const v = this.getBlockField(b, field.name);
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
            this.setBlockField(b, field.name, next);
            this.markDirty();
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
        }
    };
}
</script>
