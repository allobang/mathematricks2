// Initiate datatables in roles, tables, users page
(function() {
    'use strict';
    
    $('#dataTables-example').DataTable({
        responsive: true,
        pageLength: 20,
        lengthChange: false,
        searching: true,
        ordering: true,
        order: [[0, 'desc']] // Assuming the first column reflects the latest entries. Adjust the index as necessary.
    });
})();
