// Antigravity Livewire SPA Navigation Hook
document.addEventListener('livewire:navigated', () => {
    // Clean up any open popovers/dropdowns from previous page
    document.querySelectorAll('[popover]').forEach(popover => {
        try {
            if (popover.matches(':popover-open')) {
                popover.hidePopover();
            }
        } catch (e) {}
    });

    // Ensure scroll is never locked
    document.body.style.overflow = '';
    document.documentElement.style.overflow = '';
});
