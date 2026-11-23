/**
 * =============================================================================
 * Employee Record Tracking System - Client-Side JavaScript (script.js)
 * Course: Web Systems Technologies
 * =============================================================================
 */

document.addEventListener('DOMContentLoaded', function () {

    // -------------------------------------------------------------------------
    // 1. Instant Real-Time Client-Side Table Search
    // Filters table rows in real-time as the user types
    // -------------------------------------------------------------------------
    const searchInput = document.getElementById('searchInput');
    const employeeTable = document.getElementById('employeeTable');

    if (searchInput && employeeTable) {
        const tableRows = employeeTable.querySelectorAll('tbody tr:not(.empty-row)');
        const emptyMessageRow = document.getElementById('noMatchRow');

        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();
            let visibleCount = 0;

            tableRows.forEach(row => {
                const text = row.innerText.toLowerCase();
                if (text.includes(query)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Show or hide the "No matching records found" helper row
            if (emptyMessageRow) {
                if (visibleCount === 0 && query !== '') {
                    emptyMessageRow.classList.remove('d-none');
                } else {
                    emptyMessageRow.classList.add('d-none');
                }
            }
        });
    }

    // -------------------------------------------------------------------------
    // 2. Dynamic Annual Salary Calculator (on Add & Edit forms)
    // Computes and updates annual salary preview as monthly salary is typed
    // -------------------------------------------------------------------------
    const salaryInput = document.getElementById('salaryInput');
    const salaryPreview = document.getElementById('salaryPreview');

    if (salaryInput && salaryPreview) {
        function updateAnnualPreview() {
            const val = parseFloat(salaryInput.value);
            if (!isNaN(val) && val > 0) {
                const annual = val * 12;
                const formatted = new Intl.NumberFormat('en-PH', {
                    style: 'currency',
                    currency: 'PHP'
                }).format(annual);
                salaryPreview.innerHTML = `<strong>Estimated Annual Compensation:</strong> ${formatted}`;
                salaryPreview.classList.remove('d-none');
            } else {
                salaryPreview.classList.add('d-none');
            }
        }

        // Run once on load (useful for Edit form) and on every keystroke
        updateAnnualPreview();
        salaryInput.addEventListener('input', updateAnnualPreview);
    }

    // -------------------------------------------------------------------------
    // 3. Auto-Dismiss Notification Alerts after 5 seconds
    // -------------------------------------------------------------------------
    const autoAlerts = document.querySelectorAll('.alert-dismissible');
    if (autoAlerts.length > 0) {
        setTimeout(function () {
            autoAlerts.forEach(function (alertEl) {
                const alertInstance = bootstrap.Alert.getOrCreateInstance(alertEl);
                if (alertInstance) {
                    alertInstance.close();
                }
            });
        }, 5000);
    }

    // -------------------------------------------------------------------------
    // 4. Delete Confirmation Safety Check
    // -------------------------------------------------------------------------
    const deleteButtons = document.querySelectorAll('.btn-delete-confirm');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            const name = this.getAttribute('data-name') || 'this record';
            if (!confirm(`Are you sure you want to permanently delete ${name}?`)) {
                e.preventDefault();
            }
        });
    });

});
