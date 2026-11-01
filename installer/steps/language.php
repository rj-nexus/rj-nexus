Fix language step intro and landscape layout

- Stop disabling the intro under prefers-reduced-motion; play a
  softer variant instead (full effect forced with ?fx=1)
- Recompute layout on resize, orientationchange and visualViewport
  changes; compact header and smaller globe on short screens
- Neutralise base .lang-btn styles that drew a box behind the
  active language chip
- Add error fallback that shows a plain language grid if the
  animation script fails
