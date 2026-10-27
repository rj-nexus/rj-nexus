@php
    $title        = $settings['title'] ?? __('Now Playing');
    $source       = $settings['source'] ?? 'audius';
    $jamendoId    = trim($settings['jamendo_client_id'] ?? '');
    $audiusPl     = trim($settings['audius_playlist_id'] ?? '');
    $deezerPl     = trim($settings['deezer_playlist_id'] ?? '');
    $visualizer   = $settings['visualizer'] ?? 'bars';
    $accent       = $settings['accent'] ?? '#8b5cf6';
    $accent2      = $settings['accent2'] ?? '#ec4899';
    $height       = (int) ($settings['height'] ?? 220);
    $radius       = $settings['radius'] ?? 'xl';
    $showPlaylist = $settings['show_playlist'] ?? true;
    $autoplay     = $settings['autoplay'] ?? false;
    $paddingY     = (int) ($settings['padding_y'] ?? 60);

    $radiusMap = ['none' => '0px', 'md' => '12px', 'xl' => '20px', '2xl' => '28px'];
    $radiusCss = $radiusMap[$radius] ?? '20px';

    // Local/Custom faylları hazırlayırıq
    $localFiles = [];
    if (!empty($settings['local_files']) && is_array($settings['local_files'])) {
        foreach ($settings['local_files'] as $row) {
            if (!is_array($row)) continue;
            $url = trim((string) ($row['url'] ?? ''));
            $file = $row['file'] ?? '';

            if (is_array($file)) {
                $file = $file['url'] ?? ($file['src'] ?? (reset($file) ?: ''));
            }
            $file = is_string($file) ? trim($file) : '';

            $src = $url ?: $file;
            if ($src === '') continue;

            $localFiles[] = [
                'title'  => $row['title'] ?? __('Unknown Track'),
                'artist' => $row['artist'] ?? __('Unknown Artist'),
                'url'    => $src,
            ];
        }
    }
@endphp

<style>
    #{{ $uid }} {
        --mp-a: {{ $accent }};
        --mp-b: {{ $accent2 }};
        width: 100%;
        padding: {{ $paddingY }}px 16px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    #{{ $uid }} .rj-mp-inner {
        max-width: 1100px;
        margin: 0 auto;
        background: #0f172a;
        border-radius: {{ $radiusCss }};
        box-shadow: 0 30px 60px -20px rgba(0,0,0,0.6);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    #{{ $uid }} .rj-mp-header {
        padding: 20px 24px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    #{{ $uid }} .rj-mp-header h2 {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -.01em;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    #{{ $uid }} .rj-mp-header h2 svg {
        color: var(--mp-a);
    }

    #{{ $uid }} .rj-mp-layout {
        display: grid;
        grid-template-columns: {{ $showPlaylist ? '1fr 340px' : '1fr' }};
        min-height: {{ $height }}px;
    }
    @media (max-width: 768px) {
        #{{ $uid }} .rj-mp-layout {
            grid-template-columns: 1fr;
        }
    }

    /* ---------- PLAYER MAIN ---------- */
    #{{ $uid }} .rj-mp-main {
        position: relative;
        display: flex;
        flex-direction: column;
        background: linear-gradient(135deg, rgba(15,23,42,0.95), rgba(30,41,59,0.95));
        overflow: hidden;
    }

    #{{ $uid }} .rj-mp-canvas-wrap {
        position: absolute;
        inset: 0;
        z-index: 1;
        opacity: 0.6;
        pointer-events: none;
    }
    #{{ $uid }} .rj-mp-canvas {
        width: 100%;
        height: 100%;
        display: block;
    }

    #{{ $uid }} .rj-mp-content {
        position: relative;
        z-index: 2;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 32px;
    }

    #{{ $uid }} .rj-mp-track-info {
        display: flex;
        align-items: flex-end;
        gap: 20px;
    }
    #{{ $uid }} .rj-mp-cover {
        width: 100px;
        height: 100px;
        border-radius: 12px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    #{{ $uid }} .rj-mp-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    #{{ $uid }} .rj-mp-cover svg {
        width: 40px;
        height: 40px;
        color: rgba(255,255,255,0.2);
    }
    #{{ $uid }} .rj-mp-meta {
        flex: 1;
        min-width: 0;
    }
    #{{ $uid }} .rj-mp-now-title {
        font-size: 24px;
        font-weight: 800;
        color: #fff;
        margin: 0 0 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        letter-spacing: -.02em;
    }
    #{{ $uid }} .rj-mp-now-artist {
        font-size: 14px;
        color: rgba(255,255,255,0.6);
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ---------- CONTROLS ---------- */
    #{{ $uid }} .rj-mp-controls-wrap {
        margin-top: 32px;
    }
    #{{ $uid }} .rj-mp-progress-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        font-size: 11px;
        font-weight: 600;
        color: rgba(255,255,255,0.5);
        font-variant-numeric: tabular-nums;
    }
    #{{ $uid }} .rj-mp-progress-bar {
        flex: 1;
        height: 6px;
        background: rgba(255,255,255,0.1);
        border-radius: 3px;
        position: relative;
        cursor: pointer;
    }
    #{{ $uid }} .rj-mp-progress-fill {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 0%;
        background: linear-gradient(90deg, var(--mp-a), var(--mp-b));
        border-radius: 3px;
        transition: width 0.1s linear;
    }
    #{{ $uid }} .rj-mp-progress-fill::after {
        content: '';
        position: absolute;
        right: -6px;
        top: 50%;
        transform: translateY(-50%) scale(0);
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 0 10px rgba(255,255,255,0.5);
        transition: transform 0.2s ease;
    }
    #{{ $uid }} .rj-mp-progress-bar:hover .rj-mp-progress-fill::after {
        transform: translateY(-50%) scale(1);
    }

    #{{ $uid }} .rj-mp-buttons {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 24px;
    }
    #{{ $uid }} .rj-mp-btn {
        background: transparent;
        border: 0;
        color: rgba(255,255,255,0.7);
        cursor: pointer;
        padding: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s, transform 0.1s;
    }
    #{{ $uid }} .rj-mp-btn:hover {
        color: #fff;
        transform: scale(1.1);
    }
    #{{ $uid }} .rj-mp-btn:active {
        transform: scale(0.95);
    }
    #{{ $uid }} .rj-mp-btn svg {
        width: 24px;
        height: 24px;
    }
    #{{ $uid }} .rj-mp-btn-play {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--mp-a), var(--mp-b));
        color: #fff;
        box-shadow: 0 10px 25px -5px var(--mp-a);
    }
    #{{ $uid }} .rj-mp-btn-play:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 35px -5px var(--mp-a);
    }
    #{{ $uid }} .rj-mp-btn-play svg {
        width: 24px;
        height: 24px;
        margin-left: 2px; /* Play ikonunu mərkəzləşdirmək üçün */
    }
    #{{ $uid }} .rj-mp-btn-play.is-playing svg {
        margin-left: 0;
    }

    /* ---------- PLAYLIST SIDEBAR ---------- */
    #{{ $uid }} .rj-mp-sidebar {
        background: #0b1120;
        border-left: 1px solid rgba(255,255,255,0.05);
        display: flex;
        flex-direction: column;
        height: 100%;
        max-height: 500px;
    }
    #{{ $uid }} .rj-mp-sidebar-head {
        padding: 16px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: rgba(255,255,255,0.4);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    #{{ $uid }} .rj-mp-list {
        flex: 1;
        overflow-y: auto;
        padding: 8px;
    }
    #{{ $uid }} .rj-mp-list::-webkit-scrollbar { width: 6px; }
    #{{ $uid }} .rj-mp-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 3px; }

    #{{ $uid }} .rj-mp-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.2s;
    }
    #{{ $uid }} .rj-mp-item:hover {
        background: rgba(255,255,255,0.05);
    }
    #{{ $uid }} .rj-mp-item.is-active {
        background: rgba(255,255,255,0.1);
    }
    #{{ $uid }} .rj-mp-item.is-active .rj-mp-item-title {
        color: var(--mp-a);
    }
    #{{ $uid }} .rj-mp-item-num {
        width: 20px;
        font-size: 12px;
        font-weight: 700;
        color: rgba(255,255,255,0.3);
        text-align: center;
    }
    #{{ $uid }} .rj-mp-item.is-active .rj-mp-item-num {
        color: var(--mp-a);
    }
    #{{ $uid }} .rj-mp-item-info {
        flex: 1;
        min-width: 0;
    }
    #{{ $uid }} .rj-mp-item-title {
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        margin: 0 0 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    #{{ $uid }} .rj-mp-item-artist {
        font-size: 11px;
        color: rgba(255,255,255,0.5);
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #{{ $uid }} .rj-mp-loading {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px;
        color: rgba(255,255,255,0.4);
        font-size: 13px;
        gap: 12px;
    }
    #{{ $uid }} .rj-mp-spinner {
        width: 24px;
        height: 24px;
        border: 3px solid rgba(255,255,255,0.1);
        border-top-color: var(--mp-a);
        border-radius: 50%;
        animation: rjMpSpin 1s linear infinite;
    }
    @keyframes rjMpSpin { to { transform: rotate(360deg); } }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} * {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<div id="{{ $uid }}"
     data-source="{{ $source }}"
     data-jamendo="{{ $jamendoId }}"
     data-audius-pl="{{ $audiusPl }}"
     data-deezer-pl="{{ $deezerPl }}"
     data-visualizer="{{ $visualizer }}"
     data-accent="{{ $accent }}"
     data-accent2="{{ $accent2 }}"
     data-autoplay="{{ $autoplay ? '1' : '0' }}"
     data-local='@json($localFiles)'>

    <div class="rj-mp-inner">
        <div class="rj-mp-header">
            <h2>
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 18V5l12-2v13M6 21a3 3 0 100-6 3 3 0 000 6zm12-2a3 3 0 100-6 3 3 0 000 6z"/></svg>
                {{ $title }}
            </h2>
        </div>

        <div class="rj-mp-layout">
            <div class="rj-mp-main">
                <div class="rj-mp-canvas-wrap">
                    <canvas class="rj-mp-canvas" data-canvas></canvas>
                </div>

                <div class="rj-mp-content">
                    <div class="rj-mp-track-info">
                        <div class="rj-mp-cover" data-cover>
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                        </div>
                        <div class="rj-mp-meta">
                            <h3 class="rj-mp-now-title" data-now-title>{{ __('Select a track') }}</h3>
                            <p class="rj-mp-now-artist" data-now-artist>{{ __('Ready to play') }}</p>
                        </div>
                    </div>

                    <div class="rj-mp-controls-wrap">
                        <div class="rj-mp-progress-row">
                            <span data-time-current>0:00</span>
                            <div class="rj-mp-progress-bar" data-progress-bar>
                                <div class="rj-mp-progress-fill" data-progress-fill></div>
                            </div>
                            <span data-time-total>0:00</span>
                        </div>

                        <div class="rj-mp-buttons">
                            <button type="button" class="rj-mp-btn" data-prev>
                                <svg fill="currentColor" viewBox="0 0 24 24"><path d="M6 6h2v12H6zm3.5 6l8.5 6V6z"/></svg>
                            </button>
                            <button type="button" class="rj-mp-btn rj-mp-btn-play" data-play>
                                <svg data-icon-play fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                <svg data-icon-pause fill="currentColor" viewBox="0 0 24 24" style="display:none;"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                            </button>
                            <button type="button" class="rj-mp-btn" data-next>
                                <svg fill="currentColor" viewBox="0 0 24 24"><path d="M6 18l8.5-6L6 6v12zM16 6v12h2V6h-2z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <audio data-audio crossorigin="anonymous"></audio>
            </div>

            @if($showPlaylist)
                <div class="rj-mp-sidebar">
                    <div class="rj-mp-sidebar-head">
                        <span>{{ __('Playlist') }}</span>
                        <span data-count>0</span>
                    </div>
                    <div class="rj-mp-list" data-list>
                        <div class="rj-mp-loading" data-loading>
                            <div class="rj-mp-spinner"></div>
                            <span>{{ __('Loading tracks...') }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
(function() {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var source = root.getAttribute('data-source');
    var jamendoId = root.getAttribute('data-jamendo');
    var audiusPl = root.getAttribute('data-audius-pl');
    var deezerPl = root.getAttribute('data-deezer-pl');
    var visType = root.getAttribute('data-visualizer');
    var accent = root.getAttribute('data-accent');
    var accent2 = root.getAttribute('data-accent2');
    var autoplay = root.getAttribute('data-autoplay') === '1';
    var localTracks = JSON.parse(root.getAttribute('data-local') || '[]');

    var audio = root.querySelector('[data-audio]');
    var playBtn = root.querySelector('[data-play]');
    var prevBtn = root.querySelector('[data-prev]');
    var nextBtn = root.querySelector('[data-next]');
    var iconPlay = root.querySelector('[data-icon-play]');
    var iconPause = root.querySelector('[data-icon-pause]');

    var listEl = root.querySelector('[data-list]');
    var loadingEl = root.querySelector('[data-loading]');
    var nowTitle = root.querySelector('[data-now-title]');
    var nowArtist = root.querySelector('[data-now-artist]');
    var timeCurrent = root.querySelector('[data-time-current]');
    var timeTotal = root.querySelector('[data-time-total]');
    var progressFill = root.querySelector('[data-progress-fill]');
    var progressBar = root.querySelector('[data-progress-bar]');
    var canvas = root.querySelector('[data-canvas]');

    var tracks = [];
    var currentIndex = -1;
    var isPlaying = false;
    var audioCtx = null;
    var analyser = null;
    var dataArray = null;
    var sourceNode = null;
    var animationFrame = null;

    // 1. Track-ləri yüklə
    async function loadTracks() {
        // Əvvəlcə local əlavə edirik
        tracks = [...localTracks];

        if (source === 'audius') {
            try {
                let url = '';
                // Rəsmi Audius API ünvanı istifadə olunur (api.audius.co)
                if (audiusPl && !audiusPl.includes(' ')) {
                    url = `https://api.audius.co/v1/playlists/${audiusPl}/tracks?app_name=RJ_CMS`;
                } else if (audiusPl) {
                    let searchUrl = `https://api.audius.co/v1/playlists/search?query=${encodeURIComponent(audiusPl)}&app_name=RJ_CMS`;
                    let searchRes = await fetch(searchUrl);
                    let searchData = await searchRes.json();
                    if (searchData.data && searchData.data.length > 0) {
                        let firstPl = searchData.data[0];
                        url = `https://api.audius.co/v1/playlists/${firstPl.id}/tracks?app_name=RJ_CMS`;
                    }
                } else {
                    url = 'https://api.audius.co/v1/tracks/trending?app_name=RJ_CMS&limit=20';
                }

                if (url) {
                    let res = await fetch(url);
                    let data = await res.json();
                    let items = data.data || [];

                    items.forEach(function(t) {
                        let streamUrl = `https://api.audius.co/v1/tracks/${t.id}/stream?app_name=RJ_CMS`;
                        tracks.push({
                            title: t.title,
                            artist: t.user ? t.user.name : 'Audius Artist',
                            url: streamUrl,
                            cover: t.artwork ? t.artwork['150x150'] : null
                        });
                    });
                }
            } catch(e) { console.error('Audius error:', e); }
        }
        else if (source === 'jamendo' && jamendoId) {
            try {
                let jUrl = `https://api.jamendo.com/v3.0/tracks/?client_id=${jamendoId}&format=json&limit=20&include=musicinfo&audioformat=mp32`;
                let res = await fetch(jUrl);
                let data = await res.json();
                let items = data.results || [];

                items.forEach(function(t) {
                    tracks.push({
                        title: t.name,
                        artist: t.artist_name,
                        url: t.audio,
                        cover: t.image
                    });
                });
            } catch(e) { console.error('Jamendo error:', e); }
        }
        else if (source === 'deezer') {
            try {
                let dUrl = '';
                // Daha etibarlı olan codetabs proxy-si istifadə olunur
                let proxy = 'https://api.codetabs.com/v1/proxy?quest=';

                if (deezerPl && /^\d+$/.test(deezerPl)) {
                    dUrl = `https://api.deezer.com/playlist/${deezerPl}/tracks`;
                } else if (deezerPl) {
                    let searchUrl = `https://api.deezer.com/search/playlist?q=${encodeURIComponent(deezerPl)}`;
                    let searchRes = await fetch(proxy + encodeURIComponent(searchUrl));
                    let searchData = await searchRes.json();
                    if (searchData.data && searchData.data.length > 0) {
                        let firstPl = searchData.data[0];
                        dUrl = `https://api.deezer.com/playlist/${firstPl.id}/tracks`;
                    }
                } else {
                    dUrl = 'https://api.deezer.com/chart/0/tracks';
                }

                if (dUrl) {
                    let res = await fetch(proxy + encodeURIComponent(dUrl));
                    let data = await res.json();
                    let items = data.data || [];

                    items.forEach(function(t) {
                        if(t.preview) {
                            tracks.push({
                                title: t.title,
                                artist: t.artist.name,
                                url: t.preview,
                                cover: t.album ? t.album.cover : null
                            });
                        }
                    });
                }
            } catch(e) { console.error('Deezer error:', e); }
        }

        renderPlaylist();

        if (loadingEl) loadingEl.style.display = 'none';
        if (tracks.length > 0) {
            loadTrack(0, autoplay);
        } else {
            if (listEl) listEl.innerHTML = '<div style="padding:20px;text-align:center;color:rgba(255,255,255,0.4);font-size:13px;">No tracks found.</div>';
        }
    }

    // 2. Pley-listi göstər
    function renderPlaylist() {
        if (!listEl) return;
        listEl.innerHTML = '';
        var countEl = root.querySelector('[data-count]');
        if (countEl) countEl.textContent = tracks.length;

        tracks.forEach(function(t, i) {
            var item = document.createElement('div');
            item.className = 'rj-mp-item';
            item.innerHTML = `
                <div class="rj-mp-item-num">${i + 1}</div>
                <div class="rj-mp-item-info">
                    <p class="rj-mp-item-title">${escapeHtml(t.title)}</p>
                    <p class="rj-mp-item-artist">${escapeHtml(t.artist)}</p>
                </div>
            `;
            item.addEventListener('click', function() {
                loadTrack(i, true);
            });
            listEl.appendChild(item);
        });
    }

    // 3. Treki yüklə
    function loadTrack(index, play) {
        if (index < 0 || index >= tracks.length) return;
        currentIndex = index;
        var t = tracks[index];

        audio.src = t.url;
        nowTitle.textContent = t.title;
        nowArtist.textContent = t.artist;

        var coverEl = root.querySelector('[data-cover]');
        if (coverEl) {
            if (t.cover) {
                coverEl.innerHTML = `<img src="${t.cover}" alt="${escapeHtml(t.title)}" crossorigin="anonymous">`;
            } else {
                coverEl.innerHTML = `<svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>`;
            }
        }

        // Aktiv sinfi yenilə
        var items = listEl.querySelectorAll('.rj-mp-item');
        items.forEach(function(el, i) {
            el.classList.toggle('is-active', i === index);
        });

        if (play) {
            audio.play().catch(function(e) { console.log('Play error:', e); });
        }
    }

    // 4. Audio idarəetmə
    function togglePlay() {
        if (!audioCtx) initVisualizer();

        if (isPlaying) {
            audio.pause();
        } else {
            if (audioCtx.state === 'suspended') audioCtx.resume();
            audio.play().catch(function(e) { console.log('Play error:', e); });
        }
    }

    playBtn.addEventListener('click', togglePlay);

    prevBtn.addEventListener('click', function() {
        if (currentIndex > 0) loadTrack(currentIndex - 1, true);
    });
    nextBtn.addEventListener('click', function() {
        if (currentIndex < tracks.length - 1) loadTrack(currentIndex + 1, true);
    });

    audio.addEventListener('play', function() {
        isPlaying = true;
        playBtn.classList.add('is-playing');
        iconPlay.style.display = 'none';
        iconPause.style.display = 'block';
        if (!audioCtx) initVisualizer();
    });

    audio.addEventListener('pause', function() {
        isPlaying = false;
        playBtn.classList.remove('is-playing');
        iconPlay.style.display = 'block';
        iconPause.style.display = 'none';
    });

    audio.addEventListener('ended', function() {
        if (currentIndex < tracks.length - 1) {
            loadTrack(currentIndex + 1, true);
        } else {
            isPlaying = false;
            playBtn.classList.remove('is-playing');
            iconPlay.style.display = 'block';
            iconPause.style.display = 'none';
        }
    });

    audio.addEventListener('timeupdate', function() {
        if (audio.duration) {
            var pct = (audio.currentTime / audio.duration) * 100;
            progressFill.style.width = pct + '%';
            timeCurrent.textContent = formatTime(audio.currentTime);
            timeTotal.textContent = formatTime(audio.duration);
        }
    });

    progressBar.addEventListener('click', function(e) {
        var rect = progressBar.getBoundingClientRect();
        var pct = (e.clientX - rect.left) / rect.width;
        if (audio.duration) {
            audio.currentTime = pct * audio.duration;
        }
    });

    // 5. Vizualizator
    function initVisualizer() {
        if (visType === 'none' || !canvas) return;
        try {
            audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            analyser = audioCtx.createAnalyser();
            analyser.fftSize = 256;

            sourceNode = audioCtx.createMediaElementSource(audio);
            sourceNode.connect(analyser);
            analyser.connect(audioCtx.destination);

            var bufferLength = analyser.frequencyBinCount;
            dataArray = new Uint8Array(bufferLength);

            drawVisualizer();
        } catch(e) {
            console.warn('Visualizer not supported:', e);
        }
    }

    function drawVisualizer() {
        if (!canvas || !analyser) return;
        animationFrame = requestAnimationFrame(drawVisualizer);

        var ctx = canvas.getContext('2d');
        var w = canvas.width = canvas.clientWidth * window.devicePixelRatio;
        var h = canvas.height = canvas.clientHeight * window.devicePixelRatio;

        analyser.getByteFrequencyData(dataArray);

        ctx.clearRect(0, 0, w, h);

        if (visType === 'bars') {
            var barWidth = (w / dataArray.length) * 2.5;
            var x = 0;
            for (var i = 0; i < dataArray.length; i++) {
                var barHeight = (dataArray[i] / 255) * h;
                var grad = ctx.createLinearGradient(0, h, 0, h - barHeight);
                grad.addColorStop(0, accent2);
                grad.addColorStop(1, accent);
                ctx.fillStyle = grad;
                ctx.fillRect(x, h - barHeight, barWidth, barHeight);
                x += barWidth + 1;
            }
        }
        else if (visType === 'wave') {
            ctx.lineWidth = 2 * window.devicePixelRatio;
            ctx.strokeStyle = accent;
            ctx.beginPath();
            var sliceWidth = w / dataArray.length;
            var x = 0;
            for (var i = 0; i < dataArray.length; i++) {
                var v = dataArray[i] / 128.0;
                var y = (v * h) / 2;
                if (i === 0) ctx.moveTo(x, y);
                else ctx.lineTo(x, y);
                x += sliceWidth;
            }
            ctx.stroke();
        }
        else if (visType === 'circular') {
            var cx = w / 2;
            var cy = h / 2;
            var radius = Math.min(w, h) / 4;
            ctx.beginPath();
            ctx.arc(cx, cy, radius, 0, 2 * Math.PI);
            ctx.strokeStyle = 'rgba(255,255,255,0.05)';
            ctx.lineWidth = 2;
            ctx.stroke();

            for (var i = 0; i < dataArray.length; i++) {
                var angle = (i / dataArray.length) * Math.PI * 2;
                var amp = (dataArray[i] / 255) * (radius * 0.8);
                var x1 = cx + Math.cos(angle) * radius;
                var y1 = cy + Math.sin(angle) * radius;
                var x2 = cx + Math.cos(angle) * (radius + amp);
                var y2 = cy + Math.sin(angle) * (radius + amp);

                ctx.beginPath();
                ctx.moveTo(x1, y1);
                ctx.lineTo(x2, y2);
                ctx.strokeStyle = accent;
                ctx.lineWidth = 3;
                ctx.stroke();
            }
        }
    }

    // Köməkçi funksiyalar
    function formatTime(sec) {
        if (isNaN(sec)) return '0:00';
        var m = Math.floor(sec / 60);
        var s = Math.floor(sec % 60);
        return m + ':' + (s < 10 ? '0' : '') + s;
    }
    function escapeHtml(unsafe) {
        return (unsafe||'').replace(/[&<"'>]/g, function (match) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[match];
        });
    }

    // Başlat
    loadTracks();

})();
</script>
