$(document).ready(function(){
    $("a.sidebarItem").click(function(e){
    	$("li").removeClass("active");
    	$(this).parent("li").addClass("active");
        // Get value from input element on the page
        // var numValue = "5";
        var pageID = $(this).attr("href");
        // $.post("test.php",{"page": pageID});
        // Send the input data to the server using get
        $.get("navbaraction.php", {page: pageID} , function(data){
            // Display the returned data in browser
            $("#navbaraction").html(data);
            $("#quiztable").empty();
        });

    });
});

$(document).ready(function(){
    $("div#navbaraction").on("click", "a.dropdown-item", function(){
        // Get value from input element on the page
        // var numValue = "5";
        var quizName = $(this).attr("id");
        // $.post("test.php",{"page": pageID});
        // Send the input data to the server using get
        $.get("viewquizzes.php", {quiz: quizName} , function(data){
            // Display the returned data in browser
            $("#quiztable").html(data);
        });

    });
});
