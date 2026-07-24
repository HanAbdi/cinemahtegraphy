<div>
    <h2 class="text-3xl font-heading font-bold text-white mb-8 tracking-tight">Kalender Jadwal Proyek</h2>

    <!-- FullCalendar CDN -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

    <div class="bg-[#111827]/80 backdrop-blur-xl rounded-2xl border border-gray-800 p-6 shadow-[0_8px_30px_rgb(0,0,0,0.4)]">
        
        <!-- The Calendar Container -->
        <div id='calendar' class="text-gray-300"></div>

    </div>

    <!-- Event Detail Modal (AlpineJS) -->
    <div x-data="{ open: false, event: {} }" 
         @open-event-modal.window="open = true; event = $event.detail;" 
         x-show="open" 
         style="display: none;" 
         class="fixed inset-0 z-50 flex items-center justify-center">
        
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" @click="open = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"></div>
        
        <!-- Modal -->
        <div class="bg-[#111827] border border-gray-700 rounded-2xl shadow-2xl z-10 w-full max-w-md overflow-hidden transform"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            
            <div class="p-6 border-b border-gray-800 bg-[#1f2937]/50 flex justify-between items-start">
                <h3 class="text-xl font-bold text-white" x-text="event.title"></h3>
                <button @click="open = false" class="text-gray-400 hover:text-white"><i class="fas fa-times"></i></button>
            </div>
            
            <div class="p-6 space-y-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-amber-500/10 flex items-center justify-center text-amber-500 mr-4">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 uppercase font-bold tracking-wider">Tanggal Event</div>
                        <div class="text-gray-200 font-medium" x-text="event.startStr"></div>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500 mr-4">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 uppercase font-bold tracking-wider">Status Proyek</div>
                        <div class="text-gray-200 font-medium" x-text="event.extendedProps?.status"></div>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-green-500/10 flex items-center justify-center text-green-500 mr-4">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 uppercase font-bold tracking-wider">DP Klien</div>
                        <div class="text-gray-200 font-medium font-mono">Rp <span x-text="event.extendedProps?.dp ? parseFloat(event.extendedProps.dp).toLocaleString('id-ID') : '0'"></span></div>
                    </div>
                </div>
            </div>
            
            <div class="p-6 border-t border-gray-800 flex justify-end bg-[#1f2937]/30">
                <a href="{{ route('admin.projects.kanban') }}" class="px-5 py-2.5 rounded-lg text-sm font-bold text-black bg-amber-500 hover:bg-amber-600 shadow-[0_0_15px_rgba(245,158,11,0.3)] transition-all flex items-center">
                    Kelola di Kanban <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Initialization Script -->
    <script>
        document.addEventListener('livewire:initialized', function () {
            var calendarEl = document.getElementById('calendar');
            var rawEvents = {!! $this->events !!};

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                themeSystem: 'standard',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    day: 'Hari'
                },
                events: rawEvents,
                eventClick: function(info) {
                    // Dispatch event to AlpineJS
                    window.dispatchEvent(new CustomEvent('open-event-modal', {
                        detail: {
                            title: info.event.title,
                            startStr: info.event.startStr,
                            extendedProps: info.event.extendedProps
                        }
                    }));
                },
                eventContent: function(arg) {
                    return {
                        html: `<div class="px-2 py-1 overflow-hidden truncate whitespace-nowrap w-full">
                                   <div class="font-semibold text-xs truncate">${arg.event.title}</div>
                               </div>`
                    };
                }
            });

            calendar.render();
        });
    </script>

    <!-- Custom Overrides for FullCalendar Dark Theme -->
    <style>
        .fc {
            --fc-page-bg-color: transparent;
            --fc-neutral-bg-color: #1f2937;
            --fc-neutral-text-color: #d1d5db;
            --fc-border-color: #374151;
            
            --fc-button-text-color: #fff;
            --fc-button-bg-color: #1f2937;
            --fc-button-border-color: #374151;
            --fc-button-hover-bg-color: #374151;
            --fc-button-hover-border-color: #4b5563;
            --fc-button-active-bg-color: #f59e0b;
            --fc-button-active-border-color: #f59e0b;
            --fc-button-active-text-color: #000;
        }
        .fc .fc-col-header-cell-cushion {
            color: #9ca3af;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            padding: 12px 0;
        }
        .fc .fc-daygrid-day-number {
            color: #d1d5db;
            font-weight: 500;
        }
        .fc-day-today {
            background-color: rgba(245, 158, 11, 0.05) !important;
        }
        .fc-day-today .fc-daygrid-day-number {
            color: #f59e0b;
            font-weight: 800;
        }
    </style>
</div>
