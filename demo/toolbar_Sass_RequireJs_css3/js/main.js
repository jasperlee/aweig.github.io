requirejs.config({
    paths:{
        jquery:'jquery-1.12.2.min'
    }
});

requirejs(['jquery','backtop'], function($, backtop){
    //new backtop.BackTop($('#backTop'),{
    //    mode:'go'
    //});
    $('#backTop').backtop({
        mode:'move'
    })
});