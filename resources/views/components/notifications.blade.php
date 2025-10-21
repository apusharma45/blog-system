@auth
<div class="fixed top-4 right-4 z-50 space-y-2" id="notifications-container">
    <!-- Notifications will be dynamically added here -->
</div>

<script>
class NotificationManager {
    constructor() {
        this.container = document.getElementById('notifications-container');
        this.notifications = [];
        this.maxNotifications = 5;
    }

    show(message, type = 'info', duration = 5000) {
        const notification = this.createNotification(message, type);
        this.container.appendChild(notification);
        this.notifications.push(notification);

        // Remove oldest notification if we exceed max
        if (this.notifications.length > this.maxNotifications) {
            const oldest = this.notifications.shift();
            oldest.remove();
        }

        // Auto remove after duration
        setTimeout(() => {
            this.remove(notification);
        }, duration);

        // Animate in
        setTimeout(() => {
            notification.classList.add('translate-x-0', 'opacity-100');
        }, 10);
    }

    createNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `transform translate-x-full opacity-0 transition-all duration-300 ease-in-out max-w-sm w-full bg-white/90 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 dark:bg-gray-800/90 dark:border-gray-700/50 p-4`;

        const colors = {
            success: {
                bg: 'bg-green-50 dark:bg-green-900/20',
                border: 'border-green-200 dark:border-green-800',
                icon: 'text-green-600 dark:text-green-400',
                iconBg: 'bg-green-100 dark:bg-green-900/30'
            },
            error: {
                bg: 'bg-red-50 dark:bg-red-900/20',
                border: 'border-red-200 dark:border-red-800',
                icon: 'text-red-600 dark:text-red-400',
                iconBg: 'bg-red-100 dark:bg-red-900/30'
            },
            warning: {
                bg: 'bg-yellow-50 dark:bg-yellow-900/20',
                border: 'border-yellow-200 dark:border-yellow-800',
                icon: 'text-yellow-600 dark:text-yellow-400',
                iconBg: 'bg-yellow-100 dark:bg-yellow-900/30'
            },
            info: {
                bg: 'bg-blue-50 dark:bg-blue-900/20',
                border: 'border-blue-200 dark:border-blue-800',
                icon: 'text-blue-600 dark:text-blue-400',
                iconBg: 'bg-blue-100 dark:bg-blue-900/30'
            }
        };

        const color = colors[type] || colors.info;
        const icon = this.getIcon(type);

        notification.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 ${color.iconBg} rounded-lg flex items-center justify-center">
                        ${icon}
                    </div>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">${message}</p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button onclick="notificationManager.remove(this.closest('.notification'))" class="inline-flex text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        `;

        notification.classList.add('notification');
        return notification;
    }

    getIcon(type) {
        const icons = {
            success: `<svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>`,
            error: `<svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>`,
            warning: `<svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>`,
            info: `<svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>`
        };

        return icons[type] || icons.info;
    }

    remove(notification) {
        if (!notification) return;
        
        notification.classList.add('translate-x-full', 'opacity-0');
        
        setTimeout(() => {
            const index = this.notifications.indexOf(notification);
            if (index > -1) {
                this.notifications.splice(index, 1);
            }
            notification.remove();
        }, 300);
    }

    success(message, duration) {
        this.show(message, 'success', duration);
    }

    error(message, duration) {
        this.show(message, 'error', duration);
    }

    warning(message, duration) {
        this.show(message, 'warning', duration);
    }

    info(message, duration) {
        this.show(message, 'info', duration);
    }
}

// Global notification manager
window.notificationManager = new NotificationManager();

// Listen for Laravel flash messages
document.addEventListener('DOMContentLoaded', function() {
    // Check for flash messages in session
    @if(session('status'))
        notificationManager.success('{{ session('status') }}');
    @endif

    @if(session('error'))
        notificationManager.error('{{ session('error') }}');
    @endif

    @if(session('warning'))
        notificationManager.warning('{{ session('warning') }}');
    @endif

    @if(session('info'))
        notificationManager.info('{{ session('info') }}');
    @endif

    // Listen for custom notification events
    document.addEventListener('show-notification', function(event) {
        const { message, type, duration } = event.detail;
        notificationManager.show(message, type, duration);
    });
});

// Helper functions for easy notification display
window.showNotification = function(message, type = 'info', duration = 5000) {
    notificationManager.show(message, type, duration);
};

window.showSuccess = function(message, duration = 5000) {
    notificationManager.success(message, duration);
};

window.showError = function(message, duration = 5000) {
    notificationManager.error(message, duration);
};

window.showWarning = function(message, duration = 5000) {
    notificationManager.warning(message, duration);
};

window.showInfo = function(message, duration = 5000) {
    notificationManager.info(message, duration);
};
</script>
@endauth
