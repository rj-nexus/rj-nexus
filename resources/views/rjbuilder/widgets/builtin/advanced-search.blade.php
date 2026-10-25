@php
    $placeholder = $settings['placeholder'] ?? __('Search...');
    $style = $settings['style'] ?? 'minimal';
    $showImage = $settings['show_image'] ?? true;

    $inputClass = '';
    $wrapperClass = '';

    if ($style === 'filled') {
        $inputClass = 'w-full pl-12 pr-10 py-4 bg-slate-100 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-slate-800';
        $wrapperClass = 'w-full max-w-2xl mx-auto';
    } elseif ($style === 'dark') {
        $inputClass = 'w-full pl-12 pr-10 py-4 bg-slate-800 border border-slate-700 rounded-2xl text-white placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all';
        $wrapperClass = 'w-full max-w-2xl mx-auto';
    } else {
        $inputClass = 'w-full pl-12 pr-10 py-4 bg-transparent border-b-2 border-slate-300 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-indigo-600 transition-colors text-lg';
        $wrapperClass = 'w-full max-w-2xl mx-auto';
    }
@endphp

<div id="{{ $uid }}" class="{{ $wrapperClass }} relative py-4" data-url="{{ url('/search') }}">

    <div class="relative w-full group">
        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none {{ $style === 'dark' ? 'text-slate-400' : 'text-slate-500 group-focus-within:text-indigo-600' }} transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>

        <input type="text"
               class="rj-search-input {{ $inputClass }}"
               placeholder="{{ $placeholder }}"
               autocomplete="off">

        <div class="rj-search-spinner absolute inset-y-0 right-0 flex items-center pr-4 hidden {{ $style === 'dark' ? 'text-white' : 'text-indigo-600' }}">
            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg>
        </div>
    </div>

    <div class="rj-search-results absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden z-50 hidden max-h-[400px] overflow-y-auto"></div>
</div>

<script>
(function() {
    function initSearch_{{ str_replace('-', '_', $uid) }}() {
        const root = document.getElementById('{{ $uid }}');
        if (!root || root.dataset.initialized) return;
        root.dataset.initialized = 'true';

        const input = root.querySelector('.rj-search-input');
        const spinner = root.querySelector('.rj-search-spinner');
        const resultsBox = root.querySelector('.rj-search-results');
        const searchUrl = root.dataset.url;
        const showImage = {{ $showImage ? 'true' : 'false' }};

        let debounceTimer;

        input.addEventListener('input', (e) => {
            clearTimeout(debounceTimer);
            const query = e.target.value.trim();

            if (query.length < 2) {
                resultsBox.classList.add('hidden');
                return;
            }

            spinner.classList.remove('hidden');

            debounceTimer = setTimeout(() => {
                fetch(`${searchUrl}?q=${encodeURIComponent(query)}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Search failed');
                    return res.json();
                })
                .then(data => {
                    renderResults(data.results || data, query);
                })
                .catch(err => {
                    console.error(err);
                    resultsBox.innerHTML = '<div class="p-4 text-center text-red-500 text-sm">Error loading results.</div>';
                    resultsBox.classList.remove('hidden');
                })
                .finally(() => {
                    spinner.classList.add('hidden');
                });
            }, 400);
        });

        function renderResults(results, query) {
            if (!results || results.length === 0) {
                resultsBox.innerHTML = `<div class="p-6 text-center text-slate-500 text-sm">No results found for "${query}"</div>`;
                resultsBox.classList.remove('hidden');
                return;
            }

            let html = '';
            results.forEach(item => {
                const title = item.title || item.name || 'Untitled';
                const url = item.url || item.link || '#';
                const type = item.type || 'post';
                const image = item.image || item.featured_image || null;

                html += `
                    <a href="${url}" class="flex items-center gap-4 p-4 hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0 group">
                        ${showImage && image ? `
                            <div class="w-12 h-12 rounded-lg bg-slate-200 overflow-hidden flex-shrink-0">
                                <img src="${image}" class="w-full h-full object-cover">
                            </div>
                        ` : `
                            <div class="w-12 h-12 rounded-lg bg-indigo-50 text-indigo-500 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                        `}
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors truncate">${title}</h4>
                            <span class="text-xs text-slate-400 uppercase tracking-wider font-semibold mt-0.5 block">${type}</span>
                        </div>
                        <div class="text-slate-300 group-hover:text-indigo-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </a>
                `;
            });

            resultsBox.innerHTML = html;
            resultsBox.classList.remove('hidden');
        }

        document.addEventListener('click', (e) => {
            if (!root.contains(e.target)) {
                resultsBox.classList.add('hidden');
            }
        });

        input.addEventListener('focus', () => {
            if (input.value.trim().length >= 2 && resultsBox.innerHTML.trim() !== '') {
                resultsBox.classList.remove('hidden');
            }
        });
    }

    initSearch_{{ str_replace('-', '_', $uid) }}();
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSearch_{{ str_replace('-', '_', $uid) }});
    }
})();
</script>
