$(document).ready(function () {
    const daysTag = document.querySelector(".days");
    const currentDate = document.querySelector(".current-date");
    const prevNextIcon = document.querySelectorAll(".icons span");

    // getting new date, current year and month
    let date = new Date();
    let currYear = date.getFullYear();
    let currMonth = date.getMonth();
    let dayDate = "";

    // storing full name of all months in array
    const months = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
    ];

    const renderCalendar = () => {
        var eventsArray = [];
        $.ajax({
            url: `../../modules/events/check_for_events.php`,
            method: "GET",
            dataType: "json",
            success: function (response) {
                eventsArray = response;

                $.each(eventsArray, function (index, event) {
                    $(".calendar .days")
                        .find("." + event.day)
                        .addClass("hasEvent");
                });
            },
        });

        let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(); // getting first day of month
        let lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(); // getting last date of month
        let lastDayofMonth = new Date(
            currYear,
            currMonth,
            lastDateofMonth
        ).getDay(); // getting last day of month
        let lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // getting last date of previous month
        let liTag = "";

        let counter = 0;
        // creating li of previous month last days
        for (let i = firstDayofMonth; i > 0; i--) {
            liTag += `<li class="inactive" style="pointer-events: none;">${
                lastDateofLastMonth - i + 1
            }</li>`;
            counter++;
        }

        // creating li of all days of current month
        for (let i = 1; i <= lastDateofMonth; i++) {
            const dayDate = `${currYear}-${(currMonth + 1)
                .toString()
                .padStart(2, "0")}-${i.toString().padStart(2, "0")}`;
            let isToday =
                i === date.getDate() &&
                currMonth === date.getMonth() &&
                currYear === date.getFullYear()
                    ? "active"
                    : "";

            liTag += `<li class="${dayDate} ${isToday}" id='cal_day'><p>${i}</p></li>`;
            counter++;
        }

        for (let i = lastDayofMonth; i < 13; i++) {
            // creating li of next month first days
            if (counter < 42) {
                liTag += `<li class="inactive" style="pointer-events: none;">${
                    i - lastDayofMonth + 1
                }</li>`;
                counter++;
            } else {
                break;
            }
        }

        // passing current mon and yr as currentDate text
        currentDate.innerText = `${months[currMonth]} ${currYear}`;
        daysTag.innerHTML = liTag;

        // Add click event listeners to all li elements with the class "active"
        const activeDays = document.querySelectorAll(".calendar-div li");
        activeDays.forEach((activeDay) => {
            activeDay.addEventListener("click", function () {
                // Remove the 'active' class from all active days
                activeDays.forEach((day) => day.classList.remove("active"));

                // Add the 'active' class to the clicked day
                this.classList.add("active");

                const clickedDate = this.classList[0];
                if (clickedDate) {
                    // Get the current URL
                    const currentURL = window.location.href;

                    const hasDateQueryParam = currentURL.includes("?date=");

                    // Construct the new URL
                    let newURL;
                    if (hasDateQueryParam) {
                        // Update the existing date query parameter
                        newURL = currentURL.replace(
                            /(\?|&)date=[^&]*/,
                            `?date=${clickedDate}`
                        );
                    } else {
                        // Append the date as a new query parameter
                        newURL = `${currentURL}${
                            hasDateQueryParam ? "&" : "?"
                        }date=${clickedDate}`;
                    }

                    // Update the current URL without navigating to a new page
                    window.history.pushState(
                        {
                            path: newURL,
                        },
                        "",
                        newURL
                    );

                    $("#today-wrap").load(
                        location.href +
                            " .today-event-content.h-100.w-100.d-flex.flex-column"
                    );
                }
            });
        });
    };

    renderCalendar();

    // getting prev and next icons
    prevNextIcon.forEach((icon) => {
        // adding click event on both icons
        icon.addEventListener("click", () => {
            // if clicked icon is previous icon then decrement current month by 1 else increment it by 1
            currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

            // if current month is less than 0 or greater than 11
            if (currMonth < 0 || currMonth > 11) {
                // creating a new date of current year & month and pass it as date value
                date = new Date(currYear, currMonth, new Date().getDate());
                currYear = date.getFullYear(); // updating current year with new date year
                currMonth = date.getMonth(); // updating current month with new date month
            } else {
                date = new Date(); // pass the current date as date value
            }

            renderCalendar(); // calling renderCalendar function
        });
    });
});
