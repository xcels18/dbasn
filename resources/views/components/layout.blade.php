<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $title ?? 'SIM-ASN Puncak Jaya' }}</title>
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    
    <!-- Tailwind CSS & Config -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-highest": "#e0e2ea",
                        "on-secondary-fixed": "#002018",
                        "surface": "#f8f9ff",
                        "surface-card": "#FFFFFF",
                        "inverse-primary": "#b0c9e8",
                        "surface-container-low": "#f1f3fb",
                        "on-tertiary-fixed-variant": "#5f411b",
                        "on-tertiary-container": "#ae875c",
                        "tertiary-fixed-dim": "#ebbf8e",
                        "primary": "#001428",
                        "secondary-fixed": "#bceddb",
                        "secondary": "#396759",
                        "inverse-on-surface": "#eef0f8",
                        "status-success": "#1E4D40",
                        "surface-container-lowest": "#ffffff",
                        "surface-container": "#eceef6",
                        "sidebar-bg": "#0F2942",
                        "surface-tint": "#49607c",
                        "primary-container": "#0f2942",
                        "surface-container-high": "#e6e8f0",
                        "on-primary-container": "#7991af",
                        "tertiary-container": "#3b2201",
                        "outline-variant": "#c3c6ce",
                        "on-primary": "#ffffff",
                        "secondary-container": "#b9ead8",
                        "on-secondary": "#ffffff",
                        "primary-fixed-dim": "#b0c9e8",
                        "outline": "#74777e",
                        "primary-fixed": "#d1e4ff",
                        "border-subtle": "#C3C6CE",
                        "surface-bright": "#f8f9ff",
                        "surface-dim": "#d8dae2",
                        "tertiary-fixed": "#ffddb9",
                        "secondary-fixed-dim": "#a0d1bf",
                        "on-primary-fixed-variant": "#314863",
                        "background": "#f8f9ff",
                        "on-surface-variant": "#43474d",
                        "on-primary-fixed": "#011d35",
                        "on-tertiary": "#ffffff",
                        "on-error": "#ffffff",
                        "inverse-surface": "#2d3137",
                        "on-error-container": "#93000a",
                        "surface-variant": "#e0e2ea",
                        "error-container": "#ffdad6",
                        "on-secondary-container": "#3d6b5d",
                        "surface-main": "#FAF8FF",
                        "tertiary": "#1f0f00",
                        "on-tertiary-fixed": "#2b1700",
                        "error": "#ba1a1a",
                        "on-surface": "#181c21",
                        "on-secondary-fixed-variant": "#204f42",
                        "on-background": "#181c21",
                        "status-error": "#BA1A1A"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "stack-lg": "16px",
                        "section-gap": "24px",
                        "gutter": "16px",
                        "stack-sm": "6px",
                        "margin-tablet": "32px",
                        "margin-desktop": "32px",
                        "stack-md": "12px",
                        "sidebar-width": "240px"
                    },
                    "fontFamily": {
                        "body-lg": ["'Plus Jakarta Sans'", "sans-serif"],
                        "headline-md": ["'Plus Jakarta Sans'", "sans-serif"],
                        "body-sm": ["'Plus Jakarta Sans'", "sans-serif"],
                        "body-md": ["'Plus Jakarta Sans'", "sans-serif"],
                        "label-sm": ["'Plus Jakarta Sans'", "sans-serif"],
                        "label-lg": ["'Plus Jakarta Sans'", "sans-serif"],
                        "headline-xl": ["'Plus Jakarta Sans'", "sans-serif"],
                        "headline-lg": ["'Plus Jakarta Sans'", "sans-serif"],
                        "label-md": ["'Plus Jakarta Sans'", "sans-serif"],
                        "sans": ["'Plus Jakarta Sans'", "sans-serif"]
                    },
                    "fontSize": {
                        "body-lg": ["15px", {"lineHeight": "22px", "fontWeight": "400"}],
                        "headline-md": ["18px", {"lineHeight": "26px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "body-sm": ["12px", {"lineHeight": "18px", "fontWeight": "400"}],
                        "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "label-sm": ["11px", {"lineHeight": "14px", "letterSpacing": "0.01em", "fontWeight": "500"}],
                        "label-lg": ["14px", {"lineHeight": "20px", "fontWeight": "600"}],
                        "headline-xl": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "headline-lg": ["20px", {"lineHeight": "28px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "label-md": ["12px", {"lineHeight": "16px", "fontWeight": "600"}]
                    }
                }
            }
        }
    </script>
</head>
<body class="text-on-surface font-sans min-h-screen" style="background-color: #f8f9ff !important;">
    
    <x-sidebar />

    <x-topbar />

    <!-- MAIN CONTENT AREA (240px sidebar + 32px gap = 272px) -->
    <main class="pt-8 pb-16 px-4 md:pl-[272px] md:pr-margin-desktop min-h-[calc(100vh-64px)] w-full">
        <div class="max-w-[1200px] mx-auto w-full flex flex-col gap-section-gap">
            {{ $slot }}
        </div>
    </main>

</body>
</html>
