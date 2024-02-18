function initializeFeedback(){
    starsClick('#feedback-one');
    starsClick('#feedback-two');
    starsClick('#feedback-three-a');
    starsClick('#feedback-three-b');
    starsClick('#feedback-three-c');
    starsClick('#feedback-four-a');
    starsClick('#feedback-four-b');
    starsClick('#feedback-four-c');
    starsClick('#feedback-five');
}


$(document).ready(function () {
    initializeFeedback();
    /* $('#feedback-one .rating .star').click(function () {
        let idx = $(this).index();
        let click = 0;
        let ratingValue = idx;

        $(this).siblings().addBack().removeClass('highlight active').addClass('no-highlight');

        $(this).prevAll().addBack().addClass('highlight active').removeClass('no-highlight');
        $(this).nextAll().each(function () {
            $(this).css('--i', click);
            click++;
        });

        $('input[name="rating"]').val(ratingValue);

        console.log(ratingValue);
    }); */

    $("#myTable").DataTable({
        searching: false,
        language: {
            info: "Showing _START_ - _END_ of list",
        },
        scrollCollapse: true,
        scrollY: "400px",
        order: [],
        language: {
            paginate: {
                previous: "<",
                next: ">",
            },
        },
    });

    $("#history-modal-table").DataTable({
        searching: false,
        scrollCollapse: true,
        scrollY: "442px",
        paging: false,
        bInfo: false,
        sorting: false,
        bAutoWidth: false,
        columns: [{ width: "150px" }, { width: "190px" }, null],
    });
});

function starsClick(parentId) {
    let stars = $(parentId + ' .rating .star');

    stars.on('click', function () {
        let idx = $(this).index() + 1; // Add 1 to make it 1-based
        let click = 0;
        let ratingValue = idx;

        stars.removeClass('highlight active').addClass('no-highlight');
        $(this).prevAll().addBack().addClass('highlight active').removeClass('no-highlight');
    
        stars.nextAll().each(function () {
            $(this).css('--i', click);
            click++;
        });

        $(parentId + ' input[name="rating[]"]').val(ratingValue);

        console.log(parentId + ": " + ratingValue);
    });
}

function handleSubscribeForm(id) {
    $(document).on("submit", "#subscribe-form" + id, function (event) {
        $.ajax({
            type: "POST",
            url: "../../modules/faculty/subscribe_event.php",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (response) {
                if (!(response == "Done!")) {
                    console.log("Something went wrong!");
                }
            },
        });

        event.preventDefault();
    });
}