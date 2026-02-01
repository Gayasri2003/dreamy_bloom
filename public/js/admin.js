// Admin Dashboard JavaScript

// Initialize admin app
document.addEventListener('DOMContentLoaded', function() {
    initAdminAuth();
    loadDashboardData();
});

// Admin Auth
function initAdminAuth() {
    const token = localStorage.getItem('admin_token');
    if (!token && !window.location.pathname.includes('/admin/login')) {
        window.location.href = '/admin/login';
    }
}

// Load Dashboard Data
async function loadDashboardData() {
    // Load stats, charts, recent orders, etc.
    console.log('Loading dashboard data...');
}

// Table Functions
function editItem(id) {
    console.log('Edit item:', id);
}

function deleteItem(id) {
    if (confirm('Are you sure you want to delete this item?')) {
        console.log('Delete item:', id);
    }
}

function viewItem(id) {
    console.log('View item:', id);
}

// Modal Functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
    }
}

// Notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#4CAF50' : type === 'error' ? '#f44336' : '#2196F3'};
        color: white;
        padding: 15px 25px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        z-index: 10000;
        animation: slideIn 0.3s;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Export functionality
function exportData(format) {
    console.log('Exporting data as:', format);
    showNotification(`Exporting as ${format}...`, 'info');
}

// Sidebar toggle for mobile
function toggleSidebar() {
    const sidebar = document.querySelector('.admin-sidebar');
    sidebar.classList.toggle('active');
}
