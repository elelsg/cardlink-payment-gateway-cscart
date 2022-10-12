jQuery(document).off("click",".cardlink-remove-card").on("click",".cardlink-remove-card",function (){
    el = jQuery(this);
    answer = window.confirm("Really delete?");
    if(answer){
        el.closest(".payment-cards__field").css("opacity",".5");
        jQuery.post("/",{
            dispatch: "checkout.remove_cardlink_card",
            card_id: el.data('id')
        },function (){
            el.closest(".payment-cards__field").remove();
        });
    }
    return false;
});

jQuery(document).off("change","#cardlink-installments-select").on("change","#cardlink-installments-select",function (){
    jQuery.get("/",{
        dispatch: "checkout.update_installments",
        installments: jQuery(this).val()
    },function (){
        jQuery(".ty-payment-method-iframe__box iframe").attr("src",jQuery(".ty-payment-method-iframe__box iframe").attr("src"));
    });
});