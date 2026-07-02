<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
    <!-- Chatbox Component -->
{{-- <div 
    x-data="{ open: false }" 
    class="fixed-bottom mb-4 me-4 d-flex flex-column align-items-end"
    style="z-index: 1050; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <!-- Floating Chat Toggle Button -->
    <button 
        @click="open = !open" 
        class="btn btn-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center"
        style="width: 60px; height: 60px; background: linear-gradient(135deg, #4facfe, #00f2fe); border: none;">
        <i class="bi bi-chat-dots-fill fs-3 text-white"></i>
    </button>

    <!-- Chat Window -->
    <div 
        x-show="open" 
        x-transition 
        class="card shadow-lg border-0 mt-3 rounded-4"
        style="width: 360px; height: 520px; overflow: hidden;">

        <!-- Header -->
        <div class="card-header border-0 text-white d-flex justify-content-between align-items-center"
             style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-white me-2 d-flex align-items-center justify-content-center" 
                     style="width: 35px; height: 35px;">
                    <i class="bi bi-headset text-primary"></i>
                </div>
                <div>
                    <strong>Live Support</strong>
                    <div style="font-size: 0.8rem; color: #e3e3e3;">Online</div>
                </div>
            </div>
            <button class="btn btn-sm btn-light rounded-circle" @click="open = false">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <!-- Messages -->
        <div class="card-body px-3 py-2" style="background: #f7f9fc; height: 400px; overflow-y: auto;">
            
            <!-- Incoming message -->
            <div class="d-flex mb-3">
                <div class="p-3 rounded-3 shadow-sm" style="max-width: 70%; background: #ffffff;">
                    <p class="mb-1">Hello 👋 How can we assist you today?</p>
                    <small class="text-muted" style="font-size: 0.75rem;">2 mins ago</small>
                </div>
            </div>

            <!-- Outgoing message -->
            <div class="d-flex mb-3 justify-content-end">
                <div class="p-3 rounded-3 shadow-sm text-white" 
                     style="max-width: 70%; background: linear-gradient(135deg, #667eea, #764ba2);">
                    <p class="mb-1">I want to know about my order status.</p>
                    <small class="text-light" style="font-size: 0.75rem;">Just now</small>
                </div>
            </div>

        </div>

        <!-- Input -->
        <div class="card-footer border-0 p-2" style="background: #f1f3f6;">
            <div class="input-group">
                <input type="text" class="form-control rounded-start-pill border-0 shadow-sm" placeholder="Type a message...">
                <button class="btn rounded-end-pill text-white shadow-sm" type="button"
                        style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </div>
    </div>
</div> --}}

</x-layouts.app>
