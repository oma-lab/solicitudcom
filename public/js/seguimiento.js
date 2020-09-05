function seguimiento(){
    $("#modalseg").modal("show");
}

$(".linka").click(function(event){
	var a = $(this).attr("href");
	$("div.in").removeClass("in active");
	$("li").removeClass("active");
	$(a).addClass("in active");
	$(this).parent().addClass("active");
});