@extends('layouts.app')

@section('content')

    @if(!isset($parent))
        <!-- Custom Image Based Curtain Splash Screen -->
        <div id="splash-screen"
            class="fixed inset-0 z-[100] flex items-center justify-center pointer-events-none overflow-hidden">

            <!-- Left Curtain Panel (Seamless Half) -->
            <div id="curtain-left"
                class="absolute top-0 left-0 w-1/2 h-full z-10 transition-transform duration-[2000ms] ease-[cubic-bezier(0.645,0.045,0.355,1)] origin-left border-r shadow-[5px_0_30px_rgba(0,0,0,0.8)]"
                style="background-image: url('{{ asset('curtain.png') }}'); background-size: 200% 100%; background-position: left center; background-repeat: no-repeat;">
            </div>

            <!-- Right Curtain Panel (Seamless Half) -->
            <div id="curtain-right"
                class="absolute top-0 right-0 w-1/2 h-full z-10 transition-transform duration-[2000ms] ease-[cubic-bezier(0.645,0.045,0.355,1)] origin-right border-l shadow-[-5px_0_30px_rgba(0,0,0,0.8)]"
                style="background-image: url('{{ asset('curtain.png') }}'); background-size: 200% 100%; background-position: right center; background-repeat: no-repeat;">
            </div>

            <!-- Splash Content (Logo + Text) -->
            <div id="splash-content"
                class="absolute inset-0 flex flex-col items-center justify-center z-30 pointer-events-none transition-all duration-[1000ms] ease-[cubic-bezier(0.68,-0.55,0.265,1.55)] transform gap-5">
                <div id="splash-logo"
                    class="w-32 h-32 md:w-48 md:h-48 bg-white/90 rounded-full p-2 shadow-[0_0_120px_rgba(255,255,100,0.8)] border-[5px] border-[#d4af37] flex items-center justify-center transition-transform duration-[1000ms] ease-in-out transform relative">
                    <img src="{{ asset('logo.png') }}?v={{ time() }}" onerror="this.style.display='none'"
                        class="w-full h-full object-cover rounded-full">
                    <!-- Inner glow / Pulser -->
                    <div class="absolute inset-0 rounded-full border-4 border-white animate-ping opacity-30"></div>
                </div>

                <!-- Welcome Text -->
                <h2 class="text-4xl md:text-5xl text-center text-white font-bold leading-tight"
                    style="font-family: 'Dancing Script', cursive; text-shadow: 2px 2px 4px rgba(0,0,0,0.9), 0 0 25px rgba(212,175,55,0.9);">
                    Selamat datang di<br>
                    <span class="text-3xl md:text-4xl text-yellow-300"
                        style="font-family: 'Montserrat', sans-serif; text-shadow: 2px 2px 5px rgba(0,0,0,0.9);">SMK Budi Utomo
                        Way Jepara</span>
                </h2>
            </div>
        </div>

        <!-- Script Animation & Voice Initializer -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const splashScreen = document.getElementById('splash-screen');
                const splashContent = document.getElementById('splash-content');
                const splashLogo = document.getElementById('splash-logo');
                const leftCurtain = document.getElementById('curtain-left');
                const rightCurtain = document.getElementById('curtain-right');
                let hasGreeted = false;

                // Optional: prevent background scrolling during splash
                document.body.style.overflow = 'hidden';

                // Prepare Voice Greeting
                const greetVoice = function () {
                    if (hasGreeted) return;
                    hasGreeted = true;
                    if ('speechSynthesis' in window) {
                        const msg = new SpeechSynthesisUtterance("Selamat datang di laman resmi SMK Budi Utomo.");
                        msg.lang = 'id-ID';
                        msg.pitch = 1.3; // slightly higher for softer female tone
                        msg.rate = 0.95; // gentle, elegant pacing

                        let voices = window.speechSynthesis.getVoices();
                        let idVoice = voices.find(v => v.lang === 'id-ID' && (v.name.toLowerCase().includes('female') || v.name.toLowerCase().includes('perempuan') || true));
                        if (idVoice) msg.voice = idVoice;

                        window.speechSynthesis.speak(msg);
                    }
                };

                setTimeout(() => {
                    // 1. Logo spins, and the ENTIRE content (logo + text) shrinks and vanishes
                    splashLogo.style.transform = 'rotate(720deg)';
                    splashContent.style.transform = 'scale(0)';
                    splashContent.style.opacity = '0';

                    setTimeout(() => {
                        // 1.5. Play the Greeting Voice as the curtains start to move
                        try { greetVoice(); } catch (e) { }

                        // 2. Curtains pull back heavily
                        leftCurtain.style.transform = 'translateX(-100%)';
                        rightCurtain.style.transform = 'translateX(100%)';
                        document.body.style.overflow = 'auto'; // allow scroll

                        setTimeout(() => {
                            // 3. Remove splash screen container
                            splashScreen.style.display = 'none';
                        }, 1500); // Wait for the slow grand 1.5s curtain slide
                    }, 700); // Pause after logo shrinks

                }, 1200); // 1.2s starting hold

                // Fallback Voice trigger if browser blocks autoplay audio until interaction
                ['click', 'touchstart'].forEach(evt => {
                    document.addEventListener(evt, () => {
                        if (!hasGreeted && splashScreen.style.display === 'none') {
                            greetVoice();
                        }
                    }, { once: true, passive: true });
                });
            });
        </script>
    @endif

    <style>
        /* ... existing keyframes below this ... */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .animate-delay-1 {
            animation-delay: 0.1s;
        }

        .animate-delay-2 {
            animation-delay: 0.2s;
        }

        .animate-delay-3 {
            animation-delay: 0.3s;
        }

        /* GTranslate tweaks */
        body {
            top: 0 !important;
        }

        .skiptranslate {
            display: none !important;
        }

        /* Elegant Meteor / Shooting Stars Animation */
        .night-sky {
            position: absolute;
            inset: 0;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }

        .meteor {
            position: absolute;
            width: 2px;
            height: 60px;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(255, 255, 255, 1));
            opacity: 0;
            transform: rotate(45deg);
            border-radius: 999px;
            animation: meteor-fall linear infinite;
            filter: drop-shadow(0 0 4px rgba(255, 255, 255, 0.8));
        }

        .meteor::before {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            opacity: 1;
            transform: translateX(-50%);
            background: white;
            box-shadow: 0 0 10px 2px white;
        }

        @keyframes meteor-fall {
            0% {
                transform: translate(10vw, -20vh) rotate(45deg);
                opacity: 1;
                height: 60px;
            }

            100% {
                transform: translate(-120vw, 120vh) rotate(45deg);
                opacity: 0;
                height: 120px;
            }
        }

        /* Generate random delays & positions purely in CSS */
        .meteor:nth-child(1) {
            top: -20%;
            left: 30%;
            animation-duration: 4s;
            animation-delay: 0s;
        }

        .meteor:nth-child(2) {
            top: 10%;
            left: 120%;
            animation-duration: 5s;
            animation-delay: 2s;
        }

        .meteor:nth-child(3) {
            top: -10%;
            left: 60%;
            animation-duration: 3.5s;
            animation-delay: 6s;
        }

        .meteor:nth-child(4) {
            top: -30%;
            left: 100%;
            animation-duration: 4.5s;
            animation-delay: 4.5s;
        }

        .meteor:nth-child(5) {
            top: 30%;
            left: 150%;
            animation-duration: 5.5s;
            animation-delay: 8s;
        }

        .meteor:nth-child(6) {
            top: 0%;
            left: 90%;
            animation-duration: 4s;
            animation-delay: 1.5s;
        }

        /* Fix overlapping background bug */
        html,
        body {
            overflow-x: hidden;
        }

        /* Floating Major Icons (Jurusan SMK) */
        @keyframes float-icon {
            0% {
                transform: translateY(110vh) translateX(-5vw) rotate(0deg) scale(0.8);
                opacity: 0;
            }

            10% {
                opacity: 0.25;
            }

            90% {
                opacity: 0.25;
            }

            100% {
                transform: translateY(-20vh) translateX(15vw) rotate(360deg) scale(1.2);
                opacity: 0;
            }
        }

        .floating-icon {
            position: absolute;
            font-size: 1.75rem;
            color: rgba(255, 255, 255, 1);
            /* Will be semi-transparent by animation */
            filter: drop-shadow(0 0 3px rgba(255, 255, 255, 0.5));
            z-index: -1;
            opacity: 0;
            animation: float-icon linear infinite;
        }
    </style>
    <div class="night-sky">
        <!-- Meteors -->
        @for($i = 1; $i <= 6; $i++)
            <span class="meteor"></span>
        @endfor

        <!-- Floating Major Icons -->
        @php
            $icons = [
                ['icon' => 'fa-palette', 'delay' => '0s', 'dur' => '22s', 'left' => '10%'], // DKV
                ['icon' => 'fa-calculator', 'delay' => '3s', 'dur' => '25s', 'left' => '25%'], // AK
                ['icon' => 'fa-laptop-code', 'delay' => '6s', 'dur' => '20s', 'left' => '40%'], // BD
                ['icon' => 'fa-cut', 'delay' => '9s', 'dur' => '23s', 'left' => '55%'], // DPB
                ['icon' => 'fa-spa', 'delay' => '12s', 'dur' => '24s', 'left' => '70%'], // TKKR
                ['icon' => 'fa-cogs', 'delay' => '15s', 'dur' => '21s', 'left' => '85%'], // TP
                ['icon' => 'fa-motorcycle', 'delay' => '18s', 'dur' => '26s', 'left' => '15%'], // TSM
                ['icon' => 'fa-car-side', 'delay' => '21s', 'dur' => '22s', 'left' => '45%'], // TKR
                ['icon' => 'fa-snowflake', 'delay' => '24s', 'dur' => '27s', 'left' => '60%'], // TPTU
                ['icon' => 'fa-tractor', 'delay' => '27s', 'dur' => '20s', 'left' => '80%'] // TAB
            ];
        @endphp

        @foreach($icons as $ic)
            <i class="fas {{ $ic['icon'] }} floating-icon dark:text-gray-300 text-gray-500"
                style="left: {{ $ic['left'] }}; animation-duration: {{ $ic['dur'] }}; animation-delay: {{ $ic['delay'] }};"></i>
        @endforeach
    </div>
    <div class="max-w-[480px] mx-auto py-10 px-4 relative">

        @if(isset($parent))
            <!-- Floating Action: Back Button -->
            <div class="absolute top-4 left-4 z-50">
                <a href="{{ route('home') }}"
                    class="w-10 h-10 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-full shadow border border-gray-200 dark:border-gray-700 flex items-center justify-center text-gray-700 dark:text-gray-300 hover:scale-110 transition-transform"
                    title="Kembali ke Halaman Utama">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
            </div>
        @endif

        <!-- Floating Actions: Dark Mode & Translate -->
        <div class="absolute top-4 right-4 flex items-center space-x-2 z-50">
            <!-- Language Dropdown using Google Translate (Must not be display:none) -->
            <div id="google_translate_element" class="w-0 h-0 overflow-hidden opacity-0 pointer-events-none absolute"></div>
            <button id="lang-toggle-btn"
                class="w-10 h-10 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-full shadow border border-gray-200 dark:border-gray-700 flex items-center justify-center text-gray-700 dark:text-gray-300 hover:scale-110 transition-transform font-bold text-xs"
                title="Translate (EN/ID)">
                EN
            </button>

            <!-- Dark Mode Toggle -->
            <button id="dark-toggle-btn"
                class="w-10 h-10 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-full shadow border border-gray-200 dark:border-gray-700 flex items-center justify-center text-gray-700 dark:text-gray-300 hover:scale-110 transition-transform"
                title="Toggle Dark/Light Mode">
                <i class="fas fa-moon text-lg" id="dark-icon"></i>
            </button>
        </div>

        <!-- Header / Profile Section -->
        <div class="flex flex-col items-center text-center mb-6 pt-8 animate-fade-in-up animate-delay-1">
            <div
                class="w-32 h-32 md:w-36 md:h-36 bg-white rounded-full flex items-center justify-center p-1.5 mb-5 shadow-lg border-[3px] border-blue-500 overflow-hidden">
                <img id="profile-logo" src="{{ asset('logo.png') }}?v={{ time() }}" alt="Logo SMK"
                    class="w-full h-full object-cover rounded-full"
                    onerror="this.onerror=null; this.outerHTML='<svg class=\'w-20 h-20 text-blue-600\' fill=\'currentColor\' viewBox=\'0 0 24 24\'><path d=\'M12 2L1 12h3v9h6v-6h4v6h6v-9h3L12 2z\'/></svg>';">
            </div>
            <!-- Drop shadow to ensure readability over any background -->
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white drop-shadow-[0_2px_2px_rgba(255,255,255,0.8)] dark:drop-shadow-[0_2px_2px_rgba(0,0,0,0.8)] mb-1"
                style="text-shadow: 0 0 10px rgba(255,255,255,0.8); font-family: {!! $settings['font'] ?? 'inherit' !!};">
                {{ $settings['title'] ?? 'SMK Budi Utomo Way Jepara' }}
            </h1>
            
            @if(isset($parent))
                <div class="mt-2 text-center animate-fade-in-up animate-delay-1">
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-blue-100 dark:bg-blue-900 border border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-200 shadow-sm">
                        @if($parent->icon)
                            @if(strpos($parent->icon, 'uploads/') !== false)
                                <img src="{{ asset($parent->icon) }}" class="w-4 h-4 rounded-full mr-2 inline-block object-cover">
                            @else
                                <i class="{{ $parent->icon }} mr-2"></i>
                            @endif
                        @else
                            <i class="fas fa-folder-open mr-2"></i>
                        @endif
                        {{ $parent->title }}
                    </span>
                    @if($parent->description)
                        <p class="text-xs text-gray-650 dark:text-gray-300 mt-2 max-w-xs mx-auto drop-shadow-sm">{{ $parent->description }}</p>
                    @endif
                </div>
            @else
                @if(!empty($settings['bio']))
                    <p
                        class="text-sm font-medium text-gray-800 dark:text-gray-200 bg-white/60 dark:bg-black/50 px-4 py-1.5 rounded-full inline-block backdrop-blur-md shadow-sm mt-1">
                        {{ $settings['bio'] }}
                    </p>
                @endif
            @endif
        </div>

        @if(!isset($parent))
            <!-- Highlight Gallery (3 Photos) -->
            <div class="grid grid-cols-3 gap-3 mb-8 animate-fade-in-up animate-delay-2">
                @for($i = 1; $i <= 3; $i++)
                    <div
                        class="aspect-square rounded-xl overflow-hidden shadow-md bg-white/50 backdrop-blur-sm border border-white/50 hover:scale-[1.03] transition-transform duration-300">
                        @if(file_exists(public_path('gallery' . $i . '.jpg')))
                            <img src="{{ asset('gallery' . $i . '.jpg') }}?v={{ time() }}" alt="Gallery {{ $i }}"
                                class="w-full h-full object-cover cursor-pointer" onclick="window.open(this.src, '_blank')">
                        @else
                            <!-- Placeholder if no photo uploaded -->
                            <div
                                class="w-full h-full flex flex-col items-center justify-center text-gray-400 bg-gray-100/50 dark:bg-gray-800/80">
                                <i class="fas fa-camera text-xl opacity-50 mb-1"></i>
                                <span class="text-[10px] font-semibold opacity-50">Lomba {{ $i }}</span>
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        @endif

        <!-- Links List -->
        <div class="flex flex-col space-y-4">
            @forelse($links as $index => $link)
                <a href="{{ $link->is_subpage ? route('subpage', $link->id) : $link->url }}" 
                    @if(!$link->is_subpage) target="_blank" rel="noopener noreferrer" @endif
                    class="animate-fade-in-up group relative flex items-center w-full p-4 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md rounded-full shadow-[0_4px_15px_rgba(0,0,0,0.05)] hover:shadow-xl hover:scale-[1.02] hover:-translate-y-1 border border-white/50 dark:border-gray-700 hover:border-blue-300 transition-all duration-300"
                    style="animation-delay: {{ 0.2 + ($index * 0.05) }}s;">

                    <!-- Icon -->
                    <div
                        class="absolute left-1.5 w-12 h-12 flex items-center justify-center bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 rounded-full overflow-hidden group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        @if($link->icon)
                            @if(strpos($link->icon, 'uploads/') !== false)
                                <img src="{{ asset($link->icon) }}" class="w-full h-full object-cover">
                            @else
                                <i class="{{ $link->icon }} text-xl"></i>
                            @endif
                        @else
                            @if($link->is_subpage)
                                <i class="fas fa-folder text-xl"></i>
                            @else
                                <i class="fas fa-link text-xl"></i>
                            @endif
                        @endif
                    </div>

                    <!-- Title -->
                    <div class="flex-grow text-center px-14">
                        <h3
                            class="text-[17px] font-semibold text-gray-800 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300 font-sans">
                            {{ $link->title }}
                        </h3>
                        @if($link->description)
                            <p class="text-xs text-gray-500 mt-0.5 max-w-xs mx-auto truncate font-sans">{{ $link->description }}</p>
                        @endif
                    </div>

                    <!-- Chevron right for subpages, external icon for links -->
                    <div class="absolute right-4 text-gray-300 group-hover:text-blue-300">
                        @if($link->is_subpage)
                            <i class="fas fa-chevron-right text-xs"></i>
                        @else
                            <i class="fas fa-external-link-alt text-xs opacity-70"></i>
                        @endif
                    </div>
                </a>
            @empty
                <div class="text-center py-8 text-gray-500 dark:text-gray-400 bg-white/40 dark:bg-black/20 backdrop-blur-md rounded-2xl border border-white/25 dark:border-gray-800 p-4">
                    <p class="font-medium">Belum ada tautan di dalam kategori ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Footer Branding -->
        <div class="mt-12 mb-6 text-center text-sm text-gray-400 font-medium">
            <p>Sharing Page BUDUTWJ</p>
        </div>
    </div>

    <!-- Optional Theme Song Player -->
    @if(file_exists(public_path('theme.mp3')))
        <audio id="theme-song" loop autoplay preload="auto">
            <source src="{{ asset('theme.mp3') }}?v={{ time() }}" type="audio/mpeg">
        </audio>

        <!-- Floating Music Control -->
        <button id="music-toggle"
            class="fixed bottom-6 right-6 w-12 h-12 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md rounded-full shadow-lg border border-gray-200 dark:border-gray-700 flex items-center justify-center text-blue-600 dark:text-blue-400 z-50 hover:scale-110 transition-transform">
            <i class="fas fa-music text-xl animate-pulse" id="music-icon"></i>
        </button>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(file_exists(public_path('theme.mp3')))
                const audio = document.getElementById('theme-song');
                const btn = document.getElementById('music-toggle');
                const icon = document.getElementById('music-icon');
                let isPlaying = false;

                // Toggle music via button
                btn.addEventListener('click', function (e) {
                    e.stopPropagation(); // prevent document click trigger
                    if (isPlaying) {
                        audio.pause();
                    } else {
                        audio.play();
                    }
                });

                // Update icon based on state
                audio.addEventListener('play', () => {
                    isPlaying = true;
                    icon.classList.remove('fa-play');
                    icon.classList.add('fa-music', 'animate-pulse');
                    icon.style.color = '#2563eb';
                });

                audio.addEventListener('pause', () => {
                    isPlaying = false;
                    icon.classList.remove('fa-music', 'animate-pulse');
                    icon.classList.add('fa-play');
                    icon.style.color = '#9ca3af';
                });

                // Audio Autoplay Policy workaround: 
                // Aggressive fallback interaction listeners
                const startAudio = function () {
                    if (!isPlaying) {
                        audio.play().then(() => {
                            // If successful, remove all these event listeners
                            ['click', 'scroll', 'touchstart', 'mousemove', 'keydown'].forEach(evt => {
                                document.removeEventListener(evt, startAudio);
                            });
                        }).catch(e => console.log('Waiting for active interaction...'));
                    }
                };

                const playPromise = audio.play();
                if (playPromise !== undefined) {
                    playPromise.catch(error => {
                        console.log("Autoplay blocked by browser. Using aggressive event fallback.");
                        // Attempt to play on ANY small action
                        ['click', 'scroll', 'touchstart', 'mousemove', 'keydown'].forEach(evt => {
                            document.addEventListener(evt, startAudio, { once: false, passive: true });
                        });
                    });
                }
            @endif

                                                        // DARK MODE TOGGLE LOGIC
                                                        const darkToggleBtn = document.getElementById('dark-toggle-btn');
            const darkIcon = document.getElementById('dark-icon');

            // Check initial state
            if (document.documentElement.classList.contains('dark')) {
                darkIcon.classList.replace('fa-moon', 'fa-sun');
            }

            darkToggleBtn.addEventListener('click', function () {
                document.documentElement.classList.toggle('dark');
                if (document.documentElement.classList.contains('dark')) {
                    localStorage.setItem('theme', 'dark');
                    darkIcon.classList.replace('fa-moon', 'fa-sun');
                } else {
                    localStorage.setItem('theme', 'light');
                    darkIcon.classList.replace('fa-sun', 'fa-moon');
                }
            });

            // LANGUAGE TOGGLE LOGIC (ID -> EN -> ID)
            const langToggleBtn = document.getElementById('lang-toggle-btn');
            let isEnglish = false;

            langToggleBtn.addEventListener('click', function () {
                var selectField = document.querySelector(".goog-te-combo");
                if (selectField) {
                    isEnglish = !isEnglish;
                    selectField.value = isEnglish ? 'en' : 'id';
                    selectField.dispatchEvent(new Event("change"));
                    langToggleBtn.textContent = isEnglish ? 'ID' : 'EN';
                } else {
                    alert('Google Translate is still loading, please wait a second...');
                }
            });
        });

        // Initialize Google Translate
        function googleTranslateElementInit() {
            new google.translate.TranslateElement(
                { pageLanguage: 'id', includedLanguages: 'en,id', layout: google.translate.TranslateElement.InlineLayout.SIMPLE },
                'google_translate_element'
            );
        }
    </script>
    <script type="text/javascript"
        src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
@endsection