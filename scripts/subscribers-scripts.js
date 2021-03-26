$(document).ready(function () {
    $(".provider-button").click(function () {           //change providers button style and get data based on selected buttons 
        $("#main-checkbox").prop('checked', false);
        if ($(this).hasClass("btn-info")) {
            $(this).removeClass("btn-info");
        } else {
            $(this).addClass("btn-info");
        }
        getProvidersAndInput();
    });
});

$(document).ready(function () {
    $(".data-header").click(function () {           //sorting data depending on what table header was clicked
        var element = $(this);

        removeUnicodeIfContains("th");

        if (element.hasClass("asc")) {                          
            $("th").not(":first-child").removeClass();          
            element.addClass("desc");
            element.removeClass("asc");
            getProvidersAndInput(element.text(), "desc");
            var text = element.text();
            element.text(text + " \u21e7");
        }
        else {
            $("th").not(":first-child").removeClass();
            element.addClass("asc");
            element.removeClass("desc");
            getProvidersAndInput(element.text(), "asc");
            var text = element.text();
            element.text(text + " \u21e9");
        }
    });

    $(".data-header").hover(function () {
        $(this).css("cursor", "pointer");
    });
});

function removeUnicodeIfContains(elementTag){       //function removes unicode after last space
    var elements = $(elementTag).not(":first-child");   
    for (let index = 0; index < elements.length; index++) {
        var element = elements[index];
        var text = element.innerHTML;
        if (text.trim().includes(" "))
        {
            text = text.substring(0, text.lastIndexOf(" "));
            element.innerHTML = text;
        }
    }
}

$(document).ready(function () {             //seacrh bar changes 
    $("#search-bar").keyup(function () {
        $("#main-checkbox").prop('checked', false);
        getProvidersAndInput();
    })
});

$(document).ready(function () {                     //changing checkboxes value
    $("#main-checkbox").change(function () {
        if ($(this).is(":checked")) {
            $('.checkBoxClass').prop('checked', true);
        }
        else {
            $('.checkBoxClass').prop('checked', false);
        }
    });
});

$(document).ready(function () {
    $("body").on("click", "input.checkBoxClass", function () {
        $("#main-checkbox").prop("checked", false);
    });
});

$(document).ready(function () {             //save file button click
    $("#import-button").click(function () {

        var tableContent = "id, emails, subscription_date\n";
        var tableData = "";

        $("table > tbody > tr").each(function () {
            var $tr = $(this);
            if ($tr.find(".checkBoxClass").is(":checked")) {
                var $td = $tr.find("td");
                tableData += $td.eq(1).text() + ", " + $td.eq(2).text() + ", " + $td.eq(3).text() + "\n";
            }
        });

        if (tableData === "") {
            alert("Select data to import!");
        }
        else {
            tableContent += tableData;
            var filename = "report_" + Date.now() + ".csv";
            download(filename, tableContent);
        }
    })
});

function download(filename, text) {

    var element = document.createElement('a');
    element.style.display = "none";
    element.setAttribute("href", "data:text/plain;charset=utf-8," + encodeURIComponent(text));
    element.setAttribute("download", filename);
    document.body.appendChild(element);
    element.click();
    document.body.removeChild(element);

}

function getProvidersAndInput() {
    var activeButtons = document.getElementsByClassName("btn-info");
    var activeProviders = [];
    for (let index = 0; index < activeButtons.length; index++) {
        activeProviders.push(activeButtons[index].innerHTML);
    }

    var emailInput = $("input").val();

    var className = "desc";
    var elements = document.getElementsByClassName(className);
    if (elements.length === 0) {
        className = "asc";
        elements = document.getElementsByClassName(className);
    }
        
        var text = elements[0].innerHTML.trim();
        if (text.includes(" ")) text = text.substring(0, text.lastIndexOf(" "));
        getEmailsBySelectedProvidersAndInputEmail(activeProviders, emailInput, text, className);
}

function getEmailsBySelectedProvidersAndInputEmail(activeProviders, emailInput, orderby = "subscription_date", order = "desc") {
    url = window.location.href;
    url = url.substring(0, url.lastIndexOf("/"));
    url = url + "/backend/api/sort.php";

    dataValue = {
        "provider": activeProviders,
        "email": emailInput,
        "orderby": orderby,
        "order": order
    };
    $.ajax({
        type: "GET",
        url: url,
        contentType: "application/json",
        dataType: "json",
        data: dataValue,
        success(result) {
            redrawTable(result.subscribers);
        },
        error(error) {
            console.log(error);
        }
    });
}

function deleteSubscriber(id) {
    var select = confirm("Are you sure you want to delete?");
    if (select) {
        url = window.location.href;
        url = url.substring(0, url.lastIndexOf("/"));
        url = url + "/backend/api/delete.php?id=" + id;

        $.ajax({
            type: "GET",
            url: url,
            contentType: "application/json",
            dataType: "json",
            success(result) {
                $("#subscriber-row-" + id).remove();
            },
            error(error) {
                console.log(error);
            }
        });
    }
}

function redrawTable(subscribers) {
    console.log(subscribers);
    $("#table").children().not(":first-child").remove();

    $("#table").append("<tbody>");
    for (var i = 0; i < subscribers.length; i++) {
        $("#table").append("<tr id=\"subscriber-row-" + subscribers[i].id + "\">" +
            "<td><input type=\"checkbox\" class=\"checkBoxClass\"></td>" +
            "<td style=\"display:none\">" + subscribers[i].id + "</td>" +
            "<td>" + subscribers[i].email + "</td>" +
            "<td>" + parseDate(subscribers[i].subscription_date) + "</td>" +
            "<td><button class=\"btn btn-danger\" onclick=\"deleteSubscriber(" + subscribers[i].id + ")\">Delete</button></td>" +
            "</tr>")
    }
    $("#table").append("</tbody>");
}

function parseDate(datetime) {
    var result = "";
    var array = datetime.split("-");

    var year = array[0];
    var month = array[1];

    array = array[2].split(" ");

    var day = array[0];

    result += day + "-" + month + "-" + year + " ";

    var time = array[1].split(":");

    var hours = time[0];
    var minutes = time[1];
    var seconds = time[2];

    result += hours + ":" + minutes;

    return result;
}