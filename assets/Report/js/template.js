$(document).ready(function () {

    // Sidebar toggle
    $('[data-toggle=sidebar]').click(function () {
        $('.left-side').toggleClass('active box-shadow');
        $(this).toggleClass('active');
    });

    // Scenario filter search
    $("#search-box").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#scenarios-list li").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Scenarios list item click
    $('.scenarios-list > .nav-item > a').on('click', function (event) {
        var scenarioTarget = $(this).data('target');
        var headerHeight = $('header').outerHeight() + 10;

        if (scenarioTarget != null) {
            // open selected collapible card
            $(scenarioTarget + ':not(".show")').collapse('show');
            // generate the element id to scroll to
            var scenarioTargetArray = scenarioTarget.split('-');
            scenarioTargetArray.splice(1, 0, "header");
            var scenarioTargetElement = scenarioTargetArray.join('-');
            // get the element
            var scenarioElement = $(scenarioTargetElement);
            if (scenarioTarget != null) {
                $('html, body').animate({
                    scrollTop: scenarioElement.offset().top - headerHeight
                }, 300, 'linear');
            }
        }
    });

    // Change items view between all passed and failed tests
    $('.type-selection button').on('click', function (event) {
        var testType = $(this).data('type'); // Extract info from data-* attributes
        var passedElements = $('#sb-main > div.card.passed');
        var failedElements = $('#sb-main > div.card.failed');
        var pendingElements = $('#sb-main > div.card.pending');

        passedElements.toggle(false);
        pendingElements.toggle(false);
        failedElements.toggle(false);
        switch (testType) {
            case 'passed':
                passedElements.toggle(true);
                break;
            case 'failed':
                failedElements.toggle(true);
                break;
            case 'pending':
                pendingElements.toggle(true);
                break;
            default:
                $('#sb-main > div.card').toggle(true);
                break;
        }
    });

    // Change grid to list scenario cards display
    $('input[type=radio][name=view-buttons]').on('change', function () {
        var mainContainer = $('#sb-main');
        var mainContainerItems = $('#sb-main > .card');
        switch ($(this).val()) {
            case 'list':
                // enable list view
                mainContainer.removeClass('flex-row');
                mainContainer.addClass('flex-column');
                mainContainerItems.removeClass('w-49');
                mainContainerItems.addClass('w-100');
                break;
            case 'grid':
                // enable grid view
                mainContainer.removeClass('flex-column');
                mainContainer.addClass('flex-row');
                // loop elements and change width only for elements that are not opened
                mainContainerItems.each(function (index) {
                    if (!$(this).children('div.collapse').hasClass('show')) {
                        $(this).removeClass('w-100');
                        $(this).addClass('w-49');
                    }
                });
                break;
        }
    });

    // Open all main scenarios cards
    $('.openall').click(function () {
        $('.multi-collapse-main:not(".show")')
            .collapse('show');
    });

    // Listen to when a main - first level collapsible opens
    $('.multi-collapse-main').on('show.bs.collapse', function (event) {
        if (event.target.className.indexOf('multi-collapse-main') > -1) {
            checkWidth(event.target.id, 1);
        }
    });

    // Close all main scenarios cards
    $('.closeall').click(function () {
        $('.collapse.show')
            .collapse('hide');
    });

    // Listen to when a main - first level collapsible closes
    $('.multi-collapse-main').on('hide.bs.collapse', function (event) {
        if (event.target.className.indexOf('multi-collapse-main') > -1) {
            checkWidth(event.target.id, 0);
        }
    });

    // Image Modal
    $('#imageModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var imgPath = button.data('imgsrc'); // Extract info from data-* attributes
        var stepContent = button.parent().parent().find('td.align-middle:last-child').html(); // Get the scenario text content
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body img').attr("src", imgPath);
        modal.find('#imageModalLabel').html(stepContent);
    });

    // Scenario Modals
    $('.scenario-modal')
        .on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let screenshotID = button.data('slide-id');
            $(screenshotID).addClass('active');
        })
        .on('hidden.bs.modal', function (event) {
            $(this).find('.carousel-item').removeClass('active');
        });

    // set main card width to 100% when opened
    function checkWidth(targetId, action) {
        var mainCardElements = $('#' + targetId).parent();
        switch (action) {
            case 0:
                // check view radio selection and make css changes
                var radioViewGroup = $('input[type=radio][name=view-buttons]:checked');
                switch (radioViewGroup.val()) {
                    case 'list':
                        // enable list view
                        mainCardElements.removeClass('w-49');
                        mainCardElements.addClass('w-100');
                        break;
                    case 'grid':
                        // enable grid view
                        mainCardElements.removeClass('w-100');
                        mainCardElements.addClass('w-49');
                        break;
                }
                break;

            default:
                mainCardElements.removeClass('w-49');
                mainCardElements.addClass('w-100');
                break;
        }
    }

    // Fix representation of code snippets json format
    $('[data-codesnippet]').each(function (index) {
        var code = $(this).data('codesnippet').replace(/\'/g, "\""); // Extract info from data-* attributes
        $(this).html(JSON.stringify(JSON.parse(code), null, 4));
    });
});