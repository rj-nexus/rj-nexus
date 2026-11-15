<style>
    #{{ $uid }} {
        width: 100%;
        padding: 96px 24px;
        background: transparent;
        font-family: var(--rj-font-body);
    }

    #{{ $uid }} .rj-vs-header {
        text-align: center;
        max-width: 640px;
        margin: 0 auto 56px;
    }

    #{{ $uid }} .rj-vs-title {
        font-size: clamp(28px, 4vw, 42px);
        font-weight: 800;
        color: var(--rj-text);
        line-height: 1.15;
        margin: 0 0 16px 0;
        letter-spacing: -0.02em;
    }

    #{{ $uid }} .rj-vs-subtitle {
        font-size: 16px;
        line-height: 1.6;
        color: var(--rj-muted);
        margin: 0;
    }

    #{{ $uid }} .rj-vs-mockup {
        max-width: 1000px;
        margin: 0 auto;
        background: var(--rj-surface);
        border: 1px solid var(--rj-border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 32px 80px -20px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.05);
        position: relative;
    }

    #{{ $uid }} .rj-vs-toolbar {
        height: 40px;
        background: rgba(255, 255, 255, 0.02);
        border-bottom: 1px solid var(--rj-border);
        display: flex;
        align-items: center;
        padding: 0 16px;
        gap: 8px;
    }

    #{{ $uid }} .rj-vs-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }
    #{{ $uid }} .rj-vs-dot.red { background: #ff5f56; }
    #{{ $uid }} .rj-vs-dot.yellow { background: #ffbd2e; }
    #{{ $uid }} .rj-vs-dot.green { background: #27c93f; }

    #{{ $uid }} .rj-vs-url-bar {
        flex: 1;
        background: rgba(0, 0, 0, 0.2);
        height: 24px;
        border-radius: 6px;
        margin: 0 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        color: #64748b;
        font-family: monospace;
    }

    #{{ $uid }} .rj-vs-cover {
        position: relative;
        width: 100%;
        aspect-ratio: 16/9;
        background: #0f172a;
        cursor: pointer;
        overflow: hidden;
    }

    #{{ $uid }} .rj-vs-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        opacity: 0.8;
    }

    #{{ $uid }} .rj-vs-cover:hover img {
        transform: scale(1.03);
        opacity: 0.9;
    }

    #{{ $uid }} .rj-vs-play-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        transition: all 0.3s ease;
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.2);
        animation: rjVsPulse 2s infinite;
    }

    #{{ $uid }} .rj-vs-cover:hover .rj-vs-play-btn {
        background: rgba(139, 92, 246, 0.8);
        border-color: rgba(139, 92, 246, 1);
        transform: translate(-50%, -50%) scale(1.1);
        box-shadow: 0 0 0 12px rgba(139, 92, 246, 0.2);
        animation: none;
    }

    #{{ $uid }} .rj-vs-play-btn svg {
        width: 32px;
        height: 32px;
        margin-left: 4px;
    }

    @keyframes rjVsPulse {
        0% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.2); }
        70% { box-shadow: 0 0 0 20px rgba(255, 255, 255, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0); }
    }

    #{{ $uid }}-lightbox {
        position: fixed;
        inset: 0;
        z-index: 999999;
        background: rgba(0, 0, 0, 0.9);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    #{{ $uid }}-lightbox.is-open {
        opacity: 1;
        pointer-events: auto;
    }

    #{{ $uid }}-lightbox .rj-vs-close {
        position: absolute;
        top: 24px;
        right: 24px;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }

    #{{ $uid }}-lightbox .rj-vs-close:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    #{{ $uid }}-lightbox .rj-vs-iframe-wrap {
        width: 90%;
        max-width: 1200px;
        aspect-ratio: 16/9;
        background: #000;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 32px 80px rgba(0, 0, 0, 0.8);
        transform: scale(0.95);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    #{{ $uid }}-lightbox.is-open .rj-vs-iframe-wrap {
        transform: scale(1);
    }

    #{{ $uid }}-lightbox iframe,
    #{{ $uid }}-lightbox video {
        width: 100%;
        height: 100%;
        border: none;
        display: block;
    }

    @media (max-width: 768px) {
        #{{ $uid }} {
            padding: 64px 20px;
        }
        #{{ $uid }} .rj-vs-play-btn {
            width: 60px;
            height: 60px;
        }
        #{{ $uid }} .rj-vs-play-btn svg {
            width: 24px;
            height: 24px;
        }
    }
</style>

<div id="{{ $uid }}">
    <div class="rj-vs-header">
        @if(!empty($settings['title']))
            <h2 class="rj-vs-title">{{ $settings['title'] }}</h2>
        @endif
        @if(!empty($settings['subtitle']))
            <p class="rj-vs-subtitle">{{ $settings['subtitle'] }}</p>
        @endif
    </div>

    <div class="rj-vs-mockup">
        <div class="rj-vs-toolbar">
            <div class="rj-vs-dot red"></div>
            <div class="rj-vs-dot yellow"></div>
            <div class="rj-vs-dot green"></div>
            <div class="rj-vs-url-bar">https://{{ rj_get_option('site_url', 'rjnexus.org') }}</div>
        </div>
        
        <div class="rj-vs-cover" data-video-url="{{ $settings['video_url'] ?? '' }}">
            @if(!empty($settings['cover_image']))
                <img src="{{ $settings['cover_image'] }}" alt="Video Cover">
            @else
                <div style="width:100%; height:100%; background: linear-gradient(45deg, #1e1b4b, #0f172a);"></div>
            @endif
            
            <div class="rj-vs-play-btn">
                <svg fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            </div>
        </div>
    </div>
</div>

<div id="{{ $uid }}-lightbox">
    <button class="rj-vs-close" aria-label="Close">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
    <div class="rj-vs-iframe-wrap"></div>
</div>

<script>
    (function() {
        var root = document.getElementById('{{ $uid }}');
        var lightbox = document.getElementById('{{ $uid }}-lightbox');
        if (!root || !lightbox) return;

        var cover = root.querySelector('.rj-vs-cover');
        var closeBtn = lightbox.querySelector('.rj-vs-close');
        var videoWrap = lightbox.querySelector('.rj-vs-iframe-wrap');
        var videoUrl = cover.getAttribute('data-video-url');

        function getEmbedUrl(url) {
            if (!url) return '';
            if (url.includes('youtube.com/watch?v=')) {
                var id = url.split('v=')[1].split('&')[0];
                return 'https://www.youtube.com/embed/' + id + '?autoplay=1&rel=0';
            }
            if (url.includes('youtu.be/')) {
                var id = url.split('youtu.be/')[1].split('?')[0];
                return 'https://www.youtube.com/embed/' + id + '?autoplay=1&rel=0';
            }
            if (url.includes('vimeo.com/')) {
                var id = url.split('vimeo.com/')[1].split('?')[0];
                return 'https://player.vimeo.com/video/' + id + '?autoplay=1';
            }
            return url;
        }

        cover.addEventListener('click', function() {
            var embedUrl = getEmbedUrl(videoUrl);
            
            if (embedUrl.endsWith('.mp4') || embedUrl.endsWith('.webm')) {
                videoWrap.innerHTML = '<video src="' + embedUrl + '" controls autoplay></video>';
            } else {
                videoWrap.innerHTML = '<iframe src="' + embedUrl + '" allow="autoplay; fullscreen" allowfullscreen></iframe>';
            }
            
            lightbox.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        });

        function closeLightbox() {
            lightbox.classList.remove('is-open');
            document.body.style.overflow = '';
            setTimeout(function() {
                videoWrap.innerHTML = '';
            }, 300);
        }

        closeBtn.addEventListener('click', closeLightbox);
        
        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && lightbox.classList.contains('is-open')) {
                closeLightbox();
            }
        });
    })();
</script>