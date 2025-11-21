require('./bootstrap');

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('registerModal');
    const signupButton = document.querySelector('.signup-btn');

    if (modal && signupButton) {
        signupButton.addEventListener('click', (event) => {
            event.preventDefault();
            modal.classList.add('active');
        });

        modal.addEventListener('click', (event) => {
            if (event.target === modal || event.target.classList.contains('close')) {
                modal.classList.remove('active');
            }
        });
    }
});

// Make sure modal close button works after error messages
document.addEventListener('DOMContentLoaded', function () {
    const closeBtn = document.querySelector('#registerModal .close');
    const modal = document.getElementById('registerModal');

    if (closeBtn && modal) {
        closeBtn.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    }

    
});

document.addEventListener('DOMContentLoaded', () => {
    // Select the table
    const table = document.querySelector('.my-table'); 
    
    // Check if the table exists before proceeding
    if (!table) return; 

    // Add a click listener to the entire table
    table.addEventListener('click', (event) => {
        // Find the closest table row (tr) ancestor of the clicked element
        const row = event.target.closest('tr');
        
        // Ensure we clicked within a row and not the header
        if (row && row.parentElement.tagName === 'TBODY') {
            
            // 1. Deselect any previously selected rows in this table
            table.querySelectorAll('tr.is-selected').forEach(selectedRow => {
                selectedRow.classList.remove('is-selected');
            });

            // 2. Select the clicked row
            row.classList.add('is-selected');
            
            // OPTIONAL: Do something else here (e.g., store the ID of the selected item)
            // console.log('Selected row ID:', row.dataset.itemId);
        }
    });
});

// DATE
document.addEventListener('DOMContentLoaded', (event) => {
    // 1. Get the current date object
    const today = new Date();

    // 2. Format the date to YYYY-MM-DD string
    // Pad the month and day with a leading zero if they are single digits (e.g., 5 becomes 05)
    
    // Get year
    const year = today.getFullYear();
    
    // Get month (0-indexed, so add 1) and pad it
    const month = String(today.getMonth() + 1).padStart(2, '0'); 
    
    // Get day and pad it
    const day = String(today.getDate()).padStart(2, '0');
    
    // Combine them into the required format
    const formattedDate = `${year}-${month}-${day}`;

    // 3. Find the date input element
    const dateInput = document.getElementById('todayDate');
    
    // 4. Set the value
    if (dateInput) {
        dateInput.value = formattedDate;
    }
});