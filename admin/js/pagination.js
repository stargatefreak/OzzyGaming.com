var tab = $("table tbody");
var pag = $(".pagination");
var prev = '<li class="previousButton"><a aria-label="Previous" onclick="prevPage()" title="Previous Page"><span aria-hidden="true">&laquo;</span></a></li>';
var first = '<li class="firstButton"><a aria-label="Previous" onclick="changePage(1)" title="First Page"><span aria-hidden="true">&larr;</span></a></li>';
var next = '<li class="nextButton"><a aria-label="Next" onclick="nextPage()" title="Next Page"><span aria-hidden="true">&raquo;</span></a></li></ul>';
var last = '<li class="lastButton"><a aria-label="Next" onclick="changePage('+numPages+')" title="Last Page"><span aria-hidden="true">&rarr;</span></a></li></ul>';

function changePage(page){
    if (page > 0 && page <= numPages){
        currentPage = page;
        redrawPagination();
        redrawTable();
    }
}


function nextPage(){
    if (currentPage < numPages){
        currentPage += 1;
        redrawPagination();
        redrawTable();
    }
}


function prevPage(){
    if (currentPage > 1){
        currentPage -= 1;
        redrawPagination();
        redrawTable();
    }
}

function redrawPagination(){
    // 13 page buttons in display (prev, 5, curr, 5, next)
    var behind = 5;
    var infront = 5;

    // Number of buttons behind
    if (behind - currentPage >= 0){
        behind = behind - (behind - (currentPage-1) );
        infront = infront + (infront - (currentPage-1) );
    }

    // Number of buttons infront
    if (numPages - currentPage < infront){ // 55 - 54 = 1
        behind = ((behind+infront) - (numPages-currentPage)) > currentPage ? currentPage-1 : (behind+infront) - (numPages-currentPage) ;
        infront = numPages - currentPage;
    }

    pag.html("");
    pag.append(first);
    pag.append(prev);
    if (currentPage <= 1){
        pag.find(".previousButton").addClass('disabled');
        pag.find(".firstButton").addClass('disabled');
    }

    // Behind
    for (var i = behind; i >= 1; i--) {
        var num = currentPage - i;
        pag.append('<li onclick="changePage('+num+')"><a>'+num+'</a></li>');
    };

    // Current Page
    pag.append('<li class="active"><a>'+currentPage+'</a></li>');

    // Next
    for (var i = 1; i <= infront; i++){
        var num = currentPage + i;
        pag.append('<li onclick="changePage('+num+')"><a>'+num+'</a></li>');
    }

    pag.append(next);
    pag.append(last);
    if (currentPage >= numPages){
        pag.find(".nextButton").addClass('disabled');
        pag.find(".lastButton").addClass('disabled');
    }
}