/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX *\
  Creación: 06-08-2018        |       Última modificación:  06-08-2018
  Autor: Francisco José Montero Campos - fran.montero.campos@gmail.com
  --------------------------------------------------------------------
  Objetivo:
  Función que controla el aviso de "esta web usa cookies".
  Fuente: https://gist.github.com/johnchambers/5a6e67f2d7d39031af17
\* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */


jQuery(function($) {

    checkCookie_eu();

    function checkCookie_eu()
    {

        var consent = getCookie_eu("cookies_consent");

        if (consent == null || consent == "" || consent == undefined)
        {
            // show notification bar
            $('#cookie_directive_container').show();
        }

    }

    function setCookie_eu(c_name,value,exdays)
    {

        var exdate = new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value = escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
        document.cookie = c_name + "=" + c_value+"; path=/";

        $('#cookie_directive_container').hide('slow');
    }


    function getCookie_eu(c_name)
    {
        var i,x,y,ARRcookies=document.cookie.split(";");
        for (i=0;i<ARRcookies.length;i++)
        {
            x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
            y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
            x=x.replace(/^\s+|\s+$/g,"");
            if (x==c_name)
            {
                return unescape(y);
            }
        }
    }

    $("#cookie_accept a").click(function(){
        setCookie_eu("cookies_consent", 1, 30);
    });

});
