$(document).ready(function () {
    $('#myTable').DataTable({
        searching: false,
        language: {
            info: 'Showing _START_ - _END_ of list'
        },
        scrollCollapse: true,
        scrollY: '400px',
        "language": {
            "paginate": {
                "previous": "<",
                "next": ">"
            }
        }
    });
});